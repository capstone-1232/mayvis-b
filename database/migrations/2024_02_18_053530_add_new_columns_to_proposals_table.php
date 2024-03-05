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
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('proposal_title');
            $table->string('status');
            $table->timestamp('start_date');
            $table->foreignId('client_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('product_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            // Drop Client Foreign Key
            $table->dropForeign(['client_id']);

            // Drop User Foreign Key
            $table->dropForeign(['user_id']);

            // Drop Product Foreign Key
            $table->dropForeign(['product_id']);

            $table->dropColumn('proposal_title');
            $table->dropColumn('status');
            $table->dropColumn('start_date');
            $table->dropColumn('client_id');
            $table->dropColumn('user_id');
            $table->dropColumn('product_id');
        });
    }
};
