<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PetVaccinationCard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PetVaccinationCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PetVaccinationCard  $petVaccinationCard
     * @return \Illuminate\Http\Response
     */
    public function show(PetVaccinationCard $petVaccinationCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PetVaccinationCard  $petVaccinationCard
     * @return \Illuminate\Http\Response
     */
    public function edit(PetVaccinationCard $petVaccinationCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PetVaccinationCard  $petVaccinationCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PetVaccinationCard $petVaccinationCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PetVaccinationCard  $petVaccinationCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(PetVaccinationCard $petVaccinationCard)
    {
        //
    }

    /* ----------------------- */
    // methods
    // -- pet vaccination card --
    public function getPetVaccinationCardsByPet($idPet) {
        $petVaccinationCards = DB::table('pet_vaccination_cards')
            ->where('pet_vaccination_cards.fk_id_pet', $idPet)
            ->select(
                'pet_vaccination_cards.id',
                'pet_vaccination_cards.date',
                'pet_vaccination_cards.description',
                'pet_vaccination_cards.cost',
                'pet_vaccination_cards.fk_id_pet'
            )
            ->orderBy('pet_vaccination_cards.id', 'desc')
            ->get();

        // $pppp = PetVaccinationCard::findOrFail($petVaccinationCard[0]->id)->vaccines()->get()[0]->pivot->fk_id_vet;

        // $pppp = PetVaccinationCard::findOrFail($petVaccinationCard[0]->id)->vaccines()->get();

        // return $pppp;

        // $vet = DB::table('users')
        //         ->join('vets', 'vets.fk_id_user', 'users.id')
        //         ->where('vets.fk_id_user', $pppp)
        //         ->select(
        //             'users.firstname',
        //             'users.lastname',
        //             'users.dni',
        //             'vets.cmvp'
        //         )
        //         ->get();

        // return $vet;

        $petVaccinationCardsAndDetails = [];
        // $pvcDetails = [];
        foreach ($petVaccinationCards as $pvc) {
            $vaccines = PetVaccinationCard::findOrFail($pvc->id)->vaccines()->get();

            // $vets = [];
            foreach ($vaccines as $vaccine) {
                $vet = DB::table('users')
                ->join('vets', 'vets.fk_id_user', 'users.id')
                ->where('vets.fk_id_user', $vaccine->pivot->fk_id_vet)
                ->select(
                    'users.firstname',
                    'users.lastname',
                    'users.dni',
                    'vets.cmvp'
                )
                ->first();

                // if ($vet) {
                    $vaccine->pivot->vet = $vet;
                // } else {
                //     $vaccine->pivot->vet = $vet;
                // }
            }
            // array_push($pvcDetails, PetVaccinationCard::findOrFail($pvc->id)->vaccines()->get());
            array_push($petVaccinationCardsAndDetails, [
                'petVaccinationCard' => $pvc,
                'vaccines' => $vaccines
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $petVaccinationCardsAndDetails
        ], 200);
    }

    public function postPetVaccinationCard(Request $request) {
        $validations = Validator::make($request->all(), [
            'description' => 'required',
            // 'cost' => 'required',
            'fk_id_pet' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Algunos datos son requeridos o no cumplen con los requerimientos para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $data = $request->all();
        $data['date'] = Carbon::now();

        $petVaccinationCard = PetVaccinationCard::create($data);

        return response()->json([
            'success' => true,
            'data' => $petVaccinationCard
        ], 201);
    }

    // -- pet vaccination card details --
    public function getPetVaccinationCardDetailsByPvc($idPetVaccinationCard) {
        // $petVaccinationCardsDetail = DB::table('pet_vaccination_card_vaccine')
        //     ->where('pet_vaccination_card_vaccine.pet_vaccination_card_id', $idPetVaccinationCard)
        //     ->select(
        //         'pet_vaccination_card_vaccine.pet_vaccination_card_id',
        //         'pet_vaccination_card_vaccine.vaccine_id',
        //         'pet_vaccination_card_vaccine.fk_id_vet',
        //         'pet_vaccination_card_vaccine.date'
        //     )
        //     ->get();

        $petVaccinationCardDetails = PetVaccinationCard::findOrFail($idPetVaccinationCard)->vaccines()->get();

        return response()->json([
            'success' => true,
            'data' => $petVaccinationCardDetails
        ], 200);
    }

    public function postPetVaccinationCardDetailToPvc(Request $request, $idPetVaccinationCard) {
        $validations = Validator::make($request->all(), [
            'fk_id_vaccine' => 'required',
            'date' => 'required'
        ]);

        $data = $request->all();
        // $data['fk_id_pet_vaccination_card'] = $idPetVaccinationCard;
        // // $data['fk_id_vet'] = $vet.fk_id_user;

        $petVaccinationCard = PetVaccinationCard::findOrFail($idPetVaccinationCard);

        $dateParsed = Carbon::parse($data['date'])->format('Y-m-d');

        $petVaccinationCard->vaccines()->attach($data['fk_id_vaccine'], ['date' => $dateParsed, 'created_at' => Carbon::now()]);

        // $petVaccinationCardDetail = DB::table('pet_vaccination_card_vaccine')
        //     ->where('pet_vaccination_card_vaccine.pet_vaccination_card_id', $idPetVaccinationCard)
        //     ->where('pet_vaccination_card_vaccine.vaccine_id', $data['fk_id_vaccine'])
        //     ->get();

        return response()->json([
            'success' => true,
            // 'data' => $petVaccinationCardDetail
        ], 201);
    }

    public function deletePetVaccinationCardDetailFromPvc(Request $request, $idPetVaccinationCard) {
        $validations = Validator::make($request->all(), [
            'fk_id_vaccine' => 'required',
            'date' => 'required'
        ]);

        $data = $request->all();

        $dateParsed = Carbon::parse($data['date'])->format('Y-m-d');

        // return $petVaccinationCardDetail = DB::table('pet_vaccination_card_vaccine')
        //         ->where('pet_vaccination_card_vaccine.pet_vaccination_card_id', $idPetVaccinationCard)
        //         ->where('pet_vaccination_card_vaccine.vaccine_id', $data['fk_id_vaccine'])
        //         ->whereDate('date', $dateParsed)
        //         ->get();
        
        $petVaccinationCardDetail = DB::table('pet_vaccination_card_vaccine')
        ->where('pet_vaccination_card_vaccine.pet_vaccination_card_id', $idPetVaccinationCard)
        ->where('pet_vaccination_card_vaccine.vaccine_id', $data['fk_id_vaccine'])
        ->whereDate('date', $dateParsed)->delete();
        // ->orderBy('created_at', 'desc')
        // ->first();
        
        // $petVaccinationCardDetail->delete();

        if ($petVaccinationCardDetail == 2) {
            $petVaccinationCard = PetVaccinationCard::findOrFail($idPetVaccinationCard);
            $petVaccinationCard->vaccines()->attach($data['fk_id_vaccine'], ['date' => $dateParsed, 'created_at' => Carbon::now()]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $petVaccinationCardDetail
        ], 201);
    }

    public function putPetVaccinationCardDetailFromPvc(Request $request, $idPetVaccinationCard) {
        $validations = Validator::make($request->all(), [
            'fk_id_vaccine' => 'required',
            'date' => 'required'
            ]);
            
        $data = $request->all();

        $vet = auth()->user();

        $dateParsed = Carbon::parse($data['date'])->format('Y-m-d');

        $petVaccinationCardDetail = DB::table('pet_vaccination_card_vaccine')
        ->where('pet_vaccination_card_vaccine.pet_vaccination_card_id', $idPetVaccinationCard)
        ->where('pet_vaccination_card_vaccine.vaccine_id', $data['fk_id_vaccine'])
        ->whereDate('date', $dateParsed)
        ->update([
            'fk_id_vet' => $vet->id,
            'state' => PetVaccinationCard::VACUNADO
        ]);

        return response()->json([
            'success' => true,
            'data' => $petVaccinationCardDetail
        ], 201);
    }

    public function getNoVaccinatedVaccinesByClient() {
        $client = auth()->user();

        $unvaccinatedVaccines = DB::table('pets')
            ->join('pet_vaccination_cards', 'pet_vaccination_cards.fk_id_pet', '=', 'pets.id')
            ->join('pet_vaccination_card_vaccine', 'pet_vaccination_card_vaccine.pet_vaccination_card_id', '=', 'pet_vaccination_cards.id')
            ->join('vaccines', 'vaccines.id', '=', 'pet_vaccination_card_vaccine.vaccine_id')
            ->where('pets.fk_id_user', $client->id)
            ->where('pet_vaccination_card_vaccine.state', PetVaccinationCard::NO_VACUNADO)
            ->select(
                'pets.id as pet_id',
                'pets.name as pet_name',
                'pet_vaccination_cards.id as pet_vaccination_card_id',
                'pet_vaccination_cards.description as pet_vaccination_card_description',
                'pet_vaccination_card_vaccine.state as pet_vaccination_card_vaccine_state',
                'pet_vaccination_card_vaccine.date as pet_vaccination_card_vaccine_date',
                'vaccines.name as vaccine_name'
            )
            ->orderBy('pet_vaccination_card_vaccine.date', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $unvaccinatedVaccines
        ], 200);
    }
}
