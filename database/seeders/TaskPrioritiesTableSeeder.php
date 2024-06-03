<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TaskPrioritiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('task_priorities')->delete();
        
        \DB::table('task_priorities')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'low',
                'color' => 'yellow',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-02 17:20:18',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'medium',
                'color' => 'green',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-02 17:20:22',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'high',
                'color' => 'orange',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-02 17:20:25',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'critical',
                'color' => 'red',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-02 17:20:28',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}