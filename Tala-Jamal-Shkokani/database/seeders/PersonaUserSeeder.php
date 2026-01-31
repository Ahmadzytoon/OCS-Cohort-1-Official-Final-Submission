<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PersonaUserSeeder extends Seeder
{
    public function run(): void
    {
        $personas = [
            [
                'name' => 'Laila Al-Fayegh',
                'email' => 'laila@softluxury.co',
                'persona' => 'Soft Femme',
                'primary' => 'soft',
                'secondary' => 'luxury',
                'tier' => 'Platinum'
            ],
            [
                'name' => 'Zeid Mansour',
                'email' => 'zeid@chic.co',
                'persona' => 'Luxury Clean',
                'primary' => 'luxury',
                'secondary' => 'mix',
                'tier' => 'Black'
            ],
            [
                'name' => 'Maya Kabbani',
                'email' => 'maya@alt.co',
                'persona' => 'Alt Girly',
                'primary' => 'alt',
                'secondary' => 'mix',
                'tier' => 'Standard'
            ],
            [
                'name' => 'Omar Shami',
                'email' => 'omar@mix.co',
                'persona' => 'Modern Mix',
                'primary' => 'mix',
                'secondary' => 'alt',
                'tier' => 'Gold'
            ],
            [
                'name' => 'Sarah Jaber',
                'email' => 'sarah@softluxury.co',
                'persona' => 'Soft Femme',
                'primary' => 'soft',
                'secondary' => 'alt',
                'tier' => 'Silver'
            ],
            [
                'name' => 'Faisal Haddad',
                'email' => 'faisal@luxury.co',
                'persona' => 'Luxury Clean',
                'primary' => 'luxury',
                'secondary' => 'soft',
                'tier' => 'Platinum'
            ]
        ];

        foreach ($personas as $p) {
            User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['name'],
                    'password' => Hash::make('password'),
                    'role' => 'user',
                    'style_persona' => $p['persona'],
                    'primary_aesthetic' => $p['primary'],
                    'secondary_aesthetic' => $p['secondary'],
                    'loyalty_tier' => $p['tier'],
                    'total_spent' => rand(500, 5000),
                    'preferred_aesthetics' => [$p['primary'], $p['secondary']]
                ]
            );
        }
    }
}
