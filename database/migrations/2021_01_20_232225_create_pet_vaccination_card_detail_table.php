<?php

use Carbon\Carbon;
use App\Models\PetVaccinationCard;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetVaccinationCardDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_vaccination_card_vaccine', function (Blueprint $table) {
            $table->unsignedBigInteger('pet_vaccination_card_id');
            $table->unsignedBigInteger('vaccine_id');
            $table->unsignedBigInteger('fk_id_vet')->nullable();
            $table->date('date')->default(Carbon::today());
            $table->string('state')->default(PetVaccinationCard::NO_VACUNADO);

            $table->foreign('pet_vaccination_card_id')->references('id')->on('pet_vaccination_cards');
            $table->foreign('vaccine_id')->references('id')->on('vaccines');
            $table->timestamps();
            $table->foreign('fk_id_vet')->references('fk_id_user')->on('vets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pet_vaccination_card_detail');
    }
}
