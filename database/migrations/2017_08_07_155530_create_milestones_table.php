<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->integer('duration')->unsigned();
            $table->enum('duration_unit', ['Days', 'Weeks', 'Months', 'Years'])->default('Months');
            $table->dateTime('submitted_date')->nullable();
            $table->dateTime('due_date')->index();
            $table->dateTime('non_interuptive_date');
            $table->integer('student_record_id')->unsigned();
            $table->integer('milestone_type_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users');
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
