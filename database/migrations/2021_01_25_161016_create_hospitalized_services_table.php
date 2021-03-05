<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalizedServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitalized_services', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('diagnosis');
            $table->string('description');
            $table->string('treatment');
            $table->double('cost');
            $table->string('weight');
            $table->string('temperature');
            $table->string('symptoms');
            $table->string('observations');
            // $table->date('initial_date');
            // $table->date('final_date')->nullable();
            $table->unsignedBigInteger('fk_id_pet');
            $table->unsignedBigInteger('fk_id_vet');

            $table->foreign('fk_id_pet')->references('id')->on('pets');
            $table->foreign('fk_id_vet')->references('fk_id_user')->on('vets');

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
        Schema::dropIfExists('hospitalized_services');
    }
}
