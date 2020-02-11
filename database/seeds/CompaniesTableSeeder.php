<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Company::class)->create([
            'name' => 'Ycloud Soluções Tecnológicas',
            'hash' => md5(uniqid('')),
            'cnpj' => '20285026000130'
        ]);
    }
}
