<?php
namespace Database\Seeders;

use App\Group;
use App\Permission;
use App\User;
use Illuminate\Database\Seeder;

class PurchaserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $purchaser = Group::create(['name'=>'Purchaser','details'=>'Permissions to manage purchase orders.']);
        Permission::create([
                    'group_id'  => $purchaser->id,
                    'purchase_add'       => 1,
                    'purchase_manage'    => 1,
                    'purchase_summary'   => 1,
                    'purchase_report'    => 1,
                    'setting_quick_mail'  => 1,
                    'user_edit'     => 1,

                    ]);
        User::create(
            [
            'group_id'          => $purchaser->id,
            'pin'               => '00786',
            'name'              => 'Octavia Bell',
            'address'           => 'United Kingdom',
            'phone'             => '+1 786 671 8117',
            'company'           => 'Codehas',
            'isActive'          => '1',
            'email'             => 'purchaser@pos.codehas.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$k0TXIeH2QogJZ.rln.PETefA8uQlxE8vJbzOCsLw3I94ti/.E8Nyi',
            'remember_token'    => \Str::random(10),
            'image'             => 'default_img/no_image.png',
            ]
        );
    }
}
