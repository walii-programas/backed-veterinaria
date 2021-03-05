<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Mail\ClientForgotPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailClientConfirmation;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
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
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }

    /* -------------------- */
    /* methods */
    public function getClients() {
        $vets = DB::table('users')
            ->join('clients', 'clients.fk_id_user', '=', 'users.id')
            ->select(
                'users.id',
                'users.firstname',
                'users.lastname',
                'users.dni',
                'users.phone',
                'users.address',
                'users.email',
                'users.state'
            )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $vets
        ], 200);
    }

    public function getClient($idClient) {
        $client = DB::table('users')
            ->join('clients', 'clients.fk_id_user', '=', 'users.id')
            ->where('clients.fk_id_user', $idClient)
            ->select(
                'users.id',
                'users.firstname',
                'users.lastname',
                'users.dni',
                'users.phone',
                'users.address',
                'users.email',
                'users.state'
            )
            ->first();

        return response()->json([
            'success' => true,
            'data' => $client
        ], 200);
    }

    public function postClient(Request $request) {
        $validations = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'dni' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'unique:users',
            // 'password' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Algunos datos son requeridos o no cumplen con los requerimientos para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $data = $request->all();
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $data['verified'] = User::USER_NO_VERIFICADO;
        $data['verification_token'] = User::generateVerificationToken();
        $data['state'] = User::USER_HABILITADO;

        if ($request['email'] != null) {
            Mail::to($data['email'])->send(new EmailClientConfirmation($data));
        }

        $user = User::create($data);

        $client = new Client();
        $client->fk_id_user = $user->id;
        $client->save();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'client' => $client
            ]
        ]);
    }

    public function putClient(Request $request, $clientId) {
        $validations = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'dni' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Algunos datos son requeridos o no cumplen con los requerimientos para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        // $data = $request->all();

        $user = User::where('id', $clientId)->first();

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
            Mail::to($request['email'])->send(new EmailClientConfirmation($user));
        }

        if (!$user->isDirty()) {
            return response()->json([
                'error' => 'Se debe ingresar por lo menos un valor diferente al actualizar',
                'code' => 422
            ], 422);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }

    public function putClientPassword(Request $request, $clientId) {
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

        $user = User::where('id', $clientId)->first();

        $user->password = Hash::make($request['password']);
        $user->save();

        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }

    // public function putClientPasswordWithToken(Request $request, $verification_token) {
    //     $validations = Validator::make($request->all(), [
    //         'password' => 'required'
    //     ]);

    //     if ($validations->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'error' => 'La contraseña es requerida para realizar esta operación',
    //             'code' => 422
    //         ], 422);
    //     }

    //     $user = User::where('verification_token', $verification_token)->first();

    //     $user->password = $request['password'];
    //     $user->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Contraseña actualizada satisfactoriamente'
    //     ]);
    // }

    public function clientForgotPassword(Request $request) {
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

        Mail::to($data['email'])->send(new ClientForgotPassword($data));

        return response()->json([
            'success' => true,
            'message' => 'Correo enviado'
        ], 200);
    }

    public function clientChangePassword(Request $request, $verification_token) {
        $validations = Validator::make($request->all(), [
            'password' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'La contraseña es requerida para realizar esta operacion',
                'code' => 422
            ], 422);
        }

        $data = $request->all();

        $user = User::where('verification_token', $verification_token)->first();

        if ($user == null) {
            return response()->json([
                'success' => false,
                'message' => 'No existe un usuario registrado con el token ingresado'
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
