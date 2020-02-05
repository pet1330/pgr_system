<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilestoneTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milestone_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('due')->unsigned();
            $table->integer('milestone_type_id')->unsigned();
            $table->integer('timeline_template_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('timeline_template_id')->references('id')->on('timeline_templates');
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
        Schema::dropIfExists('milestone_templates');
    }
}
