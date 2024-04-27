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
            $table->string('google_id')->nullable();
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
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
            $table->dropColumn('google_id');
            $table->dropColumn('profile_image');
            $table->dropColumn('automated_message');
            $table->dropColumn('proposal_message');
            $table->dropColumn(['first_name', 'last_name']);
        });
    }
};
