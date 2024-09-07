<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'type' => 'Food',
                'description' => 'Lunch at the cafeteria',
                'amount' => 300,
                'date' => '2024-09-02',
                'user_id' => 2,
                'transaction' => 'expense'
            ],
            [
                'type' => 'Transport',
                'description' => 'Bus fare to school',
                'amount' => 100,
                'date' => '2024-09-03',
                'user_id' => 2,
                'transaction' => 'expense'
            ],
            [
                'type' => 'Food',
                'description' => 'Groceries for the week',
                'amount' => 1200,
                'date' => '2024-09-05',
                'user_id' => 2,
                'transaction' => 'expense'
            ],
            [
                'type' => 'Transport',
                'description' => 'Taxi to friend’s house',
                'amount' => 700,
                'date' => '2024-09-06',
                'user_id' => 2,
                'transaction' => 'expense'
            ],
            [
                'type' => 'Food',
                'description' => 'Dinner with friends',
                'amount' => 600,
                'date' => '2024-09-09',
                'user_id' => 2,
                'transaction' => 'expense'
            ],
            [
                'type' => 'Transport',
                'description' => 'Bus fare to campus',
                'amount' => 100,
                'date' => '2024-09-10',
                'user_id' => 2,
                'transaction' => 'expense'
            ],
        ];

        $this->db->table('expenses')->insertBatch($data);
        
    }
}
