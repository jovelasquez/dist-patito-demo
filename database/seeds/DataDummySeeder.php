<?php

use Illuminate\Database\Seeder;

class DataDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        // Save 10 Distributor
        $dists = factory(\App\Distributor::class)->times(10)->create();

        $dists->random(8)
            ->each(function ($dist) use ($faker) {
                $dist->tasks()
                    ->saveMany(
                        factory(\App\Task::class)
                            ->times($faker->numberBetween(1, 5))
                            ->make()
                    );
            });

    }
}