<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\Feature;
use App\Models\Series;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory(10)->create();

        $series = Series::factory(2)->create();
        $feature = Feature::factory(4)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Book::create([
          'title' => 'Test',
          'slug'  => 'test',
          'blurb' => 'This is a blurb',
          'position_in_series' => 1,
          'series_id' => 1
        ]);
        Book::create([
          'title' => 'Test2',
          'slug'  => 'test2',
          'blurb' => 'This is a blurb',
          'position_in_series' => 2,
          'series_id' => 1
        ]);
        Book::create([
          'title' => 'Test3',
          'slug'  => 'test3',
          'blurb' => 'This is a blurb',
          'series_id' => 2
        ]);
        Book::create([
          'title' => 'Test4',
          'slug'  => 'test4',
          'blurb' => 'This is a blurb',
          'series_id' => 2
        ]);
        Book::create([
          'title' => 'Test5',
          'slug'  => 'test5',
          'blurb' => 'This is a blurb',
          'series_id' => 2
        ]);

    }
}
