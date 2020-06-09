<?php

use App\ClassDay;
use Illuminate\Database\Seeder;

class ClassDaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClassDay::create([
            'day' => 'Saterday',
            'is_open' => false
        ]);
        ClassDay::create([
            'day' => 'Sunday',
            'is_open' => false
        ]);
        ClassDay::create([
            'day' => 'Monday',
            'is_open' => false
        ]);
        ClassDay::create([
            'day' => 'Tuesday',
            'is_open' => false
        ]);
        ClassDay::create([
            'day' => 'Wednesday',
            'is_open' => false
        ]);
        ClassDay::create([
            'day' => 'Thursday',
            'is_open' => false
        ]);
        ClassDay::create([
            'day' => 'Friday',
            'is_open' => false
        ]);
    }
}