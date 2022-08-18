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
        Schema::table('break', function (Blueprint $table) {
            $table->integer('vote_timing')->default(24);
            $table->integer('rsvp_timing')->default(24);
            $table->integer('rsvp_lock')->nullable()->default(0);
            $table->integer('vote_lock')->nullable()->default(0);
            $table->integer('rsvp_control')->nullable()->default(1);
            $table->integer('vote_control')->nullable()->default(1);
            $table->integer('rsvp_limit')->nullable();
            $table->integer('vote_limit')->nullable()->default(1);
            $table->integer('remind_rsvp')->nullable()->default(1);
            $table->integer('remind_vote')->nullable()->default(1);
            $table->integer('remind_break')->nullable()->default(1);
            $table->integer('invitee_limit')->nullable();
            $table->integer('notify_vote')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('break', function (Blueprint $table) {
            $table->dropColumn('vote_timing');
            $table->dropColumn('rsvp_timing');
            $table->dropColumn('rsvp_lock');
            $table->dropColumn('vote_lock');
            $table->dropColumn('rsvp_control');
            $table->dropColumn('vote_control');
            $table->dropColumn('rsvp_limit');
            $table->dropColumn('vote_limit');
            $table->dropColumn('remind_rsvp');
            $table->dropColumn('remind_vote');
            $table->dropColumn('remind_break');
            $table->dropColumn('invitee_limit');
            $table->dropColumn('notify_vote');
        });
    }
};
