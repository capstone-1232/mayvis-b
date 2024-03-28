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
        Schema::create('drafts', function (Blueprint $table) {
            $table->id();
            $table->timestamps(); // created_at and updated_at are automatically handled
            $table->unsignedBigInteger('user_id');
            $table->string('created_by'); // Creator's name as a string
            $table->string('proposal_title');
            $table->string('status')->default('draft');
            $table->date('start_date');
            $table->longText('automated_message')->nullable();
            $table->string('unique_token')->unique()->nullable();
            $table->decimal('proposal_price', 8, 2)->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('product_id')->nullable(); // Storing a comma-separated list of product IDs as a string
            $table->longText('data')->nullable(); // JSON or serialized string to store additional data
        
            // user_id is a foreign key linking to the users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // client_id is a foreign key linking to the clients table
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drafts');
    }
};
