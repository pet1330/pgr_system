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

            $table->increments('id');
            $table->integer('student_id')->unsigned()->index();
            $table->string('college'); // College of Science
            $table->string('school'); // School of Computer Science
            $table->date('enrolment_date'); // 01/09/2014
            $table->enum('student_status', ['home', 'eu', 'international']); 
            $table->enum('programme', ['phd', 'phd/mphil', 'mSc']); 
            $table->enum('enrolment_status', ['not enrolled', 'enrolled', 'submitted', 'graduated']);
            $table->string('funding_type'); // University, Project, etc...
            $table->enum('mode_of_study', ['full time', 'part time']);
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');

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
