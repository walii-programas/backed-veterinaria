<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\HospitalizedService;
use Illuminate\Support\Facades\Validator;

class HospitalizedServiceController extends Controller
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
     * @param  \App\Models\HospitalizedService  $hospitalizedService
     * @return \Illuminate\Http\Response
     */
    public function show(HospitalizedService $hospitalizedService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HospitalizedService  $hospitalizedService
     * @return \Illuminate\Http\Response
     */
    public function edit(HospitalizedService $hospitalizedService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HospitalizedService  $hospitalizedService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HospitalizedService $hospitalizedService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HospitalizedService  $hospitalizedService
     * @return \Illuminate\Http\Response
     */
    public function destroy(HospitalizedService $hospitalizedService)
    {
        //
    }

    /* methods */
    public function getHospitalizedServicesByPet($idPet) {
        $hospitalizedServices = HospitalizedService::where('fk_id_pet', $idPet)
            ->orderBy('created_at', 'desc')
            ->get();

        $hospitalizedServicesWitchPetAndVet = [];
        foreach ($hospitalizedServices as $hospitalizedService) {
            $pet = DB::table('pets')
                    ->where('pets.id', $hospitalizedService->fk_id_pet)
                    ->first();
            $vet = DB::table('users')
                    ->join('vets', 'vets.fk_id_user', '=', 'users.id')
                    ->where('vets.fk_id_user', $hospitalizedService->fk_id_vet)
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
            array_push($hospitalizedServicesWitchPetAndVet, [
                'hospitalizedService' => $hospitalizedService,
                'pet' => $pet,
                'vet' => $vet
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $hospitalizedServicesWitchPetAndVet
        ], 200);
    }

    public function getHospitalizedService($idHospitalizedService) {
        $hospitalizedService = HospitalizedService::where('id', $idHospitalizedService)->first();

        return response()->json([
            'success' => true,
            'data' => $hospitalizedService
        ], 200);
    }

    public function postHospitalizedService(Request $request) {
        $validations = Validator::make($request->all(), [
            'diagnosis' => 'required',
            'description' => 'required',
            'treatment' => 'required',
            'cost' => 'required',
            'weight' => 'required',
            'temperature' => 'required',
            'symptoms' => 'required',
            'observations' => 'required',
            // 'initial_date' => 'required',
            // 'final_date' => 'required',
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

        $hospitalizedService = HospitalizedService::create($data);

        return response()->json([
            'success' => true,
            'data' => $hospitalizedService
        ], 201);
    }

    public function putHospitalizedService(Request $request, $idHospitalizedService) {
        $validations = Validator::make($request->all(), [
            'diagnosis' => 'required',
            'description' => 'required',
            'treatment' => 'required',
            'cost' => 'required',
            'weight' => 'required',
            'temperature' => 'required',
            'symptoms' => 'required',
            'observations' => 'required',
            // 'initial_date' => 'required',
            // 'final_date' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Algunos datos son requeridos o no cumplen con los requerimientos para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $hospitalizedService = HospitalizedService::where('id', $idHospitalizedService)->first();

        if ($request->has('diagnosis')) {
            $hospitalizedService->diagnosis = $request['diagnosis'];
        }

        if ($request->has('description')) {
            $hospitalizedService->description = $request['description'];
        }

        if ($request->has('treatment')) {
            $hospitalizedService->treatment = $request['treatment'];
        }

        if ($request->has('cost')) {
            $hospitalizedService->cost = $request['cost'];
        }

        if ($request->has('weight')) {
            $hospitalizedService->weight = $request['weight'];
        }

        if ($request->has('temperature')) {
            $hospitalizedService->temperature = $request['temperature'];
        }

        if ($request->has('symptoms')) {
            $hospitalizedService->symptoms = $request['symptoms'];
        }

        if ($request->has('obervations')) {
            $hospitalizedService->observations = $request['observations'];
        }

        if (!$hospitalizedService->isDirty()) {
            return response()->json([
                'error' => 'Se debe ingresar por lo menos un valor diferente al actualizar',
                'code' => 422
            ], 422);
        }
        
        $hospitalizedService->updated_at = Carbon::now();

        $hospitalizedService->save();

        return response()->json([
            'success' => true,
            'data' => $hospitalizedService
        ], 201);
    }
}
