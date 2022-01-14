<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone1')->default('-')->after('email');
            $table->string('phone2')->nullable()->default('-')->after('phone1');
            $table->string('address')->default('-')->after('phone2');
            $table->foreignId('category_id')->nullable()->default(1)->after('address');
            $table->json('roles')->after('remember_token')->default(json_encode(['employee','guest']));
            $table->boolean('active')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
