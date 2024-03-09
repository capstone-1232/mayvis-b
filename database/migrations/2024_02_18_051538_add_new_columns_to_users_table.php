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
        Schema::table('users', function (Blueprint $table) {
            $table->string('job_title');
            $table->string('first_name')->after('id'); // Add a 'first_name' column
            $table->string('last_name')->after('first_name'); // Add a 'last_name' column
            $table->dropColumn('name'); // Remove the 'name' column
            $table->string('profile_image')->default('placeholder.jpg');;
            $table->longText('automated_message')->nullable();
            $table->longText('proposal_message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('job_title');
            $table->dropColumn('profile_image');
            $table->dropColumn('automated_message');
            $table->dropColumn('proposal_message');
            $table->dropColumn(['first_name', 'last_name']);
            $table->string('name')->after('id');
        });
    }
};
