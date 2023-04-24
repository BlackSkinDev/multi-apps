<?php

namespace Database\Seeders;

use App\Models\ProjectDevStage;
use Illuminate\Database\Seeder;

class ProjectDevStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project_dev_stages = [
          ['name'=>'To Do','priority'=>1],
          ['name'=>'In progress','priority'=>2],
          ['name'=>'In review','priority'=>3],
          ['name'=>'In testing','priority'=>4],
          ['name'=>'Testing failed','priority'=>5],
          ['name'=>'Done','priority'=>6],
        ];

        ProjectDevStage::insert($project_dev_stages);
    }
}
