<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'status' => 'To Do'],
            ['id' => 2, 'status' => 'In Progress'],
            ['id' => 3, 'status' => 'Complete']
        ];
        DB::table('task_statuses')->insert($data);
    }
}
