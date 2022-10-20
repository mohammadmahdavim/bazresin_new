<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoshtibanHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poshtiban_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('exam_id')->unsigned();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->text('targets')->nullable();
            $table->text('debility')->nullable();
            $table->string('quality_face');
            $table->string('quality_performance');
            $table->tinyInteger('quality_face_mark');
            $table->tinyInteger('quality_performance_mark');
            $table->string('date')->nullable();
            $table->string('poshtiban_code');
            $table->string('bazres_code');
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
        Schema::dropIfExists('poshtiban_histories');
    }
}
