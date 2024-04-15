<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use LucasDotVin\Soulbscription\Enums\PeriodicityType;
use LucasDotVin\Soulbscription\Models\Feature;
use LucasDotVin\Soulbscription\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Features 
        $links = Feature::create([
            'consumable'       => true,
            'name'             => 'links',
        ]);

        $domains = Feature::create([
            'consumable'       => true,
            'name'             => 'domains',
        ]);


        // Plans
        $bronze = Plan::create([
            'name'             => 'Bronze',
            'periodicity_type' => PeriodicityType::Month,
            'periodicity'      => 1,
            'amount'           => 0,
        ]);

        $silver = Plan::create([
            'name'             => 'Silver',
            'periodicity_type' => PeriodicityType::Month,
            'periodicity'      => 3,
            'amount'           => 499,
        ]);

        $gold = Plan::create([
            'name'             => 'Gold',
            'periodicity_type' => PeriodicityType::Month,
            'periodicity'      => 3,
            'amount'           => 699,
        ]);

        $bronze->features()->attach($links, ['charges' => 2000]);

        $silver->features()->attach($links, ['charges' => 50000]);

        $gold->features()->attach($links, ['charges' => 100000]);
        $gold->features()->attach($domains,['charges' => 3]);

        $user = User::find(1);

        $user->subscribeTo($gold);
        
    }
}
