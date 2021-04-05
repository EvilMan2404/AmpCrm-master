<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CarBrandTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('car_brand')->delete();
        
        \DB::table('car_brand')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Opel',
                'created_at' => '2021-01-15 21:52:33',
                'updated_at' => '2021-01-15 21:52:33',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'BMW',
                'created_at' => '2021-01-15 21:52:33',
                'updated_at' => '2021-01-15 21:52:33',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'BMW-MINI',
                'created_at' => '2021-01-15 21:52:33',
                'updated_at' => '2021-01-15 21:52:33',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'BMW-OPEL',
                'created_at' => '2021-01-15 21:52:35',
                'updated_at' => '2021-01-15 21:52:35',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'BMW-MINI ARM',
                'created_at' => '2021-01-15 21:52:35',
                'updated_at' => '2021-01-15 21:52:35',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'BMW-UEES',
                'created_at' => '2021-01-15 21:52:36',
                'updated_at' => '2021-01-15 21:52:36',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'N/A',
                'created_at' => '2021-01-15 21:52:37',
                'updated_at' => '2021-01-15 21:52:37',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'BMW MINI',
                'created_at' => '2021-01-15 21:52:39',
                'updated_at' => '2021-01-15 21:52:39',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Chevrolet',
                'created_at' => '2021-01-15 21:52:39',
                'updated_at' => '2021-01-15 21:52:39',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'GM Chevrolet',
                'created_at' => '2021-01-15 21:52:39',
                'updated_at' => '2021-01-15 21:52:39',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Chevrolet-OPEL',
                'created_at' => '2021-01-15 21:52:39',
                'updated_at' => '2021-01-15 21:52:39',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Chevrolet-Daewoo',
                'created_at' => '2021-01-15 21:52:40',
                'updated_at' => '2021-01-15 21:52:40',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Chrysler ',
                'created_at' => '2021-01-15 21:52:40',
                'updated_at' => '2021-01-15 21:52:40',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Crhysler',
                'created_at' => '2021-01-15 21:52:41',
                'updated_at' => '2021-01-15 21:52:41',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Daewoo',
                'created_at' => '2021-01-15 21:52:41',
                'updated_at' => '2021-01-15 21:52:41',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Fiat',
                'created_at' => '2021-01-15 21:52:42',
                'updated_at' => '2021-01-15 21:52:42',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Fiat SEVEL',
                'created_at' => '2021-01-15 21:52:42',
                'updated_at' => '2021-01-15 21:52:42',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Fiat-Opel',
                'created_at' => '2021-01-15 21:52:45',
                'updated_at' => '2021-01-15 21:52:45',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Fiat GM',
                'created_at' => '2021-01-15 21:52:46',
                'updated_at' => '2021-01-15 21:52:46',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Ferrari',
                'created_at' => '2021-01-15 21:52:47',
                'updated_at' => '2021-01-15 21:52:47',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Ford-Mazda',
                'created_at' => '2021-01-15 21:52:50',
                'updated_at' => '2021-01-15 21:52:50',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Ford',
                'created_at' => '2021-01-15 21:52:50',
                'updated_at' => '2021-01-15 21:52:50',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Ford FONOS',
                'created_at' => '2021-01-15 21:52:51',
                'updated_at' => '2021-01-15 21:52:51',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Renault',
                'created_at' => '2021-01-15 21:52:51',
                'updated_at' => '2021-01-15 21:52:51',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'FONOS',
                'created_at' => '2021-01-15 21:52:55',
                'updated_at' => '2021-01-15 21:52:55',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Ford-Jaguar',
                'created_at' => '2021-01-15 21:52:56',
                'updated_at' => '2021-01-15 21:52:56',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Honda',
                'created_at' => '2021-01-15 21:52:57',
                'updated_at' => '2021-01-15 21:52:57',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Iveco',
                'created_at' => '2021-01-15 21:52:58',
                'updated_at' => '2021-01-15 21:52:58',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Jeep',
                'created_at' => '2021-01-15 21:52:58',
                'updated_at' => '2021-01-15 21:52:58',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Lada',
                'created_at' => '2021-01-15 21:52:58',
                'updated_at' => '2021-01-15 21:52:58',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Jaguar',
                'created_at' => '2021-01-15 21:52:58',
                'updated_at' => '2021-01-15 21:52:58',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Land Rover',
                'created_at' => '2021-01-15 21:52:59',
                'updated_at' => '2021-01-15 21:52:59',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Lexus',
                'created_at' => '2021-01-15 21:53:01',
                'updated_at' => '2021-01-15 21:53:01',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Mazda',
                'created_at' => '2021-01-15 21:53:01',
                'updated_at' => '2021-01-15 21:53:01',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Mazda-Ford',
                'created_at' => '2021-01-15 21:53:01',
                'updated_at' => '2021-01-15 21:53:01',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Mazda-Nissan',
                'created_at' => '2021-01-15 21:53:01',
                'updated_at' => '2021-01-15 21:53:01',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'TOYOTA',
                'created_at' => '2021-01-15 21:53:02',
                'updated_at' => '2021-01-15 21:53:02',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'SUZUKI',
                'created_at' => '2021-01-15 21:53:02',
                'updated_at' => '2021-01-15 21:53:02',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Mercedes',
                'created_at' => '2021-01-15 21:53:04',
                'updated_at' => '2021-01-15 21:53:04',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Mercedes-SMART',
                'created_at' => '2021-01-15 21:53:07',
                'updated_at' => '2021-01-15 21:53:07',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Mersedes',
                'created_at' => '2021-01-15 21:53:07',
                'updated_at' => '2021-01-15 21:53:07',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Mercrdes',
                'created_at' => '2021-01-15 21:53:09',
                'updated_at' => '2021-01-15 21:53:09',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Mercedes SMART',
                'created_at' => '2021-01-15 21:53:09',
                'updated_at' => '2021-01-15 21:53:09',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Mitsubishi',
                'created_at' => '2021-01-15 21:53:09',
                'updated_at' => '2021-01-15 21:53:09',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Mitsushi',
                'created_at' => '2021-01-15 21:53:10',
                'updated_at' => '2021-01-15 21:53:10',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'PORSCHE',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'KBA',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'VOLVO',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'HJS',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'BOSAL',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'DAIHATSU',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'UEES',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'ISUZU',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'GAT-EUROCAT',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'SUBARU',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'Pontiac',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'LOTUS',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'MARUTI',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'GM',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'GM FLOW',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'ZARA',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'Sankei SUZUKI',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'VENE PORTE',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'HJS KBA',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'Cats Pipes',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'Cat Pipes',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'SEVEL',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'ZEUNA AUSBURG',
                'created_at' => '2021-01-15 21:53:12',
                'updated_at' => '2021-01-15 21:53:12',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'DELPHI',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'KIA',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'NJS',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'MIVV',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'Eberspacher',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'IECAT',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'CAT Pipers',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            75 => 
            array (
                'id' => 76,
                'name' => ' SUZUKI',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'KTA',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'NICHI-RA',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'ENGELMARD',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'SILVEN N/A ?',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'GM AC',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'PSA',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'CAT-EUROCAT',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'NOVA',
                'created_at' => '2021-01-15 21:53:13',
                'updated_at' => '2021-01-15 21:53:13',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'MAN',
                'created_at' => '2021-01-15 21:53:14',
                'updated_at' => '2021-01-15 21:53:14',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'ISUZU GM',
                'created_at' => '2021-01-15 21:53:14',
                'updated_at' => '2021-01-15 21:53:14',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'CAT-EUROKAT',
                'created_at' => '2021-01-15 21:53:14',
                'updated_at' => '2021-01-15 21:53:14',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'ARMACAT',
                'created_at' => '2021-01-15 21:53:14',
                'updated_at' => '2021-01-15 21:53:14',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'ERNST',
                'created_at' => '2021-01-15 21:53:14',
                'updated_at' => '2021-01-15 21:53:14',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'INLET',
                'created_at' => '2021-01-15 21:53:14',
                'updated_at' => '2021-01-15 21:53:14',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'VENEPORTE',
                'created_at' => '2021-01-15 21:53:14',
                'updated_at' => '2021-01-15 21:53:14',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'JOHN DEERE',
                'created_at' => '2021-01-15 21:53:14',
                'updated_at' => '2021-01-15 21:53:14',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'MOPAR',
                'created_at' => '2021-01-15 21:53:14',
                'updated_at' => '2021-01-15 21:53:14',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'MASERATI',
                'created_at' => '2021-01-15 21:53:14',
                'updated_at' => '2021-01-15 21:53:14',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'Nissan',
                'created_at' => '2021-01-15 21:53:14',
                'updated_at' => '2021-01-15 21:53:14',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'Nissan-Mazda',
                'created_at' => '2021-01-15 21:53:15',
                'updated_at' => '2021-01-15 21:53:15',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'Opel GM',
                'created_at' => '2021-01-15 21:53:18',
                'updated_at' => '2021-01-15 21:53:18',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'Opel USA',
                'created_at' => '2021-01-15 21:53:18',
                'updated_at' => '2021-01-15 21:53:18',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'Opel-Fiat',
                'created_at' => '2021-01-15 21:53:18',
                'updated_at' => '2021-01-15 21:53:18',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'GM Opel ISUZU',
                'created_at' => '2021-01-15 21:53:19',
                'updated_at' => '2021-01-15 21:53:19',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'Opel-USA',
                'created_at' => '2021-01-15 21:53:20',
                'updated_at' => '2021-01-15 21:53:20',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'PSA SEVEL',
                'created_at' => '2021-01-15 21:53:28',
                'updated_at' => '2021-01-15 21:53:28',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'PSA-SEVEL',
                'created_at' => '2021-01-15 21:53:29',
                'updated_at' => '2021-01-15 21:53:29',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'Renault-SUZUKI',
                'created_at' => '2021-01-15 21:53:31',
                'updated_at' => '2021-01-15 21:53:31',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'Reanault',
                'created_at' => '2021-01-15 21:53:37',
                'updated_at' => '2021-01-15 21:53:37',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'Rover',
                'created_at' => '2021-01-15 21:53:40',
                'updated_at' => '2021-01-15 21:53:40',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'Saab',
                'created_at' => '2021-01-15 21:53:41',
                'updated_at' => '2021-01-15 21:53:41',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'SsangYong',
                'created_at' => '2021-01-15 21:53:41',
                'updated_at' => '2021-01-15 21:53:41',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'GM SsangYong',
                'created_at' => '2021-01-15 21:53:41',
                'updated_at' => '2021-01-15 21:53:41',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'Ssang Yong',
                'created_at' => '2021-01-15 21:53:41',
                'updated_at' => '2021-01-15 21:53:41',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'Suzuki/Kia',
                'created_at' => '2021-01-15 21:53:42',
                'updated_at' => '2021-01-15 21:53:42',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'Kia/Hyundai',
                'created_at' => '2021-01-15 21:53:42',
                'updated_at' => '2021-01-15 21:53:42',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'TATA',
                'created_at' => '2021-01-15 21:53:42',
                'updated_at' => '2021-01-15 21:53:42',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'Hyundai',
                'created_at' => '2021-01-15 21:53:42',
                'updated_at' => '2021-01-15 21:53:42',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'Hyundai/Kia',
                'created_at' => '2021-01-15 21:53:45',
                'updated_at' => '2021-01-15 21:53:45',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'Voivo',
                'created_at' => '2021-01-15 21:53:53',
                'updated_at' => '2021-01-15 21:53:53',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'VW',
                'created_at' => '2021-01-15 21:53:54',
                'updated_at' => '2021-01-15 21:53:54',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'SEAT',
                'created_at' => '2021-01-15 21:53:56',
                'updated_at' => '2021-01-15 21:53:56',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'VW-SHKODA',
                'created_at' => '2021-01-15 21:53:57',
                'updated_at' => '2021-01-15 21:53:57',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'AUDI',
                'created_at' => '2021-01-15 21:53:57',
                'updated_at' => '2021-01-15 21:53:57',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'SHKODA',
                'created_at' => '2021-01-15 21:53:59',
                'updated_at' => '2021-01-15 21:53:59',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'VW-SEAT',
                'created_at' => '2021-01-15 21:53:59',
                'updated_at' => '2021-01-15 21:53:59',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'VW-Audi',
                'created_at' => '2021-01-15 21:54:01',
                'updated_at' => '2021-01-15 21:54:01',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'VW- Audi',
                'created_at' => '2021-01-15 21:54:01',
                'updated_at' => '2021-01-15 21:54:01',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'PORSH',
                'created_at' => '2021-01-15 21:54:02',
                'updated_at' => '2021-01-15 21:54:02',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'VW PORCHE',
                'created_at' => '2021-01-15 21:54:03',
                'updated_at' => '2021-01-15 21:54:03',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'Walker',
                'created_at' => '2021-01-15 21:54:04',
                'updated_at' => '2021-01-15 21:54:04',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'Motorcraft',
                'created_at' => '2021-01-15 21:54:04',
                'updated_at' => '2021-01-15 21:54:04',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'WALKER-CATCO',
                'created_at' => '2021-01-15 21:54:04',
                'updated_at' => '2021-01-15 21:54:04',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'WALKER PSA',
                'created_at' => '2021-01-15 21:54:05',
                'updated_at' => '2021-01-15 21:54:05',
                'deleted_at' => NULL,
                'space_id' => 1,
            ),
        ));
        
        
    }
}