<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CandidatosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('pt_BR');

        for ($i = 0; $i < 4; $i++) {
            DB::table('candidatos')->insert(
                [
                    'nome' => $faker->name(),
                ]
            );
        }

    }
}
