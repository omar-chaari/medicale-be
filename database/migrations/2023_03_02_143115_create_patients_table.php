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

        /*

                'first_name',
        'last_name',
        'country',
        'email',
        'password',
        'phone',
        'address',
        'birthday',
        'indicatif_phone',
        'sexe'

        */
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('email')->unique();
            $table->string('last_name');
            $table->string('country');
            $table->string('password');
            $table->string('phone');
            $table->string('address');
            $table->string('birthday');
            $table->string('indicatif_phone');
            $table->string('sexe');

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
        Schema::dropIfExists('admin');
    }
};
