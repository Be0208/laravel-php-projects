<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class AuthorsSeeder extends Seeder
{
    /**Run the database seeds.*/
  public function run(): void{$faker = Faker::create();

        $authors = [];

        for ($i = 0; $i < 100; $i++) {
            $authors[] = [
                'name' => $faker->name,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('authors')->insert($authors);
    }
}
