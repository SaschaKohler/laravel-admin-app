<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('owner')->default('Dirneder KG')->nullable();
            $table->enum('type',['PKW','Traktor','Mähdrescher','Pritsche','Anhänger','Pickup']);
            $table->string('branding');
            $table->date('permit');
            $table->enum('insurance_type',['Teilkasko','Vollkasko','-'])->default('-');
            $table->date('inspection')->nullable();
            $table->string('insurance_company');
            $table->string('insurance_manager');
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
        Schema::dropIfExists('vehicles');
    }
}
