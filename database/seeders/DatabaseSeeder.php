<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with the website's current content.
     * Create the first admin account with: php artisan admin:create
     */
    public function run(): void
    {
        $this->call(SiteContentSeeder::class);
    }
}
