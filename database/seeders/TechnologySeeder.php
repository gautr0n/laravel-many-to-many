<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $technology = ['html', 'css', 'javascript', 'bootstrap', 'php', 'vue', 'laravel'];
        foreach ($technology as $technology_name) {
            $technology = new Technology();
            $technology->name = $technology_name;
            $technology->slug = Str::slug($technology_name);
            $technology->save();
        }
    }
}
