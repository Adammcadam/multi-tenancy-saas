<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $org = Organisation::create([
            'name' => 'Fake Ltd',
        ]);

        $user = User::first();

        $org->users()->attach($user->id, [
            'role' => 'owner',
            'joined_at' => now(),
        ]);
    }
}
