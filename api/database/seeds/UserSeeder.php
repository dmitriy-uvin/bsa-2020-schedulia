<?php

use Illuminate\Database\Seeder;
use App\Entity\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 1)->create([
            'email' => 'schedulia-test@schedulia.xyz',
        ]);
    }
}
