<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // One profile fixture. Existing non-fixture records are never deleted.
        User::updateOrCreate(['id' => 1], [
            'username' => 'earl.velasquez',
            'full_name' => 'Earl Christian R. Velasquez',
            'email' => 'earl.velasquez@example.com',
        ]);
    }
}
