<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VaccineController extends Controller
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
     * @param  \App\Models\Vaccine  $vaccine
     * @return \Illuminate\Http\Response
     */
    public function show(Vaccine $vaccine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vaccine  $vaccine
     * @return \Illuminate\Http\Response
     */
    public function edit(Vaccine $vaccine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vaccine  $vaccine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vaccine $vaccine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vaccine  $vaccine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vaccine $vaccine)
    {
        //
    }

    /* ---------------------------- */
    // methods
    public function getVaccines() {
        $vaccines = Vaccine::all();

        return response()->json([
            'success' => true,
            'data' => $vaccines
        ], 200);
    }

    public function getVaccine($idVaccine) {
        $vaccine = Vaccine::where('id', $idVaccine)->first();

        return response()->json([
            'success' => true,
            'data' => $vaccine
        ], 200);
    }

    // public function getCountUsedVaccines() {
    //     $usedVaccines = DB::table('pet_vaccination_card_vaccine')
    //         ->select(
    //             'vaccine_id',
    //             DB::raw('count(pet_vaccination_card_vaccine.vaccine_id) as quantity')
    //         )
    //         ->groupBy('pet_vaccination_card_vaccine.vaccine_id')
    //         ->get();

    //     return response()->json([
    //         'success' => true,
    //         'data' => $usedVaccines
    //     ], 200);
    // }

    public function getCountUsedVaccines() {
        $usedVaccines = DB::table('pet_vaccination_card_vaccine')
            ->join('vaccines', 'vaccines.id', '=', 'pet_vaccination_card_vaccine.vaccine_id')
            ->select(
                'vaccines.name',
                'pet_vaccination_card_vaccine.vaccine_id',
                DB::raw('count(pet_vaccination_card_vaccine.vaccine_id) as quantity')
            )
            ->groupBy('pet_vaccination_card_vaccine.vaccine_id')
            ->groupBy('vaccines.name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $usedVaccines
        ], 200);
    }

    public function postVaccine(Request $request) {
        $validations = Validator::make($request->all(), [
            'name' => 'required|unique:vaccines'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Algunos datos son requeridos o no cumplen con los requerimientos para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $data = $request->all();

        $vaccine = Vaccine::create($data);

        return response()->json([
            'success' => true,
            'data' => $vaccine
        ], 201);
    }

    public function putVaccine(Request $request, $idVaccine) {
        $vaccine = Vaccine::where('id', $idVaccine)->first();

        if ($request->has['name']) {
            $vaccine->name = $request['name'];
        }

        if (!$vaccine->isDirty()) {
            return response()->json([
                'error' => 'Se debe ingresar por lo menos un valor diferente al actualizar',
                'code' => 422
            ], 422);
        }

        $vaccine->save();

        return response()->json([
            'sucess' => true,
            'data' => $vaccine
        ], 201);
    }
}
