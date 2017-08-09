<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_statuses', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('student_records', function($table) {
            $table->integer('student_status_id')->unsigned()->index();
            $table->foreign('student_status_id')->references('id')->on('student_statuses');
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
        });

        Schema::drop('student_statuses');
    }
}

