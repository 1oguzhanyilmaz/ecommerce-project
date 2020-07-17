<?php

use App\User;
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
        // User::truncate();

        $permissions = \App\Permission::defaultPermissions();
        foreach ($permissions as $perms) {
            \App\Permission::firstOrCreate(['name' => $perms, 'guard_name'=>'admin']);
        }

        $roleAdmin = \App\Role::create([
            'name' => 'Admin',
            'guard_name' => 'admin'
        ]);
        $roleAdmin->syncPermissions(App\Permission::all());

        $roleEditor = \App\Role::create([
            'name' => 'Editor',
            'guard_name' => 'admin'
        ]);
        $roleEditor->syncPermissions(\App\Permission::where('name', 'LIKE', 'view_%')->get());

        $userArr = [
            'admin' => [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'is_manager' => 1,
            ],
            'editor' => [
                'name' => 'Editor',
                'email' => 'editor@editor.com',
                'password' => bcrypt('password'),
                'is_manager' => 1,
            ],
            'customer' => [
                'name' => 'Customer',
                'email' => 'customer@customer.com',
                'password' => bcrypt('password'),
                'is_manager' => 0,
            ],
        ];

        $adminUser = User::create($userArr['admin']);
        $adminUser->userDetail()->save(new \App\UserDetail());
        $adminUser->assignRole($roleAdmin->name);

        $editorUser = User::create($userArr['editor']);
        $editorUser->userDetail()->save(new \App\UserDetail());
        $editorUser->assignRole($roleEditor->name);

        User::create($userArr['customer'])->userDetail()->save(new \App\UserDetail());

        $customersQuantity = 50;
        factory(User::class, $customersQuantity)->create()->each(function ($user) {
            $user->userDetail()->save(factory(App\UserDetail::class)->make());
        });
    }
}
