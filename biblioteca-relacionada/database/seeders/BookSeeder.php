<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class BookSeeder extends Seeder
{
    /**Run the database seeds.*/
  public function run(): void{$faker = Faker::create();

        $books = [];

        for ($i = 0; $i < 20; $i++) {
            $books[] = [
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'author_id'=> $faker->numberBetween(1, 100),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('books')->insert($books);
    }
}
