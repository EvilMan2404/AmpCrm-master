<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permissions')->delete();

        \DB::table('permissions')->insert(array(
                0  =>
                    array(
                        'id'         => 1,
                        'name'       => 'Первый пермишн',
                        'guard_name' => 'cms_panel',
                        'created_at' => null,
                        'updated_at' => '2021-02-08 02:15:24',
                        'deleted_at' => '2021-02-08 02:15:24',
                        'desc'       => 'Это описание для первого пермишена',
                    ),
                1  =>
                    array(
                        'id'         => 2,
                        'name'       => 'Второй пермишен',
                        'guard_name' => 'catalog',
                        'created_at' => '2021-02-08 00:09:02',
                        'updated_at' => '2021-02-10 16:57:19',
                        'deleted_at' => '2021-02-10 16:57:19',
                        'desc'       => 'Разрешение на редактирование каталога',
                    ),
                2  =>
                    array(
                        'id'         => 3,
                        'name'       => 'Пермишен для клиентов',
                        'guard_name' => 'clients_guard',
                        'created_at' => '2021-02-08 00:22:01',
                        'updated_at' => '2021-02-08 00:22:12',
                        'deleted_at' => '2021-02-08 00:22:12',
                        'desc'       => 'Этот пермишен позволяет делать то и это',
                    ),
                3  =>
                    array(
                        'id'         => 4,
                        'name'       => 'Разрешение 3',
                        'guard_name' => 'guard_third',
                        'created_at' => '2021-02-08 02:16:06',
                        'updated_at' => '2021-02-10 16:57:25',
                        'deleted_at' => '2021-02-10 16:57:25',
                        'desc'       => 'Тут будет описание',
                    ),
                4  =>
                    array(
                        'id'         => 5,
                        'name'       => 'цуацуа',
                        'guard_name' => 'цуацуа',
                        'created_at' => '2021-02-10 18:54:28',
                        'updated_at' => '2021-02-10 19:05:30',
                        'deleted_at' => '2021-02-10 19:05:30',
                        'desc'       => 'уцацуаацу',
                    ),
                5  =>
                    array(
                        'id'         => 6,
                        'name'       => 'Просмотр каталога (общих товаров)',
                        'guard_name' => 'guard_catalog_view',
                        'created_at' => '2021-02-10 21:08:38',
                        'updated_at' => '2021-02-10 21:33:11',
                        'deleted_at' => null,
                        'desc'       => 'Данный пункт разрешает просмотр всего каталога',
                    ),
                6  =>
                    array(
                        'id'         => 7,
                        'name'       => 'Наполнение каталога',
                        'guard_name' => 'guard_catalog_write',
                        'created_at' => '2021-02-10 21:09:20',
                        'updated_at' => '2021-02-10 21:10:10',
                        'deleted_at' => null,
                        'desc'       => 'Данный пункт разрешает добавлене новых товаров в каталог',
                    ),
                7  =>
                    array(
                        'id'         => 8,
                        'name'       => 'Удаление из каталога общих товаров',
                        'guard_name' => 'guard_catalog_delete',
                        'created_at' => '2021-02-10 21:09:58',
                        'updated_at' => '2021-02-10 21:33:08',
                        'deleted_at' => null,
                        'desc'       => 'Данный пункт разрешает удаление товаров из каталога',
                    ),
                8  =>
                    array(
                        'id'         => 9,
                        'name'       => 'Удаление из каталога свох товаров',
                        'guard_name' => 'guard_catalog_delete_self',
                        'created_at' => '2021-02-10 21:33:01',
                        'updated_at' => '2021-02-11 23:23:50',
                        'deleted_at' => null,
                        'desc'       => 'Данный пункт разрешает удаление только свох товаров',
                    ),
                9  =>
                    array(
                        'id'         => 10,
                        'name'       => 'Редактирование своих товаров',
                        'guard_name' => 'guard_catalog_edit_self',
                        'created_at' => '2021-02-10 21:33:55',
                        'updated_at' => '2021-02-11 23:23:19',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать свои товары',
                    ),
                10 =>
                    array(
                        'id'         => 11,
                        'name'       => 'Редактирование общих товаров',
                        'guard_name' => 'guard_catalog_edit',
                        'created_at' => '2021-02-10 21:34:19',
                        'updated_at' => '2021-02-10 21:34:19',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать все товары',
                    ),
                11 =>
                    array(
                        'id'         => 12,
                        'name'       => 'Просмотр своих товаров',
                        'guard_name' => 'guard_catalog_view_self',
                        'created_at' => '2021-02-10 21:35:08',
                        'updated_at' => '2021-02-11 20:00:49',
                        'deleted_at' => null,
                        'desc'       => 'Это разрешение позволяет просматривать только свои товары',
                    ),
                12 =>
                    array(
                        'id'         => 13,
                        'name'       => 'Просмотр компаний фиксирующих курс',
                        'guard_name' => 'guard_company_view',
                        'created_at' => '2021-02-10 22:29:15',
                        'updated_at' => '2021-02-10 22:29:15',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет просматриивать все компании',
                    ),
                13 =>
                    array(
                        'id'         => 14,
                        'name'       => 'Просмотр своих компаний фиксирующих курс',
                        'guard_name' => 'guard_company_view_self',
                        'created_at' => '2021-02-10 22:29:53',
                        'updated_at' => '2021-02-10 22:29:53',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет просматриивать свои компании',
                    ),
                14 =>
                    array(
                        'id'         => 15,
                        'name'       => 'Редактирование компаний фиксирующих курс',
                        'guard_name' => 'guard_company_edit',
                        'created_at' => '2021-02-10 22:30:25',
                        'updated_at' => '2021-02-10 22:30:25',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет редактировать все компании',
                    ),
                15 =>
                    array(
                        'id'         => 16,
                        'name'       => 'Редактрование своих компаний фиксирующих курс',
                        'guard_name' => 'guard_company_edit_self',
                        'created_at' => '2021-02-10 22:31:05',
                        'updated_at' => '2021-02-10 22:31:05',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет редактировать свои компании',
                    ),
                16 =>
                    array(
                        'id'         => 17,
                        'name'       => 'Добавление компаний фиксирующих курс',
                        'guard_name' => 'guard_company_add',
                        'created_at' => '2021-02-10 22:32:50',
                        'updated_at' => '2021-02-10 22:32:50',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет добавлять компании',
                    ),
                17 =>
                    array(
                        'id'         => 18,
                        'name'       => 'Удаление компаний фиксирующих курс',
                        'guard_name' => 'guard_company_delete',
                        'created_at' => '2021-02-10 22:33:26',
                        'updated_at' => '2021-02-10 22:33:26',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет удалять все компании',
                    ),
                18 =>
                    array(
                        'id'         => 19,
                        'name'       => 'Удаление своих компаний фиксирующих курс',
                        'guard_name' => 'guard_company_delete_self',
                        'created_at' => '2021-02-10 22:34:08',
                        'updated_at' => '2021-02-10 22:34:08',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет удалять свои компании',
                    ),
                19 =>
                    array(
                        'id'         => 20,
                        'name'       => 'Просмотр фиксированных курсов',
                        'guard_name' => 'guard_lots_view',
                        'created_at' => '2021-02-10 22:44:03',
                        'updated_at' => '2021-02-10 22:44:03',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет просматривать все фикс. курсы',
                    ),
                20 =>
                    array(
                        'id'         => 21,
                        'name'       => 'Просмотр своих фиксированных курсов',
                        'guard_name' => 'guard_lots_view_self',
                        'created_at' => '2021-02-10 22:44:35',
                        'updated_at' => '2021-02-10 22:44:35',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет просматривать свои фикс. курсы',
                    ),
                21 =>
                    array(
                        'id'         => 22,
                        'name'       => 'Редактирование фиксированных курсов',
                        'guard_name' => 'guard_lots_edit',
                        'created_at' => '2021-02-10 22:45:20',
                        'updated_at' => '2021-02-10 22:45:20',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет редактировать все фикс. курсы',
                    ),
                22 =>
                    array(
                        'id'         => 23,
                        'name'       => 'Редактирование своих фиксированных курсов',
                        'guard_name' => 'guard_lots_edit_self',
                        'created_at' => '2021-02-10 22:46:02',
                        'updated_at' => '2021-02-10 22:46:02',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет редактировать свои фикс. курсы',
                    ),
                23 =>
                    array(
                        'id'         => 24,
                        'name'       => 'Добавление фиксированных курсов',
                        'guard_name' => 'guard_lots_add',
                        'created_at' => '2021-02-10 22:47:53',
                        'updated_at' => '2021-02-10 22:47:53',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет добавлять фикс. курсы',
                    ),
                24 =>
                    array(
                        'id'         => 25,
                        'name'       => 'Удаление фиксированных курсов',
                        'guard_name' => 'guard_lots_delete',
                        'created_at' => '2021-02-10 22:48:36',
                        'updated_at' => '2021-02-10 22:48:36',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет удалять все фикс. курсы',
                    ),
                25 =>
                    array(
                        'id'         => 26,
                        'name'       => 'Удаление своих фиксированных курсов',
                        'guard_name' => 'guard_lots_delete_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешениие позволяет удалять свои фикс. курсы',
                    ),
                26 =>
                    array(
                        'id'         => 27,
                        'name'       => 'Удаление своих закупок',
                        'guard_name' => 'guard_purchase_delete_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет удалять свои закупки',
                    ),
                27 =>
                    array(
                        'id'         => 28,
                        'name'       => 'Удаление закупок',
                        'guard_name' => 'guard_purchase_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет удалять закупки',
                    ),
                28 =>
                    array(
                        'id'         => 29,
                        'name'       => 'Добавлене закупок',
                        'guard_name' => 'guard_purchase_add',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет добавлять закупки',
                    ),
                29 =>
                    array(
                        'id'         => 30,
                        'name'       => 'Просмотр закупок',
                        'guard_name' => 'guard_purchase_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать закупки',
                    ),
                30 =>
                    array(
                        'id'         => 31,
                        'name'       => 'Просмотр своих закупок',
                        'guard_name' => 'guard_purchase_view_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать свои закупки',
                    ),
                31 =>
                    array(
                        'id'         => 32,
                        'name'       => 'Редактирование своих закупок',
                        'guard_name' => 'guard_purchase_edit_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать свои закупки',
                    ),
                32 =>
                    array(
                        'id'         => 33,
                        'name'       => 'Редактирование закупок',
                        'guard_name' => 'guard_purchase_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать закупки',
                    ),
                33 =>
                    array(
                        'id'         => 34,
                        'name'       => 'Управление скидкой',
                        'guard_name' => 'guard_discount',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет управлять скидкой',
                    ),
                34 =>
                    array(
                        'id'         => 35,
                        'name'       => 'Просмотр выдачи финансов сотрудникам',
                        'guard_name' => 'guard_issuance_of_finance_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просмтривать раздел выдачи финансов',
                    ),
                35 =>
                    array(
                        'id'         => 36,
                        'name'       => 'Выдача финансов сотрудникам',
                        'guard_name' => 'guard_issuance_of_finance_add',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 02:23:15',
                        'deleted_at' => '2021-02-13 02:23:15',
                        'desc'       => 'Данное разрешение позволяет выдавать финансы сотрудникам',
                    ),
                36 =>
                    array(
                        'id'         => 37,
                        'name'       => 'Выдача финансов сотрудникам',
                        'guard_name' => 'guard_issuance_of_finance_add',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет выдавать финансы сотрудникам',
                    ),
                37 =>
                    array(
                        'id'         => 38,
                        'name'       => 'Просмотр задач',
                        'guard_name' => 'guard_tasks_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать задачи',
                    ),
                38 =>
                    array(
                        'id'         => 39,
                        'name'       => 'Просмотр своих задач',
                        'guard_name' => 'guard_tasks_view_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать свои задачи',
                    ),
                39 =>
                    array(
                        'id'         => 40,
                        'name'       => 'Добавление задач',
                        'guard_name' => 'guard_tasks_add',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет добавлять задачи',
                    ),
                40 =>
                    array(
                        'id'         => 41,
                        'name'       => 'Редактирование задач',
                        'guard_name' => 'guard_tasks_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать задачи',
                    ),
                41 =>
                    array(
                        'id'         => 42,
                        'name'       => 'Редактирование своих задач',
                        'guard_name' => 'guard_tasks_edit_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать свои задачи',
                    ),
                42 =>
                    array(
                        'id'         => 43,
                        'name'       => 'Удаление своих задач',
                        'guard_name' => 'guard_tasks_delete_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет удалять свои задачи',
                    ),
                43 =>
                    array(
                        'id'         => 44,
                        'name'       => 'Удаление задач',
                        'guard_name' => 'guard_tasks_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет удалять задачи',
                    ),
                44 =>
                    array(
                        'id'         => 45,
                        'name'       => 'Удаление статусов задач',
                        'guard_name' => 'guard_task_statuses_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 12:24:02',
                        'deleted_at' => '2021-02-13 12:24:02',
                        'desc'       => 'Данное разрешение позволяет удалять статусы задач',
                    ),
                45 =>
                    array(
                        'id'         => 46,
                        'name'       => 'Просмотр статусов задач',
                        'guard_name' => 'guard_task_statuses_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 12:25:40',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматриивать статусы задач',
                    ),
                46 =>
                    array(
                        'id'         => 47,
                        'name'       => 'Редактирование статусов задач',
                        'guard_name' => 'guard_task_statuses_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать статусы задач',
                    ),
                47 =>
                    array(
                        'id'         => 48,
                        'name'       => 'Редактирование приоритетов задач',
                        'guard_name' => 'guard_task_priorities_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать приоритеты задач',
                    ),
                48 =>
                    array(
                        'id'         => 49,
                        'name'       => 'Удаление приоритетов задач',
                        'guard_name' => 'guard_task_priorities_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 12:26:24',
                        'deleted_at' => '2021-02-13 12:26:24',
                        'desc'       => 'Данное разрешение позволяет удалять приоритеты задач',
                    ),
                49 =>
                    array(
                        'id'         => 50,
                        'name'       => 'Просмотр приоритетов задач',
                        'guard_name' => 'guard_task_priorities_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 12:27:04',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать приоритеты задач',
                    ),
                50 =>
                    array(
                        'id'         => 51,
                        'name'       => 'Просмотр клиентов',
                        'guard_name' => 'guard_clients_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать клиентов',
                    ),
                51 =>
                    array(
                        'id'         => 52,
                        'name'       => 'Просмотр своих клиентов',
                        'guard_name' => 'guard_clients_view_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать своих клиентов',
                    ),
                52 =>
                    array(
                        'id'         => 53,
                        'name'       => 'Добавление клиентов',
                        'guard_name' => 'guard_clients_add',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет добавлять клиентов',
                    ),
                53 =>
                    array(
                        'id'         => 54,
                        'name'       => 'Редактирование клиентов',
                        'guard_name' => 'guard_clients_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать клиентов',
                    ),
                54 =>
                    array(
                        'id'         => 55,
                        'name'       => 'Редактирование своих клиентов',
                        'guard_name' => 'guard_clients_edit_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать своих клиентов',
                    ),
                55 =>
                    array(
                        'id'         => 56,
                        'name'       => 'Удаление своих клиентов',
                        'guard_name' => 'guard_clients_delete_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет удалять своих клиентов',
                    ),
                56 =>
                    array(
                        'id'         => 57,
                        'name'       => 'Удаление клиентов',
                        'guard_name' => 'guard_clients_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет удалять клиентов',
                    ),
                57 =>
                    array(
                        'id'         => 58,
                        'name'       => 'Просмотр лотов на складе',
                        'guard_name' => 'guard_stock_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать лоты на складе',
                    ),
                58 =>
                    array(
                        'id'         => 59,
                        'name'       => 'Просмотр своих лотов на складе',
                        'guard_name' => 'guard_stock_view_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать своих лотов на складе',
                    ),
                59 =>
                    array(
                        'id'         => 60,
                        'name'       => 'Добавление лотов на складе',
                        'guard_name' => 'guard_stock_add',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет добавлять лоты на складе',
                    ),
                60 =>
                    array(
                        'id'         => 61,
                        'name'       => 'Редактирование лотов на складе',
                        'guard_name' => 'guard_stock_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать лоты на складе',
                    ),
                61 =>
                    array(
                        'id'         => 62,
                        'name'       => 'Редактирование своих лотов на складе',
                        'guard_name' => 'guard_stock_edit_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать свои лоты на складе',
                    ),
                62 =>
                    array(
                        'id'         => 63,
                        'name'       => 'Удаление своих лотов на складе',
                        'guard_name' => 'guard_stock_delete_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет удалять свои лоты на складе',
                    ),
                63 =>
                    array(
                        'id'         => 64,
                        'name'       => 'Удаление лотов на складе',
                        'guard_name' => 'guard_stock_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет удалять лоты на складе',
                    ),
                64 =>
                    array(
                        'id'         => 65,
                        'name'       => 'Просмотр пользователей',
                        'guard_name' => 'guard_users_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать пользователей',
                    ),
                65 =>
                    array(
                        'id'         => 66,
                        'name'       => 'Просмотр своих пользователей',
                        'guard_name' => 'guard_users_view_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать своих пользователей',
                    ),
                66 =>
                    array(
                        'id'         => 67,
                        'name'       => 'Добавление пользователей',
                        'guard_name' => 'guard_users_add',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет добавлять пользователей',
                    ),
                67 =>
                    array(
                        'id'         => 68,
                        'name'       => 'Редактирование пользователей',
                        'guard_name' => 'guard_users_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать пользователей',
                    ),
                68 =>
                    array(
                        'id'         => 69,
                        'name'       => 'Редактирование своих пользователей',
                        'guard_name' => 'guard_users_edit_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать своих пользователей',
                    ),
                69 =>
                    array(
                        'id'         => 70,
                        'name'       => 'Удаление своих пользователей',
                        'guard_name' => 'guard_users_delete_self',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет удалять своих пользователей',
                    ),
                70 =>
                    array(
                        'id'         => 72,
                        'name'       => 'Удаление пользователей',
                        'guard_name' => 'guard_users_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет удалять пользователей',
                    ),
                71 =>
                    array(
                        'id'         => 73,
                        'name'       => 'Изменение команды пользователей',
                        'guard_name' => 'guard_users_teams',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет изменять команду у пользователей',
                    ),
                72 =>
                    array(
                        'id'         => 74,
                        'name'       => 'Редактирование индустрий',
                        'guard_name' => 'guard_industry_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать индустрии',
                    ),
                73 =>
                    array(
                        'id'         => 75,
                        'name'       => 'Удаление индустрий',
                        'guard_name' => 'guard_industry_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:07:39',
                        'deleted_at' => '2021-02-13 14:07:39',
                        'desc'       => 'Данное разрешение позволяет удалять индустрии',
                    ),
                74 =>
                    array(
                        'id'         => 76,
                        'name'       => 'Просмотр индустрий',
                        'guard_name' => 'guard_industry_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:07:54',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать индустрии',
                    ),
                75 =>
                    array(
                        'id'         => 78,
                        'name'       => 'Редактирование брендов',
                        'guard_name' => 'guard_brand_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать бренды',
                    ),
                76 =>
                    array(
                        'id'         => 79,
                        'name'       => 'Удаление брендов',
                        'guard_name' => 'guard_brand_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:14:36',
                        'deleted_at' => '2021-02-13 14:14:36',
                        'desc'       => 'Данное разрешение позволяет удалять бренды',
                    ),
                77 =>
                    array(
                        'id'         => 80,
                        'name'       => 'Просмотр брендов',
                        'guard_name' => 'guard_brand_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:14:20',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать бренды',
                    ),
                78 =>
                    array(
                        'id'         => 81,
                        'name'       => 'Редактирование команд',
                        'guard_name' => 'guard_team_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать команды',
                    ),
                79 =>
                    array(
                        'id'         => 82,
                        'name'       => 'Удаление команд',
                        'guard_name' => 'guard_team_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:16:43',
                        'deleted_at' => '2021-02-13 14:16:43',
                        'desc'       => 'Данное разрешение позволяет удалять команды',
                    ),
                80 =>
                    array(
                        'id'         => 83,
                        'name'       => 'Просмотр команд',
                        'guard_name' => 'guard_team_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:13:57',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать команды',
                    ),
                81 =>
                    array(
                        'id'         => 84,
                        'name'       => 'Редактирование статусов закупки',
                        'guard_name' => 'guard_purchase_statuses_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать статусы закупки',
                    ),
                82 =>
                    array(
                        'id'         => 85,
                        'name'       => 'Удаление статусов закупки',
                        'guard_name' => 'guard_purchase_statuses_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:20:02',
                        'deleted_at' => '2021-02-13 14:20:02',
                        'desc'       => 'Данное разрешение позволяет удалять статусы закупки',
                    ),
                83 =>
                    array(
                        'id'         => 86,
                        'name'       => 'Просмотр статусов закупки',
                        'guard_name' => 'guard_purchase_statuses_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:20:18',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать статусы закупки',
                    ),
                84 =>
                    array(
                        'id'         => 87,
                        'name'       => 'Редактирование типов оплаты закупки',
                        'guard_name' => 'guard_purchase_payment_type_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать типы оплаты закупки',
                    ),
                85 =>
                    array(
                        'id'         => 88,
                        'name'       => 'Удаление типов оплаты закупки',
                        'guard_name' => 'guard_purchase_payment_type_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:24:38',
                        'deleted_at' => '2021-02-13 14:24:38',
                        'desc'       => 'Данное разрешение позволяет удалять типы оплаты закупки',
                    ),
                86 =>
                    array(
                        'id'         => 89,
                        'name'       => 'Просмотр типов оплаты закупки',
                        'guard_name' => 'guard_purchase_payment_type_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:24:59',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматриивать типы оплаты закупки',
                    ),
                87 =>
                    array(
                        'id'         => 90,
                        'name'       => 'Редактирование типов пользователя',
                        'guard_name' => 'guard_client_type_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать типы пользователя',
                    ),
                88 =>
                    array(
                        'id'         => 91,
                        'name'       => 'Удаление типов пользователя',
                        'guard_name' => 'guard_client_type_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:28:41',
                        'deleted_at' => '2021-02-13 14:28:41',
                        'desc'       => 'Данное разрешение позволяет удалять типы пользователя',
                    ),
                89 =>
                    array(
                        'id'         => 92,
                        'name'       => 'Просмотр типов пользователя',
                        'guard_name' => 'guard_client_type_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:29:03',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать типы пользователя',
                    ),
                90 =>
                    array(
                        'id'         => 93,
                        'name'       => 'Редактирование групп пользователя',
                        'guard_name' => 'guard_client_group_type_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать группы пользователя',
                    ),
                91 =>
                    array(
                        'id'         => 94,
                        'name'       => 'Удаление групп пользователя',
                        'guard_name' => 'guard_client_group_type_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:31:23',
                        'deleted_at' => '2021-02-13 14:31:23',
                        'desc'       => 'Данное разрешение позволяет удалять группы пользователя',
                    ),
                92 =>
                    array(
                        'id'         => 95,
                        'name'       => 'Просмотр групп пользователя',
                        'guard_name' => 'guard_client_group_type_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:32:33',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать группы пользователя',
                    ),
                93 =>
                    array(
                        'id'         => 96,
                        'name'       => 'Редактирование ролей',
                        'guard_name' => 'guard_roles_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать роли',
                    ),
                94 =>
                    array(
                        'id'         => 97,
                        'name'       => 'Удаление ролей',
                        'guard_name' => 'guard_roles_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:43:06',
                        'deleted_at' => '2021-02-13 14:43:06',
                        'desc'       => 'Данное разрешение позволяет удалять роли',
                    ),
                95 =>
                    array(
                        'id'         => 98,
                        'name'       => 'Просмотр ролей',
                        'guard_name' => 'guard_roles_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:43:24',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать роли',
                    ),
                96 =>
                    array(
                        'id'         => 99,
                        'name'       => 'Редактирование разрешений',
                        'guard_name' => 'guard_permissions_edit',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-10 22:49:07',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет редактировать разрешения',
                    ),
                97 =>
                    array(
                        'id'         => 100,
                        'name'       => 'Удаление разрешений',
                        'guard_name' => 'guard_permissions_delete',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:36:17',
                        'deleted_at' => '2021-02-13 14:36:17',
                        'desc'       => 'Данное разрешение позволяет удалять разрешения',
                    ),
                98 =>
                    array(
                        'id'         => 101,
                        'name'       => 'Просмотр разрешений',
                        'guard_name' => 'guard_permissions_view',
                        'created_at' => '2021-02-10 22:49:07',
                        'updated_at' => '2021-02-13 14:37:03',
                        'deleted_at' => null,
                        'desc'       => 'Данное разрешение позволяет просматривать разрешения',
                    )
            )
        );
    }
}