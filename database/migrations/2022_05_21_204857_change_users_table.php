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
        Schema::table('users', function (Blueprint $table) {

            //
            $table->unsignedInteger('speciality_id');
            $table->foreign('speciality_id')
                ->references('id')
                ->on('speciality')
                ->onDelete('cascade');

            $table->unsignedInteger('governorate_id');
            $table->foreign('governorate_id')
                    ->references('id')
                    ->on('governorate')
                    ->onDelete('cascade');
        
                    $table->dropColumn('speciality');
                    $table->dropColumn('speciality');


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
