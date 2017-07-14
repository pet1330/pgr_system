<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_records', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->integer('student_id')->unsigned()->index();
            $table->string('programme_title')->nullable();
            $table->date('enrolment_date')->nullable();
            $table->boolean('tierFour')->default(false);
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_records');
    }
}
