<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lotteries', function (Blueprint $table) {
            $table->string('ball_start')->nullable()->default(null);
            $table->string('ball_end')->nullable()->default(null);
            $table->string('ball_disable_range')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lotteries', function (Blueprint $table) {
            $table->dropColumn('ball_start');
            $table->dropColumn('ball_end');
            $table->dropColumn('ball_disable_range');
        });
    }
};
