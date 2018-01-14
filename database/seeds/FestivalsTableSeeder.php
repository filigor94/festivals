<?php

use Illuminate\Database\Seeder;

class FestivalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $festival_1 = DB::table('festivals')->insertGetId([
            'title' => 'Exit',
            'start_date' => '2018-07-12 10:00:00',
            'end_date' => '2018-07-15 12:00:00',
            'image' => '1.jpg',
            'description' => 'Last summer, all eyes were pointed at the new, spectacular mts Dance Arena with it\’s new awe inspiring stage design and light show. The world renowned stage at EXIT Festival celebrated its first 15 years of existence that were filled with historical moments created by the party insatiable audience together with all the greatest DJs in the world.',
            'created_at' => '2018-01-14 22:19:24',
            'updated_at' => '2018-01-14 22:19:24'
        ]);

        $festival_2 = DB::table('festivals')->insertGetId([
            'title' => 'Tomorrowland',
            'start_date' => '2018-07-20 17:00:00',
            'end_date' => '2018-07-22 23:00:00',
            'image' => '2.jpg',
            'description' => 'The People of Tomorrow. We believe in enjoying life to the fullest without having to compromise everything. We are responsible for the generation of tomorrow and respect each other and Mother Nature.',
            'created_at' => '2018-01-14 22:24:52',
            'updated_at' => '2018-01-14 22:24:52'
        ]);

        DB::table('addresses')->insert([
            'country' => 'Serbia',
            'city' => 'Novi Sad',
            'address' => 'Petrovaradinska 12',
            'map_lat' => '45.25292694019324',
            'map_lng' => '19.86332416534424',
            'festival_id' => $festival_1,
            'created_at' => '2018-01-14 22:19:24',
            'updated_at' => '2018-01-14 22:19:24'
        ]);

        DB::table('addresses')->insert([
            'country' => 'Belgium',
            'city' => 'Boom',
            'address' => 'De Schorre 34',
            'map_lat' => '51.012026657382386',
            'map_lng' => '3.722991943359375',
            'festival_id' => $festival_2,
            'created_at' => '2018-01-14 22:24:52',
            'updated_at' => '2018-01-14 22:24:52'
        ]);

        $visitor_1 = DB::table('visitors')->insertGetId([
            'first_name' => 'Filip',
            'last_name' => 'Vucinic',
            'email' => 'filigor94@gmail.com',
            'created_at' => '2018-01-14 22:27:30',
            'updated_at' => '2018-01-14 22:27:30'
        ]);

        DB::table('festival_visitor')->insert([
            'festival_id' => $festival_2,
            'visitor_id' => $visitor_1,
        ]);
    }
}
