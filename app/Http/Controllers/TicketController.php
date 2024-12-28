<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Http\Request;
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
}
