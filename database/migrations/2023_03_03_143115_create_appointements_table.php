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


        Schema::create('appointements', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient');
            $table->foreign('patient')
                ->references('id')
                ->on('patients')
                ->onDelete('cascade');
            $table->unsignedBigInteger('professional');
            $table->foreign('professional')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->timestamp('date_debut')->nullable();
            $table->timestamp('date_fin')->nullable();

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
