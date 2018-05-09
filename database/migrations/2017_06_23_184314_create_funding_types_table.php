<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funding_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('student_records', function ($table) {
            $table->integer('funding_type_id')->unsigned()->index();
            $table->foreign('funding_type_id')->references('id')->on('funding_types');
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
            $table->dropForeign('student_records_funding_type_id_foreign');
            $table->dropColumn('funding_type_id');
        });

        Schema::dropIfExists('funding_types');
    }
}
