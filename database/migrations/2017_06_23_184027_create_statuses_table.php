<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->string('status');
            $table->string('status_type');
            $table->timestamps();
        });

        // Add Student and Enrolment Status to Student Record
        Schema::table('student_records', function($table) {
            $table->integer('student_status_id')->unsigned()->index();
            $table->integer('enrolment_status_id')->unsigned()->index();
            $table->integer('mode_of_study_id')->unsigned()->index();
            $table->integer('programme_type_id')->unsigned()->index();
            $table->integer('funding_type_id')->unsigned()->index();
            
            $table->foreign('student_status_id')->references('id')->on('statuses');
            $table->foreign('enrolment_status_id')->references('id')->on('statuses');
            $table->foreign('mode_of_study_id')->references('id')->on('statuses');
            $table->foreign('programme_type_id')->references('id')->on('statuses');
            $table->foreign('funding_type_id')->references('id')->on('statuses');
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
            $table->dropForeign('student_records_student_status_id_foreign');
            $table->dropColumn('student_status_id');

            $table->dropForeign('student_records_enrolment_status_id_foreign');
            $table->dropColumn('enrolment_status_id');

            $table->dropForeign('student_records_mode_of_study_id_foreign');
            $table->dropColumn('mode_of_study_id');
            
            $table->dropForeign('student_records_programme_type_id_foreign');
            $table->dropColumn('programme_type_id');

            $table->dropForeign('student_records_funding_type_id_foreign');
            $table->dropColumn('funding_type_id');
        });

        Schema::dropIfExists('statuses');
    }
}
