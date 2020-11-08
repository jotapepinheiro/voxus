<?php

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Location::class, 200)->create()->each(function($u) {
            $u->users()->attach(User::all()->random()->id);
        });
    }
}
