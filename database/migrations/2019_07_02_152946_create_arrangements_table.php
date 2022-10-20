<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrangementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrangements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('zone')->nullable();
            $table->string('hozeh_code')->nullable();
            $table->string('hozeh')->nullable();
            $table->string('modir')->nullable();
            $table->string('modir_mobile')->nullable();
            $table->string('modir_code')->nullable();
            $table->mediumText('address')->nullable();
            $table->string('number_modir')->nullable();
            $table->string('number_poshtiban')->nullable();
            $table->string('total')->nullable();
            $table->string('konkuri')->nullable();
            $table->string('payeh')->nullable();
            $table->string('dabestan')->nullable();
            $table->string('honarestan')->nullable();
            $table->string('leader')->nullable();
            $table->string('leader_code')->nullable();
            $table->string('bazres_code')->nullable();
            $table->string('bazres')->nullable();
            $table->integer('exam_id')->unsigned();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
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
        Schema::dropIfExists('arrangements');
    }
}
