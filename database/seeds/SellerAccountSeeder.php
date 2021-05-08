<?php

use App\Group;
use App\Permission;
use App\User;
use Illuminate\Database\Seeder;

class SellerAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seller = Group::create(['name'=>'Seller','details'=>'Permissions to work on Poit of sale.']);
        Permission::create([
                    'group_id'  => $seller->id,
                    'customer_add'   => 1,
                    'setting_quick_mail'  => 1,
                    'user_edit'     => 1,
                    'sale_create'    => 1,
                    'refund_create'  => 1,
                    'chapter_open'   => 1,
                    'chapter_close'  => 1,

                   ]);
        User::create(
            [
            'group_id'          => $seller->id,
            'pin'               => '00786',
            'name'              => 'Sammy ',
            'address'           => 'United Kingdom',
            'phone'             => '+1 786 671 8118',
            'company'           => 'Codehas',
            'isActive'          => '1',
            'email'             => 'seller@pos.codehas.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$k0TXIeH2QogJZ.rln.PETefA8uQlxE8vJbzOCsLw3I94ti/.E8Nyi',
            'remember_token'    => Str::random(10),
            'image'             => 'default_img/no_image.png',
            ]
        );
    }
}
