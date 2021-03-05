<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
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
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function edit(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pet $pet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pet $pet)
    {
        //
    }

    /* ---------------------------- */
    // methods
    public function getPets() {
        $pets = Pet::all();

        return response()->json([
            'success' => true,
            'data' => $pets
        ], 200);
    }

    public function getPet($idPet) {
        $pet = Pet::findOrFail($idPet);

        return response()->json([
            'success' => true,
            'data' => $pet
        ], 200);
    }

    public function getPetsByClient($clientId) {
        $pets = DB::table('pets')
            ->where('pets.fk_id_user', $clientId)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pets
        ], 200);
    }

    public function postPet(Request $request) {
        $validations = Validator::make($request->all(), [
            'name' => 'required',
            'species' => 'required',
            'breed' => 'required',
            'color' => 'required',
            'birthdate' => 'required',
            'sex' => 'required',
            // 'photo' => 'required',
            'fk_id_user' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Algunos datos son requeridos o no cumplen con los requerimientos para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $data = $request->all();
        
        $pet = Pet::create($data);

        return response()->json([
            'success' => true,
            'data' => $pet
        ], 201);
    }
}
