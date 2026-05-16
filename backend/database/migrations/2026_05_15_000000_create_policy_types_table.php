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
        Schema::create('policy_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();

            // im going to apply some pricing logic so that the price is determined by the category of the policy type

            $table->decimal('standard_price', 10, 2);
            $table->decimal('premium_price', 10, 2);
            // $table->enum('category', ['Standard', 'Premium']);  removed this for proper scalability and flexibility in pricing logic
            $table->text('default_terms')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_types');
    }
};
