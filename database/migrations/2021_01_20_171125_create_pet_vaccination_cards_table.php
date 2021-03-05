<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetVaccinationCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_vaccination_cards', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('description');
            $table->double('cost')->nullable();
            $table->unsignedBigInteger('fk_id_pet');
            $table->foreign('fk_id_pet')->references('id')->on('pets');

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
        Schema::dropIfExists('pet_vaccination_cards');
    }
}
