<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IncomeSeeder extends Seeder
{
    public function run()
    {
        $data =[
            [
                'type' => 'Salary',
                'description' => 'Part-time job payment',
                'amount' => 8000,
                'date' => '2024-09-01',
                'user_id' => 2,
                'transaction' => 'income'
            ],
            [
                'type' => 'Gift',
                'description' => 'Gift from parents',
                'amount' => 5000,
                'date' => '2024-09-04',
                'user_id' => 2,
                'transaction' => 'income'
            ],
            [
                'type' => 'Salary',
                'description' => 'Freelance gig payment',
                'amount' => 3500,
                'date' => '2024-09-07',
                'user_id' => 2,
                'transaction' => 'income'
            ],
            [
                'type' => 'Gift',
                'description' => 'Birthday gift from friend',
                'amount' => 1000,
                'date' => '2024-09-08',
                'user_id' => 2,
                'transaction' => 'income'
            ],
        ];

        $this->db->table('income')->insertBatch($data);

    }
}
