<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPersonal;
use App\Models\UserInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid as Generator;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        try {
            // create Administrator
            $fullName = 'PBJI';
            $admin = User::firstOrCreate([
                'uuid' => Generator::uuid4()->toString(),
                'id_number' => 20014527,
                'uname' => $this->__createSimpleUsername($fullName),
                'password' => Hash::make('secret'),
            ]);


            // create personal & info data of Administrator
            if (UserPersonal::where('user_id', $admin->id)->doesntExist()) {
                UserPersonal::create([
                    'user_id' => $admin->id,
                    'fullname' => $fullName
                ]);
                // dd($superAdmin);
            }

            // assign role administrator to user
            $adminRole = Role::firstOrCreate([
                'name' => 'Super_Administrator',
                'guard_name' => 'api',
            ]);
            $admin->assignRole($adminRole);




            // create atlet
            $fullName = 'arif';
            $atlet = User::firstOrCreate([
                'uuid' => Generator::uuid4()->toString(),
                'id_number' => 20014521,
                'uname' => $this->__createSimpleUsername($fullName),
                'password' => Hash::make('secret'),
            ]);

            // dd($atlet);
            // die();

            // create personal data of atlet
            if (UserPersonal::where('user_id', $atlet->id)->doesntExist()) {
                UserPersonal::create([
                    'user_id' => $atlet->id,
                    'fullname' => $fullName
                ]);
            }

            // create info data of atlet
            if (UserInfo::where('user_id', $atlet->id)->doesntExist()) {
                Userinfo::create([
                    'user_id' => $atlet->id,
                    'full_addresses' => 'Bambanglipuro, Bantul, Yogyakarta'
                ]);
            }

            // assign role atlet to user
            $atletRole = Role::firstOrCreate([
                'name' => 'Atlet',
                'guard_name' => 'api',
            ]);
            $atlet->assignRole($atletRole);





            // create atlet
            $fullName = 'candia';
            $atlet = User::firstOrCreate([
                'uuid' => Generator::uuid4()->toString(),
                'id_number' => 20014526,
                'uname' => $this->__createSimpleUsername($fullName),
                'password' => Hash::make('secret'),
            ]);

            // create personal data of atlet
            if (UserPersonal::where('user_id', $atlet->id)->doesntExist()) {
                UserPersonal::create([
                    'user_id' => $atlet->id,
                    'fullname' => $fullName
                ]);
            }

            // create info data of atlet
            if (UserInfo::where('user_id', $atlet->id)->doesntExist()) {
                Userinfo::create([
                    'user_id' => $atlet->id,
                    'full_addresses' => 'Turi, Sleman, Yogyakarta'
                ]);
            }

            // assign role atlet to user
            $atletRole = Role::firstOrCreate([
                'name' => 'Atlet',
                'guard_name' => 'api',
            ]);
            $atlet->assignRole($atletRole);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function __createSimpleUsername($str)
    {
        return strtolower(str_replace(' ', '', $str));
    }
}
