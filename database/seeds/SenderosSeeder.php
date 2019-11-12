<?php

use Illuminate\Database\Seeder;
use App\Http\Controllers\DataMigrater;

class SenderosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::connection('senderos')->table('senderos')->insert(DataMigrater::ExcelArray('senderos.xlsx'));
    }
}
