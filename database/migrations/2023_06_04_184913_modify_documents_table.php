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
        //
        Schema::table('documents', function (Blueprint $table) {
        // Suppression de la clé étrangère patient
       // $table->dropForeign(['patient']);
        //$table->dropColumn('patient');

        // Création d'une nouvelle clé étrangère consultation
       // $table->unsignedBigInteger('consultation');
        $table->foreign('consultation')->references('id')->on('consultations');    });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
