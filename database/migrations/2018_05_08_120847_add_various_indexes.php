<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVariousIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->index('last_name');
            $table->index('first_name');
        });
        Schema::table('student_records', function(Blueprint $table)
        {
            $table->index('enrolment_date');
            $table->index('tierFour');
        });
        Schema::table('milestones', function(Blueprint $table)
        {
            $table->index('submitted_date');
            $table->index('name');
            $table->index('non_interuptive_date');
        });
        Schema::table('absences', function(Blueprint $table)
        {
            $table->index('from');
            $table->index('to');
        });
        Schema::table('schools', function(Blueprint $table)
        {
            $table->index('name');
            $table->index('notifications_address');
        });
        Schema::table('student_statuses', function(Blueprint $table)
        {
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropIndex('last_name');
            $table->dropIndex('first_name');
        });
        Schema::table('student_records', function(Blueprint $table)
        {
            $table->dropIndex('enrolment_date');
            $table->dropIndex('tierFour');
        });
        Schema::table('milestones', function(Blueprint $table)
        {
            $table->dropIndex('submitted_date');
            $table->dropIndex('name');
            $table->dropIndex('non_interuptive_date');
        });
        Schema::table('absences', function(Blueprint $table)
        {
            $table->dropIndex('from');
            $table->dropIndex('to');
        });
        Schema::table('schools', function(Blueprint $table)
        {
            $table->dropIndex('name');
            $table->dropIndex('notifications_address');
        });
        Schema::table('student_statuses', function(Blueprint $table)
        {
            $table->dropIndex('status');
        });
    }
}
