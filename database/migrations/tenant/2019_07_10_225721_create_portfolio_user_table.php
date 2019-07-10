<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfolioUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('portfolio_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('portfolio_id')
                ->references('id')->on('portfolios')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on(config('database.connections.mysql.database') . '.users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portfolio_user');
    }
}
