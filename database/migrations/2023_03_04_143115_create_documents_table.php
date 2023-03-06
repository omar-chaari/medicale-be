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


        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient');
            $table->foreign('patient')
                ->references('id')
                ->on('patients')
                ->onDelete('cascade');
            
            $table->timestamp('date')->nullable();
            $table->string('fichier')->nullable();
            $table->string('description')->nullable();

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
