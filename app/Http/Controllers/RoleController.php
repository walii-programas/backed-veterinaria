<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
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
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }

    /* METHODS */
    public function getRoles() {
        $roles = Role::all();

        return response()->json([
            'success' => true,
            'data' => $roles
        ], 200);
    }

    public function getRole($idRole) {
        $role = Role::where('id', $idRole)->first();

        return response()->json([
            'success' => true,
            'data' => $role
        ], 200);
    }

    public function postRole(Request $request) {
        $validations = Validator::make($request->all(), [
            'name' => 'required|unique:roles'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Algunos datos son requeridos o no cumplen con los requerimientos para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $data = $request->all();
        $data['state'] = Role::ROLE_HABILITADO;

        $role = Role::create($data);

        return response()->json([
            'success' => true,
            'data' => $role
        ], 201);
    }

    public function putRole(Request $request, $idRole) {
        $role = Role::where('id', $idRole)->first();

        if ($request->has['name']) {
            $role->name = $request['name'];
        }

        if (!$role->isDirty()) {
            return response()->json([
                'error' => 'Se debe ingresar por lo menos un valor diferente al actualizar',
                'code' => 422
            ], 422);
        }

        $role->save();

        return response()->json([
            'sucess' => true,
            'data' => $role
        ], 201);
    }
}
