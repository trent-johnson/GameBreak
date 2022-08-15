<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitee', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('break_id');
            $table->string('email');
            $table->integer('status')->default(0);
            $table->integer('option_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitee');
    }
};
