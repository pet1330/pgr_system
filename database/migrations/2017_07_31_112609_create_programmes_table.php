<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programmes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('duration')->unsigned();
            $table->enum('duration_unit', ['Days', 'Weeks', 'Months', 'Years'])->default('Months');
            $table->softDeletes();
            $table->timestamps();
        });

        // Add Student and Enrolment Status to Student Record
        Schema::table('student_records', function ($table) {
            $table->integer('programme_id')->unsigned()->index();
            $table->foreign('programme_id')->references('id')->on('programmes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_records', function (Blueprint $table) {
            $table->dropForeign('student_records_programme_id_foreign');
            $table->dropColumn('programme_id');
        });

        Schema::drop('programmes');
    }
}
