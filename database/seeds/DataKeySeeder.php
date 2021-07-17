<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('data_keys')->truncate();
        DB::table('data_keys')->insert([
            'key' => 'AQICAHhZ2EAJsrgZyT6efd6YrJ+WhfCH3qZYgqa57QWTFd40fgER664Jue3ru/tQGHMLC4A4AAAAfjB8BgkqhkiG9w0BBwagbzBtAgEAMGgGCSqGSIb3DQEHATAeBglghkgBZQMEAS4wEQQMyT3v4zyvJEDfFRyiAgEQgDvKWi7NrB2cEiCqIIWuVW2XyLEzQahGgNILxmnSajmqbcp2L+QKteEaBKzBN0sLcTsQG0lhsZv7KAsyDQ==',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::statement("SET foreign_key_checks=1");
    }
}
