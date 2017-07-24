<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupervisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisors', function (Blueprint $table) {
            $table->integer('staff_id')->unsigned()->index();
            $table->integer('student_record_id')->unsigned()->index();
            
            $table->dateTime('changed_on')->nullable()->default(null);
            $table->smallInteger('supervisor_type')->unsigned();
            
            $table->foreign('staff_id')->references('id')->on('users');
            $table->foreign('student_record_id')->references('id')->on('student_records');

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
        Schema::table('supervisors', function (Blueprint $table) {
            $table->dropForeign('supervisors_student_record_id_foreign');
            $table->dropForeign('supervisors_staff_id_foreign');
        });
        Schema::dropIfExists('supervisors');
    }
}
