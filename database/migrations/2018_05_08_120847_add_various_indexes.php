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
            $table->index('last_name')->change();
            $table->index('first_name')->change();
        });
        Schema::table('student_records', function(Blueprint $table)
        {
            $table->index('enrolment_date')->change();
            $table->index('tierFour')->change();
        });
        Schema::table('milestones', function(Blueprint $table)
        {
            $table->index('submitted_date')->change();
            $table->index('name')->change();
            $table->index('non_interuptive_date')->change();
        });
        Schema::table('absences', function(Blueprint $table)
        {
            $table->index('from')->change();
            $table->index('to')->change();
        });
        Schema::table('schools', function(Blueprint $table)
        {
            $table->index('name')->change();
            $table->index('notifications_address')->change();
        });
        Schema::table('student_statuses', function(Blueprint $table)
        {
            $table->index('status')->change();
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
            $table->dropIndex('users_last_name_index')->change();
            $table->dropIndex('users_first_name_index')->change();
        });
        Schema::table('student_records', function(Blueprint $table)
        {
            $table->dropIndex('student_records_enrolment_date_index')->change();
            $table->dropIndex('student_records_tierfour_index')->change();
        });
        Schema::table('milestones', function(Blueprint $table)
        {
            $table->dropIndex('milestones_submitted_date_index')->change();
            $table->dropIndex('milestones_name_index')->change();
            $table->dropIndex('milestones_non_interuptive_date_index')->change();
        });
        Schema::table('absences', function(Blueprint $table)
        {
            $table->dropIndex('absences_from_index')->change();
            $table->dropIndex('absences_to_index')->change();
        });
        Schema::table('schools', function(Blueprint $table)
        {
            $table->dropIndex('schools_name_index')->change();
            $table->dropIndex('schools_notifications_address_index')->change();
        });
        Schema::table('student_statuses', function(Blueprint $table)
        {
            $table->dropIndex('student_statuses_status_index')->change();
        });
    }
}
