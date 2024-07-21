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
            $table->tinyInteger('has_special_balls')->default(0);
            $table->string('special_winning_ball')->nullable();
            $table->decimal('special_winning_prize', 28, 8)->default(0);
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
            $table->dropColumn('has_special_balls');
            $table->dropColumn('special_winning_ball');
            $table->dropColumn('special_winning_prize');
        });
    }
};
