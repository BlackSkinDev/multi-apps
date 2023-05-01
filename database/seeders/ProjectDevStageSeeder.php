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
          ['name'=>'To Do','position'=>1],
          ['name'=>'In progress','position'=>2],
          ['name'=>'In review','position'=>3],
          ['name'=>'In testing','position'=>4],
          ['name'=>'Testing failed','position'=>5],
          ['name'=>'Done','position'=>6],
        ];

        ProjectDevStage::insert($project_dev_stages);
    }
}
