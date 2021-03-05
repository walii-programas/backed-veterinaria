<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Cors;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\VetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\SimpleServiceController;
use App\Http\Controllers\PetClinicalHistoryController;
use App\Http\Controllers\PetVaccinationCardController;
use App\Http\Controllers\HospitalizedServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


/*-- AUTH --*/
Route::group([
    'middleware' => [],
    'prefix' => 'auth'

], function () {
    Route::post('/login', [AuthController::class, 'login']);
    // Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});


/*-- ADMIN --*/
Route::group([
    'middleware' => ['jwt.auth'/* 'cors', 'jwt' */],
    'prefix' => 'admin'

], function() {
    // vets
    Route::get('vets', [VetController::class, 'getVets']);
    Route::get('vets/{idVet}', [VetController::class, 'getVet']);
    Route::post('vets', [VetController::class, 'postVet']);
    Route::put('vets/{idPet}', [VetController::Class, 'putVet']);
    Route::put('vets/{idPet}/password', [VetController::class, 'putVetPassword']);
    Route::get('vets/{idPet}/roles', [VetController::class, 'getVetRoles']);
    Route::post('vets/{idUser}/roles/asign', [VetController::class, 'asignRole']);
    Route::post('vets/{idUser}/roles/deny', [VetController::class, 'denyRole']);
    // clients
    Route::get('clients', [ClientController::class, 'getClients']);
    Route::get('clients/{clientId}', [ClientController::class, 'getClient']);
    Route::post('clients', [ClientController::class, 'postClient']);
    Route::put('clients/{clientId}', [ClientController::class, 'putClient']);
    Route::put('clients/{clientId}/password', [ClientController::class, 'putClientPassword']);
    // pets
    Route::get('pets', [PetController::class, 'getPets']);
    Route::get('pets/{idPet}', [PetController::class, 'getPet']);
    Route::get('clients/{clientId}/pets', [PetController::class, 'getPetsByClient']);
    Route::post('pets', [PetController::class, 'postPet']);
    // pet clinical histories
    Route::get('pets/{idPet}/clinical-histories', [PetClinicalHistoryController::class, 'getPetClinicalHistoriesByPet']);
    Route::post('clinical-histories', [PetClinicalHistoryController::class, 'postPetClinicalHistory']);
    // vaccines
    Route::get('vaccines', [VaccineController::class, 'getVaccines']);
    Route::get('vaccines/{idVaccine}', [VaccineController::class, 'getVaccine']);
    Route::post('vaccines', [VaccineController::class, 'postVaccine']);
    Route::put('vaccines/{idVaccine}', [VaccineController::class, 'putVaccine']);
    Route::get('vaccination-card-vaccines/used-quantity', [VaccineController::class, 'getCountUsedVaccines']);
    // pet vaccination card
    Route::get('pets/{idPet}/vaccination-cards', [PetVaccinationCardController::class, 'getPetVaccinationCardsByPet']);
    Route::post('vaccination-cards', [PetVaccinationCardController::class, 'postPetVaccinationCard']);
    // pet vaccination card details
    Route::get('vaccination-cards/{idPetVaccinationCard}/pvcdetails', [PetVaccinationCardController::class, 'getPetVaccinationCardDetailsByPvc']);
    Route::post('vaccination-cards/{idPetVaccinationCard}/pvcdetails', [PetVaccinationCardController::class, 'postPetVaccinationCardDetailToPvc']);
    Route::put('vaccination-cards/{idPetVaccinationCard}/pvcdetails/remove-vaccine', [PetVaccinationCardController::class, 'deletePetVaccinationCardDetailFromPvc']);
    Route::put('vaccination-cards/{idPetVaccinationCard}/pvcdetails/update-vet-state', [PetVaccinationCardController::class, 'putPetVaccinationCardDetailFromPvc']);
    // simple services
    Route::get('pets/{idPet}/simple-services', [SimpleServiceController::class, 'getSimpleServicesByPet']);
    Route::post('simple-services', [SimpleServiceController::class, 'postSimpleService']);
    // hospitalized services
    Route::get('pets/{idPet}/hospitalized-services', [HospitalizedServiceController::class, 'getHospitalizedServicesByPet']);
    Route::get('hospitalized-services/{idHospitalizedService}', [HospitalizedServiceController::class, 'getHospitalizedService']);
    Route::post('hospitalized-services', [HospitalizedServiceController::class, 'postHospitalizedService']);
    Route::put('hospitalized-services/{idHospitalizedService}', [HospitalizedServiceController::class, 'putHospitalizedService']);
    // roles
    Route::get('roles', [RoleController::class, 'getRoles']);
    Route::get('roles/{idRole}', [RoleController::class, 'getRole']);
    Route::post('roles', [RoleController::class, 'postRole']);
    Route::put('roles/{idRole}', [RoleController::class, 'putRole']);
    // blog
    Route::get('blogs', [BlogController::class, 'getBlogs']);
    Route::get('blogs/{idBlog}', [BlogController::class, 'getBlog']);
    Route::post('blogs', [BlogController::class, 'postBlog']);
    Route::put('blogs/{id}', [BlogController::class, 'putBlog']);
    // service
    Route::get('services', [ServiceController::class, 'getServices']);
    Route::get('services/{idService}', [ServiceController::class, 'getService']);
    Route::post('services', [ServiceController::class, 'postService']);
    Route::put('services/{id}', [ServiceController::class, 'putService']);
});

Route::group([
    'prefix' => 'admin'
], function() {
    // vet
    Route::post('vets/forgot-password', [VetController::class, 'vetForgotPassword']);
    Route::put('vets/change-password/{verification_token}', [VetController::class, 'vetChangePassword']);
});

/* -------------------------------------------------------------------------- */

/*--CLIENT --*/

// without jwt
Route::group([
'middleware' => [],
'prefix' => 'client'

], function() {
    // client
    // Route::put('clients/{verification_token}/password-update', [ClientController::class, 'putClientPasswordWithToken']);
    // forgot and change password
    Route::post('clients/forgot-password', [ClientController::class, 'clientForgotPassword']);
    Route::put('clients/change-password/{verification_token}', [ClientController::class, 'clientChangePassword']);
    // blog
    Route::get('blogs', [BlogController::class, 'getBlogs']);
    // service
    Route::get('services', [ServiceController::class, 'getServices']);
});

// with jwt
Route::group([
// 'middleware' => ['jwt.auth'],
'prefix' => 'client'

], function() {
    // pet
    Route::get('clients/{idClient}/pets', [PetController::class, 'getPetsByClient']);
    Route::get('pets/{idPet}', [PetController::class, 'getPet']);
    // simple services
    Route::get('pets/{idPet}/simple-services', [SimpleServiceController::class, 'getSimpleServicesByPet']);
    // hospitalized services
    Route::get('pets/{idPet}/hospitalized-services', [HospitalizedServiceController::class, 'getHospitalizedServicesByPet']);
    // pet vaccination card
    Route::get('pets/{idPet}/vaccination-cards', [PetVaccinationCardController::class, 'getPetVaccinationCardsByPet']);
    // pet vaccination card details
    Route::get('vaccination-cards/{idPetVaccinationCard}/pvcdetails', [PetVaccinationCardController::class, 'getPetVaccinationCardDetailsByPvc']);
    Route::get('vaccination-cards/unvaccinated-vaccines', [PetVaccinationCardController::class, 'getNoVaccinatedVaccinesByClient']);

});
