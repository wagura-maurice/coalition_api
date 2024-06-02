<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TaskCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('task_categories')->delete();
        
        \DB::table('task_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'planning',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-02 17:26:52',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'analysis',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-02 17:26:56',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'design',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-02 17:27:00',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'development',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-02 17:27:02',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'testing',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-02 17:27:06',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'implementation',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-02 17:27:08',
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'maintenance',
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-02 17:27:11',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}