<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('college_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('college_id')->references('id')->on('colleges');
        });

        // Add School to Student Record
        Schema::table('student_records', function($table) {
            $table->integer('school_id')->unsigned()->index();
            $table->foreign('school_id')->references('id')->on('schools');
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
            $table->dropForeign('student_records_school_id_foreign');
            $table->dropColumn('school_id');
        });

        Schema::dropIfExists('schools');
    }
}
