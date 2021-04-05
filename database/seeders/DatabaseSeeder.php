<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            CountryTableSeeder::class,
            CityTableSeeder::class,
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            UsersSeeder::class,
            CarBrandTableSeeder::class,
            FilesTableSeeder::class,
            CatalogTableSeeder::class,
            PurchaseStatusSeeder::class,
            CompanyTableSeeder::class,
            ClientTypeTableSeeder::class,
            ClientGroupTypeTableSeeder::class,
            IndustryTableSeeder::class,
            PurchaseStatusTableSeeder::class,
            PurchasePaymentTypesTableSeeder::class,
            RoleHasPermissions::class
        ]);

        $this->call(SpaceHasRoleTableSeeder::class);
        $this->call(WasteTypesTableSeeder::class);
        $this->call(PermissionsTableSeederNew::class);
    }
}
