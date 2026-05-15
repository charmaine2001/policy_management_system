<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->string('policy_number')->unique();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->string('insurance_type');
            $table->decimal('premium_amount', 10, 2);
            $table->date('start_date');
            $table->date('renewal_date');
            $table->enum('status', ['Active', 'Expired', 'Pending Renewal'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};
