<?php

namespace App\Http\Controllers;

use App\Enums\TicketStatus;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contactNumber' => 'nullable|numeric|digits_between:7,15',
            'description' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $normalizedEmail = strtolower($request->input('email'));
            $normalizedName = strtolower($request->input('name'));

            $customer = Customer::whereRaw('lower(email) = ?', [$normalizedEmail])
                ->whereRaw('lower(name) = ?', [$normalizedName])
                ->where('phone_number', $request->input('contactNumber'))
                ->first();

            if (! $customer) {
                $customer = new Customer;
                $customer->name = $request->input('name');
                $customer->email = $request->input('email');
                $customer->phone_number = $request->input('contactNumber');
                $customer->save();
            }

            $ticket = new Ticket;
            $ticket->customer_id = $customer->id;
            $ticket->problem_description = $request->input('description');
            $ticket->reference_number = $this->generateUniqueId();
            $ticket->save();

            DB::commit();

            $ticket->load('customer');

            return response()->json(['ticket' => $ticket], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function generateUniqueId()
    {
        $timestamp = now()->getTimestamp();
        $randomNumber = mt_rand(10000, 99999);
        $uniqueId = base_convert($timestamp, 10, 36).base_convert($randomNumber, 10, 36);

        return strtoupper($uniqueId);
    }

    public function get($id)
    {
        $ticketData = DB::table('tickets')
            ->join('customers', 'tickets.customer_id', '=', 'customers.id')
            ->leftJoin('replies', 'tickets.id', '=', 'replies.ticket_id')
            ->leftJoin('users', 'replies.agent_id', '=', 'users.id')
            ->select(
                'tickets.id as ticket_id',
                'tickets.problem_description',
                'tickets.reference_number',
                'tickets.status',
                'tickets.created_at',
                'customers.id as customer_id',
                'customers.name as customer_name',
                'customers.email as customer_email',
                'customers.phone_number as customer_phone',
                'replies.id as reply_id',
                'replies.message as reply_message',
                'replies.created_at as reply_created_at',
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->where('tickets.id', $id)
            ->get();

        $ticketDetails = $ticketData->reduce(function ($carry, $item) {
            if (! isset($carry['ticket_id'])) {
                $carry = [
                    'ticket_id' => $item->ticket_id,
                    'problem_description' => $item->problem_description,
                    'reference_number' => $item->reference_number,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                    'customer_id' => $item->customer_id,
                    'customer_name' => $item->customer_name,
                    'customer_email' => $item->customer_email,
                    'customer_phone' => $item->customer_phone,
                    'replies' => [],
                ];
            }

            if ($item->reply_id !== null) {
                $carry['replies'][] = [
                    'reply_id' => $item->reply_id,
                    'reply_message' => $item->reply_message,
                    'reply_created_at' => $item->reply_created_at,
                    'user_id' => $item->user_id,
                    'user_name' => $item->user_name,
                    'user_email' => $item->user_email,
                ];
            }

            return $carry;
        }, []);

        return response()->json($ticketDetails);
    }

    public function all(Request $request)
    {
        $query = Ticket::with('customer');

        if ($request->has('customer')) {
            $customer = $request->input('customer');
            $query->whereHas('customer', function ($q) use ($customer) {
                $q->where('name', 'like', "%{$customer}%");
            });
        }

        $tickets = $query->paginate();

        return response()->json($tickets);
    }

    public function open($id)
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->status == TicketStatus::NEW->value) {
            $ticket->status = TicketStatus::OPEN->value;
            $ticket->save();
        }

        return response()->json(null, 200);
    }

    public function reply(Request $request)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'reply' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $ticket = Ticket::findOrFail($validated['ticket_id']);
            $ticket->status = TicketStatus::RESOLVE->value;
            $ticket->save();
            $ticket->replies()->create([
                'agent_id' => Auth::id(),
                'message' => $validated['reply'],
            ]);

            DB::commit();

            return response()->json(null, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return response()->json(null, 500);
        }
    }
}
