<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrolmentStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolment_statuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });

        // Add Student and Enrolment Status to Student Record
        Schema::table('student_records', function ($table) {
            $table->integer('enrolment_status_id')->unsigned()->index();
            $table->foreign('enrolment_status_id')->references('id')->on('enrolment_statuses');
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
            $table->dropForeign('student_records_enrolment_status_id_foreign');
            $table->dropColumn('enrolment_status_id');
        });

        Schema::drop('enrolment_statuses');
    }
}
