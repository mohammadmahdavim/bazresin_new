<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('exam_id')->unsigned();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->string('bazres_code');
            $table->string('poshtiban_code');
            $table->string('modir_code');
            $table->tinyInteger('card')->default(0);
            $table->tinyInteger('hozor_ontime')->default(0);
            $table->tinyInteger('form_bazresi')->default(0);
            $table->tinyInteger('takhteh_nevisi')->default(0);
            $table->tinyInteger('num_barnameh')->default(0);
            $table->tinyInteger('num_khodamoz')->default(0);
            $table->tinyInteger('num_book_tabestan')->default(0);
            $table->tinyInteger('rafe_eshkal')->default(0);
            $table->tinyInteger('num_khodnegari')->default(0);
            $table->tinyInteger('quality_face')->default(0);
            $table->tinyInteger('extera_mark')->default(0);
            $table->integer('total')->default(0);
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
        Schema::dropIfExists('marks');
    }
}
