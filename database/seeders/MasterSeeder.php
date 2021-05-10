<?php


namespace Database\Seeders;

use App\Group;
use App\Permission;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterSeeder extends Seeder
{
    /**
     Run the database seeds.

     @return void
     */
    public function run()
    {
        $owner = Group::create(['name'=>'Owner','details'=>'Master Group with Full Permissions']);
        Permission::create(['group_id'=> $owner->id]);
        User::create(
            [
            'group_id'          => $owner->id,
            'pin'               => '00786',
            'name'              => 'Rose Finch',
            'address'           => 'United Kingdom',
            'phone'             => '+1 786 671 8114',
            'company'           => 'codehas.com',
            'isActive'          => '1',
            'email'             => 'owner@pos.codehas.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$k0TXIeH2QogJZ.rln.PETefA8uQlxE8vJbzOCsLw3I94ti/.E8Nyi',
            'remember_token'    => \Str::random(10),
            'image'             => 'default_img/no_image.png',
            ]
        );

        $newUser = Group::create(['name'=>'New User','details'=>'No Permission.']);
        Permission::create(['group_id'=> $newUser->id]);
    }
}
