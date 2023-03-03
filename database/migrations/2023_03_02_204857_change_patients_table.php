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
        Schema::table('patients', function (Blueprint $table) {

            //
            $table->string("birthday")->nullable()->change();
        

            $table->string('first_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('birthday')->nullable()->change();
            $table->string('indicatif_phone')->nullable()->change();
            $table->string('sexe')->nullable()->change();



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
};
