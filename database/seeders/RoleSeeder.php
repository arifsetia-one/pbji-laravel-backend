<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::findOrCreate('Super_Administrator', 'api');
        Role::findOrCreate('Administrator', 'api');

        Role::findOrCreate('Atlet', 'api');
    }
}
