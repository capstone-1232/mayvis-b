<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueTokenToProposalsTable extends Migration
{
    public function up()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('unique_token')->unique()->nullable();
        });
    }

    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('unique_token');
        });
    }
}
