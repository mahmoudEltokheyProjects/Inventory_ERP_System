<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // +++++++++++++++++++ up() +++++++++++++++++++
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            // Add Comment To Table
            $table->comment('جدول الادمن');
            // id
            $table->id();
            $table->string('name') ;
            $table->string('email',100);
            $table->string('username',100);
            $table->string('password',100);
            $table->integer('com_code')->nullable();
            // Foreign key : created_by
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            // Foreign key : updated_by
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            // Foreign key : deleted_by
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('admins');
    }
};
