<?php

use App\Enums\TicketStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->text('problem_description');
            $table->string('reference_number')->unique();
            $table->enum('status', [
                TicketStatus::NEW->value,
                TicketStatus::OPEN->value,
                TicketStatus::RESOLVE->value,
            ])->default(TicketStatus::NEW->value);
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
