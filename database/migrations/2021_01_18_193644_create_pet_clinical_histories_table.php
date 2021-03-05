<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetClinicalHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_clinical_histories', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->double('weight', 3);
            $table->double('temperature', 3);
            $table->string('observations')->nullable();
            $table->foreignId('fk_id_pet')->constrained('pets');

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
        Schema::dropIfExists('pet_clinical_histories');
    }
}
