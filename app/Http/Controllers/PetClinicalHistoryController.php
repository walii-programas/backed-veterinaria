<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PetClinicalHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PetClinicalHistoryController extends Controller
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
     * @param  \App\Models\PetClinicalHistory  $petClinicalHistory
     * @return \Illuminate\Http\Response
     */
    public function show(PetClinicalHistory $petClinicalHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PetClinicalHistory  $petClinicalHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(PetClinicalHistory $petClinicalHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PetClinicalHistory  $petClinicalHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PetClinicalHistory $petClinicalHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PetClinicalHistory  $petClinicalHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PetClinicalHistory $petClinicalHistory)
    {
        //
    }

    /* -------------- */
    // methods
    public function getPetClinicalHistoriesByPet($idPet) {
        $petClinicalHistories = DB::table('pets')
            ->join('pet_clinical_histories', 'pet_clinical_histories.fk_id_pet', '=', 'pets.id')
            ->where('pet_clinical_histories.fk_id_pet', $idPet)
            ->orderBy('pet_clinical_histories.id', 'desc')
            ->select(
                'pet_clinical_histories.id',
                'pet_clinical_histories.date',
                'pet_clinical_histories.weight',
                'pet_clinical_histories.temperature',
                'pet_clinical_histories.observations'
            )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $petClinicalHistories
        ], 200);
    }

    public function postPetClinicalHistory(Request $request) {
        $validations = Validator::make($request->all(), [
            'weight' => 'required',
            'temperature' => 'required',
            'observations' => 'required',
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
        
        $petClinicalHistory = PetClinicalHistory::create($data);

        return response()->json([
            'success' => true,
            'data' => $petClinicalHistory
        ], 201);
    }
}
