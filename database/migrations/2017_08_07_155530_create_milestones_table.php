<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milestones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('due')->unsigned();
            $table->dateTime('submission_date')->nullable();
            $table->integer('student_record_id')->unsigned();
            $table->integer('milestone_type_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('student_record_id')->references('id')->on('student_records');
            $table->foreign('milestone_type_id')->references('id')->on('milestone_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milestones');
    }
}
