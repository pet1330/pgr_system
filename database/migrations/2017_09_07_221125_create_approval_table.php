<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('approved')->nullable();
            $table->text('reason')->nullable();
            $table->string('approvable_id');
            $table->string('approvable_type');
            $table->integer('approved_by_id')->unsigned();
            $table->dateTime('approved_on')->nullable();
            $table->string('approved_name')->nullable();
            $table->timestamps();
            $table->foreign('approved_by_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('approvals', function (Blueprint $table) {
            $table->dropForeign('approvals_approved_by_id_foreign');
        });
        Schema::drop('approvals');
    }
}
