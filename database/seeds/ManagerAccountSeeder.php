<?php

use App\Group;
use App\Permission;
use App\User;
use Illuminate\Database\Seeder;

class ManagerAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = Group::create(['name'=>'Manager','details'=>'Permissions to manage all resources.']);
        Permission::create([
                    'group_id'  => $manager->id,
                    'product_add'        => 1,
                    'product_manage'     => 1,
                    'product_inventory'  => 1,
                    'category_add'       => 1,
                    'category_manage'    => 1,
                    'subcategory_add'    => 1,
                    'subcategory_manage' => 1,
                    'supplier_add'       => 1,
                    'supplier_manage'    => 1,
                    'customer_add'       => 1,
                    'customer_manage'    => 1,
                    'purchase_add'       => 1,
                    'purchase_manage'    => 1,
                    'expense_add'        => 1,
                    'expense_manage'     => 1,
                    'warehouse_add'      => 1,
                    'warehouse_manage'   => 1,
                    'tax_add'            => 1,
                    'tax_manage'         => 1,
                    'payment_add'        => 1,
                    'payment_manage'     => 1,
                    'sale_manage'    => 1,
                    'refund_manage'  => 1,
                    'payment_manage' => 1,
                    'user_edit'=>1,
                     ]);
        User::create(
            [
            'group_id'          => $manager->id,
            'pin'               => '00786',
            'name'              => 'Ruby Clark',
            'address'           => 'United Kingdom',
            'phone'             => '+1 786 671 8116',
            'company'           => 'Codehas',
            'isActive'          => '1',
            'email'             => 'manager@pos.codehas.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$k0TXIeH2QogJZ.rln.PETefA8uQlxE8vJbzOCsLw3I94ti/.E8Nyi',
            'remember_token'    => Str::random(10),
            'image'             => 'default_img/no_image.png',
            ]
        );
    }
}
