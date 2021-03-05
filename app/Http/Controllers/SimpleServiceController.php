<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SimpleService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SimpleServiceController extends Controller
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
     * @param  \App\Models\SimpleService  $simpleService
     * @return \Illuminate\Http\Response
     */
    public function show(SimpleService $simpleService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SimpleService  $simpleService
     * @return \Illuminate\Http\Response
     */
    public function edit(SimpleService $simpleService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SimpleService  $simpleService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SimpleService $simpleService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SimpleService  $simpleService
     * @return \Illuminate\Http\Response
     */
    public function destroy(SimpleService $simpleService)
    {
        //
    }

    /* methods */
    public function getSimpleServicesByPet($idPet) {
        $simpleServices = SimpleService::where('fk_id_pet', $idPet)
            ->orderBy('created_at', 'desc')
            ->get();

        $simpleServicesWitchPetAndVet = [];
        foreach ($simpleServices as $simpleService) {
            $pet = DB::table('pets')
                    ->where('pets.id', $simpleService->fk_id_pet)
                    ->first();
            $vet = DB::table('users')
                    ->join('vets', 'vets.fk_id_user', '=', 'users.id')
                    ->where('vets.fk_id_user', $simpleService->fk_id_vet)
                    ->select(
                        'users.id',
                        'users.firstname',
                        'users.lastname',
                        'users.dni',
                        'users.phone',
                        'users.address',
                        'users.email',
                        'vets.cmvp'
                    )
                    ->first();
            array_push($simpleServicesWitchPetAndVet, [
                'simpleService' => $simpleService,
                'pet' => $pet,
                'vet' => $vet
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $simpleServicesWitchPetAndVet
        ], 200);
    }

    public function postSimpleService(Request $request) {
        $validations = Validator::make($request->all(), [
            'name' => 'required',
            // 'description' => 'required',
            // 'treatment' => 'required',
            'cost' => 'required',
            'weight' => 'required',
            // 'temperature' => 'required',
            // 'symptoms' => 'required',
            // 'observations' => 'required',
            'fk_id_pet' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Algunos datos son requeridos o no cumplen con los requerimientos para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $vet = auth()->user();

        $data = $request->all();
        $data['date'] = Carbon::now();
        $data['fk_id_vet'] = $vet->id;

        // return $data;

        $simpleService = SimpleService::create($data);

        return response()->json([
            'success' => true,
            'data' => $simpleService
        ], 201);
    }
}
