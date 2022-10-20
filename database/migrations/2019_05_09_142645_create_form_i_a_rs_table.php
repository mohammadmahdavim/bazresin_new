<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormIARsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('modir_code');
            $table->string('bazres_code');
            $table->string('img_signature');
            $table->integer('exam_id')->unsigned();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->string('hozeh_code');
            $table->string('date');
            $table->integer('mark');
            $table->tinyInteger('status')->default(0);

            $table->string('img_signature_bazres')->nullable();
            $table->mediumText('modir_ghayeb')->nullable();
            $table->mediumText('modir_moteakher')->nullable();
            $table->mediumText('poshtiban_ghayeb')->nullable();
            $table->mediumText('poshtiban_moteakher')->nullable();
            $table->mediumText('poshtiban_amozeshi')->nullable();
            $table->mediumText('shakhes_ghovat')->nullable();
            $table->mediumText('ekhtelal_nazm')->nullable();
            $table->mediumText('arzyabi')->nullable();
            $table->string('mark_nazm')->nullable();
            $table->string('mark_performance')->nullable();

            $table->timestamps();
        });


        Schema::create('question_iar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question');
            $table->string('description')->nullable();
            $table->integer('mark');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('type')->default(0);
            $table->timestamps();
        });


        Schema::create('details_iar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('iar_id')->unsigned();
            $table->foreign('iar_id')->references('id')->on('iar')->onDelete('cascade');
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('question_iar')->onDelete('cascade');
            $table->string('description');
            $table->integer('mark');
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
        Schema::dropIfExists('iar');
        Schema::dropIfExists('question_iar');
        Schema::dropIfExists('details_iar');
    }
}
