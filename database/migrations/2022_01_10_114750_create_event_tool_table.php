<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventToolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_tool', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')
                ->references('id')
                ->on('events')->onDelete('cascade');
            $table->foreignId('tool_id')
                ->references('id')
                ->on('tools')->onDelete('cascade');;
            $table->unsignedDecimal('hours')->nullable();
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
        Schema::dropIfExists('event_tools');
    }
}
