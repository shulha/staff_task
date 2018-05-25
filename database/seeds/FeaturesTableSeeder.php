<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = ['Коммуникабельность', 'Инженерный навык', 'Тайм менеджмент', 'Знание языков'];

        foreach ($features as $feature) {
            DB::table('features')->insert([
                'title' => $feature,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
