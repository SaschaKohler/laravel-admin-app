<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Cleanup media
         */
        foreach (Storage::disk('public')->allDirectories() as $dir) {
            Storage::disk('public')->deleteDirectory($dir);
        }

        $this->call(UserSeeder::class);
//        $this->call(CustomerSeeder::class);
//        $this->call(VehicleSeeder::class);
//        $this->call(ToolSeeder::class);
//        $this->call(EventSeeder::class);
//        $this->call(TicketSeeder::class);
    }

    public static function randomMedia($type, $max, $extension = 'jpg'): string
    {
        $i = str_pad(random_int(1, $max), 2, '0', STR_PAD_LEFT);

        return database_path("/seeders/media/{$type}/{$i}.{$extension}");
    }

    public static function pdf(): string
    {
        return database_path('/seeders/media/sample.pdf');
    }
}
