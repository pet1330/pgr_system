<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('absence_type_id')->unsigned()->index();
            $table->datetime('from');
            $table->datetime('to');
            $table->boolean('approval_required')->default(True);
            $table->boolean('approval_granted')->nullable();
            $table->integer('approved_by')->unsigned()->nullable();
            $table->datetime('approved_on')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('absence_type_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->dropForeign('absences_absence_type_id_foreign');
        });
        Schema::dropIfExists('absences');
    }
}
