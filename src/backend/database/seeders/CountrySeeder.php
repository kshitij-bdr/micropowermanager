<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use MPM\DatabaseProxy\DatabaseProxyManagerService;

class CountrySeeder extends Seeder {
    public function __construct(
        private DatabaseProxyManagerService $databaseProxyManagerService,
    ) {
        $this->databaseProxyManagerService->buildDatabaseConnectionDemoCompany();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $country = Storage::disk('local')->get('countries.json');
        $countries = json_decode($country, true);

        if (is_array($countries)) {
            foreach ($countries as $code => $name) {
                // Use the Country factory to create a new record
                Country::factory()->create([
                    'country_code' => $code,
                    'country_name' => $name,
                ]);
            }
        } else {
            $this->command->error('Unable to decode countries.json. Please ensure it is valid JSON.');
        }
    }
}
