<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::updateOrCreate(
            ['email' => 'mimin@wikrama.sch.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('12345'),
                'role' => 'admin',
            ]
        );

        // Operator user
        User::updateOrCreate(
            ['email' => 'trator@wikrama.sch.id'],
            [
                'name' => 'Operator Wikrama',
                'password' => Hash::make('67890'),
                'role' => 'operator',
            ]
        );

    }
}
