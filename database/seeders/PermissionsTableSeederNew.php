<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeederNew extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permissions')->insert(array(
            99  =>
                array(
                    'id'         => 102,
                    'name'       => 'Просмотр типов растрат',
                    'guard_name' => 'guard_waste_types_view',
                    'created_at' => '2021-02-15 01:58:10',
                    'updated_at' => '2021-02-15 02:00:49',
                    'deleted_at' => null,
                    'desc'       => 'Данное разрешение позволяет просматривать типы растрат',
                ),
            100 =>
                array(
                    'id'         => 103,
                    'name'       => 'Редактирование типов растрат',
                    'guard_name' => 'guard_waste_types_edit',
                    'created_at' => '2021-02-15 01:58:41',
                    'updated_at' => '2021-02-15 02:00:32',
                    'deleted_at' => null,
                    'desc'       => 'Данное разрешение позволяет редактировать типы растрат',
                ),
            101 =>
                array(
                    'id'         => 104,
                    'name'       => 'Просмотр своих отчетов по закупкам',
                    'guard_name' => 'guard_purchaseReports_view_self',
                    'created_at' => '2021-02-17 21:44:27',
                    'updated_at' => '2021-02-17 21:44:27',
                    'deleted_at' => null,
                    'desc'       => 'Данный пункт разрешает просмотр своих отчетов по закупкам',
                ),
            102 =>
                array(
                    'id'         => 105,
                    'name'       => 'Просмотр отчетов по закупкам',
                    'guard_name' => 'guard_purchaseReports_view',
                    'created_at' => '2021-02-17 21:44:59',
                    'updated_at' => '2021-02-17 21:44:59',
                    'deleted_at' => null,
                    'desc'       => 'Данное разрешение позволяет просматривать все отчеты по закупкам',
                ),
            103 =>
                array(
                    'id'         => 106,
                    'name'       => 'Редактирование отчетов по закупкам',
                    'guard_name' => 'guard_purchaseReports_edit',
                    'created_at' => '2021-02-17 21:45:47',
                    'updated_at' => '2021-02-17 21:45:47',
                    'deleted_at' => null,
                    'desc'       => 'Данное разрешение позволяет редактировать все отчеты по закупкам',
                ),
            104 =>
                array(
                    'id'         => 107,
                    'name'       => 'Редактирование своих отчетов по закупкам',
                    'guard_name' => 'guard_purchaseReports_edit_self',
                    'created_at' => '2021-02-17 21:49:12',
                    'updated_at' => '2021-02-17 21:49:12',
                    'deleted_at' => null,
                    'desc'       => 'Позволяет редактировать только своии отчеты по закупкам',
                ),
            105 =>
                array(
                    'id'         => 108,
                    'name'       => 'Создание отчетов по закупке',
                    'guard_name' => 'guard_purchaseReports_add',
                    'created_at' => '2021-02-17 21:54:25',
                    'updated_at' => '2021-02-17 21:54:25',
                    'deleted_at' => null,
                    'desc'       => 'Позволяет создавать отчеты по закупке',
                ),
            106 =>
                array(
                    'id'         => 109,
                    'name'       => 'Изменение роли пользователя',
                    'guard_name' => 'guard_users_roles',
                    'created_at' => '2021-02-17 21:54:25',
                    'updated_at' => '2021-02-17 21:54:25',
                    'deleted_at' => null,
                    'desc'       => 'Данное разрешение позволяет изменять роль пользователя',
                ),
        ));
    }
}