<?php
namespace Database\Seeders;

/* autor: Tulio Martinez */
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name'     => 'Tulio',
            'email'    => 'tulio@example.com',
            'password' => bcrypt('Tulio#$%'),
        ]);

        User::factory()->create([
            'name'     => 'Leonardo',
            'email'    => 'leonardo@example.com',
            'password' => bcrypt('Leo#$%'),
        ]);
    }
}
