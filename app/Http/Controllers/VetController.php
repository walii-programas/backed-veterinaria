<?php

namespace App\Http\Controllers;

use App\Models\Vet;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\VetForgotPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class VetController extends Controller
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
     * @param  \App\Models\Vet  $vet
     * @return \Illuminate\Http\Response
     */
    public function show(Vet $vet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vet  $vet
     * @return \Illuminate\Http\Response
     */
    public function edit(Vet $vet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vet  $vet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vet $vet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vet  $vet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vet $vet)
    {
        //
    }

    /* -------------------- */
    // methods
    public function getVets() {
        $vets = DB::table('users')
            ->join('vets', 'vets.fk_id_user', '=', 'users.id')
            ->select(
                'users.id',
                'users.firstname',
                'users.lastname',
                'users.dni',
                'users.phone',
                'users.address',
                'users.email',
                'users.state',
                'vets.cmvp'
            )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $vets
        ], 200);
    }

    public function getVet($idVet) {
        $vet = DB::table('users')
            ->join('vets', 'vets.fk_id_user', '=', 'users.id')
            ->where('vets.fk_id_user', $idVet)
            ->select(
                'users.id',
                'users.firstname',
                'users.lastname',
                'users.dni',
                'users.phone',
                'users.address',
                'users.email',
                'users.state',
                'vets.cmvp'
            )
            ->first();

            return response()->json([
                'success' => true,
                'data' => $vet
            ], 200);
    }

    public function getVetRoles($idVet) {
        $vetRoles = User::findOrFail($idVet)->roles()->get();

        return response()->json([
            'success' => true,
            'data' => $vetRoles
        ], 200);
    }

    public function getVetsRoles() {
        $vets = DB::table('vets')
            ->select(
                'vets.fk_id_user',
                'vets.cmvp'
            )
            ->get();

        $rolesAndVets = [];
        foreach ($vets as $vet) {
            $roles = User::find($vet->fk_id_user)->roles()->get();
            array_push($rolesAndVets, [
                'vet' => $vet,
                'roles' => $roles
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $rolesAndVets
        ], 200);
    }

    public function postVet(Request $request) {
        $validations = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'dni' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'cmvp' => 'required|unique:vets'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Algunos datos son requeridos o no cumplen con los requerimientos para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['verified'] = User::USER_NO_VERIFICADO;
        $data['verification_token'] = User::generateVerificationToken();
        $data['state'] = User::USER_HABILITADO;

        $user = User::create($data);

        $vet = new Vet();
        $vet->fk_id_user = $user->id;
        $vet->cmvp = $data['cmvp'];
        $vet->save();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'vet' => $vet
            ]
        ]);
    }

    public function putVet(Request $request, $vetId) {
        $validations = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'dni' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'unique:users,email,' . $vetId,
            'cmvp' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Algunos datos son requeridos o no cumplen con los requerimientos para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $user = User::where('id', $vetId)->first();
        // $vet = Vet::where('fk_id_user', $vetId)->first();
        $vet = $user->vet()->first();

        if ($request->has('firstname')) {
            $user->firstname = $request['firstname'];
        }

        if ($request->has('lastname')) {
            $user->lastname = $request['lastname'];
        }

        if ($request->has('dni')) {
            $user->dni = $request['dni'];
        }

        if ($request->has('phone')) {
            $user->phone = $request['phone'];
        }

        if ($request->has('address')) {
            $user->address = $request['address'];
        }

        if ($request->has('email') && $user->email != $request['email']) {
            $user->email = $request['email'];
        }

        if ($request->has('cmvp')) {
            $vet->cmvp = $request['cmvp'];
        }

        if (!$user->isDirty() && !$vet->isDirty() /* $vet->cmvp != $request['cmvp'] */) {
            return response()->json([
                'error' => 'Se debe ingresar por lo menos un valor diferente al actualizar',
                'code' => 422
            ], 422);
        }

        // if (!$vet->isDirty()) {
        //     return response()->json([
        //         'error' => 'Se debe ingresar por lo menos un valor diferente al actualizar',
        //         'code' => 422
        //     ], 422);
        // }

        $user->save();
        // $vet->save();
        DB::table('vets')
            ->where('fk_id_user', $vetId)
            ->update([
                'cmvp' => $request['cmvp']
            ]);

        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }

    public function putVetPassword(Request $request, $vetId) {
        $validations = Validator::make($request->all(), [
            'password' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Algunos datos son requeridos o no cumplen con los requerimientos para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $user = User::find($vetId)->first();

        $user->password = Hash::make($request['password']);
        $user->save();

        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }

    public function asignRole(Request $request, $idUser) {
        $user = User::findOrFail($idUser);

        $user->roles()->attach($request['id_role']);

        return response()->json([
            'success' => true,
            'data' => $user->roles()->get()
        ], 201);
    }

    public function denyRole(Request $request, $idUser) {
        $user = User::findOrFail($idUser);

        $user->roles()->detach($request['id_role']);

        return response()->json([
            'success' => true,
            'data' => $user->roles()->get()
        ], 201);
    }

    public function vetForgotPassword(Request $request) {
        $validations = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'El correo es requerido para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $data = $request->all();

        $user = User::where('email', $request['email'])->first();

        if ($user == null) {
            return response()->json([
                'success' => false,
                'message' => 'No existe un usuario registrado con el correo ingresado'
            ], 400);
        }

        $data['verification_token'] = $user->verification_token;

        Mail::to($data['email'])->send(new VetForgotPassword($data));

        return response()->json([
            'success' => true,
            'message' => 'Correo enviado'
        ], 200);
    }

    public function vetChangePassword(Request $request, $verification_token) {
        $validations = Validator::make($request->all(), [
            'password' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'El correo es requerido para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $data = $request->all();

        $user = User::where('verification_token', $verification_token)->first();

        if ($user == null) {
            return response()->json([
                'success' => false,
                'message' => 'No existe un usuario registrado con el correo ingresado'
            ], 400);
        }

        $user->password = Hash::make($data['password']);
        $user->verification_token = User::generateVerificationToken();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Contraseña actualizada'
        ], 201);
    }
}
