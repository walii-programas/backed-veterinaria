<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
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
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }

    /* methods */

    public function getservices() {
        $services = Service::all();

        return response()->json([
            'sucess' => true,
            'data' => $services
        ], 200);
    }

    public function getService($idService) {
        $service = Service::where('id', $idService)->first();

        return response()->json([
            'success' => true,
            'data' => $service
        ], 200);
    }

    public function postservice(Request $request) {
        $validations = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Algunos datos son requeridos o no cumplen con los requerimientos para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $data = $request->all();

        $service = service::create($data);

        return response()->json([
            'success' => true,
            'data' => $service
        ], 201);
    }

    public function putservice(Request $request, $idservice) {
        $service = service::where('id', $idservice)->first();

        if ($request->has('title')) {
            $service->title = $request['title'];
        }

        if ($request->has('description')) {
            $service->description = $request['description'];
        }

        if ($request->has('image')) {
            $service->image = $request['image'];
        }

        if (!$service->isDirty()) {
            return response()->json([
                'error' => 'Se debe ingresar por lo menos un valor diferente al actualizar',
                'code' => 422
            ], 422);
        }

        $service->save();

        return response()->json([
            'sucess' => true,
            'data' => $service
        ], 201);
    }
}
