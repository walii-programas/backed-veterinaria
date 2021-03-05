<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\Vet;
use App\Models\Blog;
use App\Models\Role;
use App\Models\User;
use App\Models\Client;
use App\Models\Service;
use App\Models\Vaccine;
use App\Models\SimpleService;
use Illuminate\Database\Seeder;
use App\Models\PetClinicalHistory;
use App\Models\PetVaccinationCard;
use App\Models\HospitalizedService;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // vars
        $userQuantity = 5;
        $clientQuantity = 3;
        $vetQuantity = 2;
        $petQuantity = 10;
        $petClinicHistoryQuantity = 20;
        $vaccinesQuantity = 15;
        $petVaccinationCardQuantity = 10;
        $simpleServiceQuantity = 15;
        $hospitalizedService = 10;
        $roleQuantity = 2;
        $blogQuantity = 3;
        $serviceQuantity = 4;

        // exec factories
        Role::factory()->times($roleQuantity)->create();
        User::factory()->times($userQuantity)->create()->each(
            function($user) {
                $roles = Role::all()->random(mt_rand(1,2))->pluck('id');
                $user->roles()->attach($roles);
            }
        );
        Vet::factory()->times($vetQuantity)->create();
        Client::factory()->times($clientQuantity)->create();

        Pet::factory()->times($petQuantity)->create();
        PetClinicalHistory::factory()->times($petClinicHistoryQuantity)->create();

        Vaccine::factory()->times($vaccinesQuantity)->create();
        PetVaccinationCard::factory()->times($petVaccinationCardQuantity)->create()->each(
            function($pvc) {
                $vaccines = Vaccine::all()->random(mt_rand(1,8))->pluck('id');
                $pvc->vaccines()->attach($vaccines);
            }
        );

        SimpleService::factory()->times($simpleServiceQuantity)->create();
        HospitalizedService::factory()->times($hospitalizedService)->create();

        Blog::factory()->times($blogQuantity)->create();
        Service::factory()->times($serviceQuantity)->create();

    }
}
