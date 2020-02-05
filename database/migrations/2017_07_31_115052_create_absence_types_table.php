<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absence_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->boolean('interuption')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('absences', function ($table) {
            $table->integer('absence_type_id')->unsigned()->index();
            $table->foreign('absence_type_id')->references('id')->on('absence_types');
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
            $table->dropColumn('absence_type_id');
        });

        Schema::drop('absence_types');
    }
}
