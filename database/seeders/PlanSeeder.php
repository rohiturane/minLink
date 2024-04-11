<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravelcm\Subscriptions\Models\Plan;
use Laravelcm\Subscriptions\Models\Feature;
use Laravelcm\Subscriptions\Interval;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan = Plan::create([
            'name' => 'Basic',
            'description' => 'Basic plan',
            'price' => 499,
            'invoice_period' => 1,
            'invoice_interval' => Interval::MONTH->value,
            'trial_period' => 14,
            'trial_interval' => Interval::DAY->value,
            // 'sort_order' => 1,
            'currency' => 'INR',
        ]);
        
        // Create multiple plan features at once
        $plan->features()->saveMany([
            new Feature(['name' => 'links', 'value' => 4999, 'sort_order' => 1]),
            new Feature(['name' => 'domains', 'value' => 1, 'sort_order' => 5]),
        ]);

        $plan = Plan::create([
            'name' => 'Pro',
            'description' => 'Pro plan',
            'price' => 999,
            'invoice_period' => 1,
            'invoice_interval' => Interval::MONTH->value,
            'trial_period' => 14,
            'trial_interval' => Interval::DAY->value,
            // 'sort_order' => 1,
            'currency' => 'INR',
        ]);
        
        // Create multiple plan features at once
        $plan->features()->saveMany([
            new Feature(['name' => 'links', 'value' => 99999, 'sort_order' => 1]),
            new Feature(['name' => 'domains', 'value' => 5, 'sort_order' => 5]),
        ]);

        $user = User::find(1);

        $user->newPlanSubscription('primary', $plan);
        
    }
}
