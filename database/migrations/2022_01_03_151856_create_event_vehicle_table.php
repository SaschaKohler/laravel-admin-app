<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_vehicle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->references('id')
                ->on('events')->onDelete('cascade');
            $table->foreignId('vehicle_id')->references('id')
                ->on('vehicles')->onDelete('cascade');
            $table->unsignedBigInteger('kmBegin')->nullable()->default(0);
            $table->unsignedBigInteger('kmEnd')->nullable()->default(0);
            $table->unsignedBigInteger('kmSum')->nullable()->default(0);
            $table->unsignedDecimal('hours')->nullable()->default(0);

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
        Schema::dropIfExists('event_vehicle');
    }
}
