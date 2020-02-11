<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class)->create([
            'company_id' => 1,
            'name' => 'Anderson Moraes',
            'email' => 'anderson@ycloud.com.br',
            'password' => bcrypt('secret'),
            'created_at' => Carbon::now(),
        ]);
    }
}
