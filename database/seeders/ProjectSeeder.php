<?php


namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //

        for ($i = 0; $i < 25; $i++) {
            $newProject = new Project();
            $newProject->name = $faker->sentence(3);
            $newProject->description = $faker->paragraph(2);
            $newProject->repository_link = $faker->url;
            $newProject->date_start = $faker->date;
            $newProject->date_end = $faker->optional(0.5)->date;
            $newProject->img = $faker->optional(0.5)->imageUrl();
            $newProject->slug = Str::slug($newProject->name, '-');
            $newProject->save();
        }
    }
}
