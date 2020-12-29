<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('follewer')->nullable();
            $table->string('is_following')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
