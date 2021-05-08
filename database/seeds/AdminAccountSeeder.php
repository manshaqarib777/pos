<?php

use App\Group;
use App\Permission;
use App\User;
use Illuminate\Database\Seeder;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Group::create(['name'=>'Admin','details'=>'Admin,having administrative access.']);
        Permission::create([
                    'group_id'  => $admin->id,
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
                    'purchase_summary'   => 1,
                    'purchase_report'    => 1,
                    'expense_add'        => 1,
                    'expense_manage'     => 1,
                    'expense_summary'    => 1,
                    'warehouse_add'      => 1,
                    'warehouse_manage'   => 1,
                    'tax_add'                   => 1,
                    'tax_manage'         => 1,
                    'tax_summary'        => 1,
                    'tax_report'         => 1,
                    'setting_view'       => 1,
                    'setting_product_default' => 1,
                    'setting_impects'      => 1,
                    'setting_pos'      => 1,
                    'setting_backup'     => 1,
                    'setting_dashboard'  => 1,
                    'setting_quick_mail'  => 1,
                    'user_create'   => 1,
                    'user_manage'   => 1,
                    'user_edit'     => 1,
                    'group_add'     => 1,
                    'group_manage'  => 1,
                    'group_request' => 1,
                    'sale_create'    => 1,
                    'sale_manage'    => 1,
                    'sale_summary'   => 1,
                    'sale_report'    => 1,
                    'refund_create'  => 1,
                    'refund_manage'  => 1,
                    'refund_summary' => 1,
                    'payment_add'    => 1,
                    'payment_manage' => 1,
                    'chapter_open'   => 1,
                    'chapter_close'  => 1,
                    'chapter_manage' => 1,
                    'reports_save'   => 1,
                    'reports_view'   => 1,
        ]);
        User::create(
            [
            'group_id'          => $admin->id,
            'pin'               => '00786',
            'name'              => 'Jon Doe',
            'address'           => 'United Kingdom',
            'phone'             => '+1 786 671 8114',
            'company'           => 'Codehas',
            'isActive'          => '1',
            'email'             => 'admin@pos.codehas.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$k0TXIeH2QogJZ.rln.PETefA8uQlxE8vJbzOCsLw3I94ti/.E8Nyi',
            'remember_token'    => Str::random(10),
            'image'             => 'default_img/no_image.png',
            ]
        );
    }
}
