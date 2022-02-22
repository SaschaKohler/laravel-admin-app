<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class CreateEventUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')
                ->references('id')
                ->on('events')->onDelete('cascade');
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');;
            $table->time('hours')->nullable();
            $table->time('startTime')->default(Carbon::parse('07:00')->format('H:i'));
            $table->time('endTime')->nullable()->default(Carbon::parse('16:00')->format('H:i'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_user');
    }
}
