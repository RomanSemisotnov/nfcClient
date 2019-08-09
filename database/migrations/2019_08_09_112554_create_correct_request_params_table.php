<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrectRequestParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correct_request_params', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('correctrequest_id')->unsigned();
            $table->foreign('correctrequest_id')
                ->references('id')->on('correct_requests')
                ->onDelete('cascade');

            $table->integer('queryparam_id')->unsigned();
            $table->foreign('queryparam_id')
                ->references('id')->on('query_params')
                ->onDelete('cascade');

            $table->integer('paramvariable_id')->unsigned();
            $table->foreign('paramvariable_id')
                ->references('id')->on('param_variables')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('correct_request_params');
    }
}
