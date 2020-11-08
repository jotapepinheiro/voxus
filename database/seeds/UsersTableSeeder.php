<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CADATRAR SUPER ADMIN
        User::create([
            'name'              => 'Super',
            'email'             => 'super@super.com',
            'password'          => app('hash')->make('super'),
            'email_verified_at' => Carbon::now()->add(1, 'hour'),
            'created_at'        => Carbon::now()
        ])->roles()->sync([1]);

        // CADATRAR ADMIN
        User::create([
            'name'        => 'Admin',
            'email'       => 'admin@admin.com',
            'password'    => app('hash')->make('admin'),
            'email_verified_at' => Carbon::now()->add(2, 'hour'),
            'created_at'  => Carbon::now()
        ])->roles()->sync([2]);

        // CADATRAR TECNICO
        User::create([
            'name'        => 'Tecnico',
            'email'       => 'tecnico@tecnico.com',
            'password'    => app('hash')->make('tecnico'),
            'email_verified_at' => Carbon::now()->add(2, 'hour'),
            'created_at'  => Carbon::now()
        ])->roles()->sync([3]);

        // CADATRAR 50 USUARIOS TECNICOS
        factory(User::class, 50)->create()->each(function($u) {
            $u->roles()->sync([3]);
        });
    }
}
