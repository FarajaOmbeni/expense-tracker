<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'type' => 'salary',
                'description' => 'Part-time job payment',
                'amount' => 8000,
                'date' => '2024-09-01',
                'user_id' => 3,
                'transaction' => 'income'
            ],
            [
                'type' => 'food',
                'description' => 'Lunch at the cafeteria',
                'amount' => 300,
                'date' => '2024-09-02',
                'user_id' => 3,
                'transaction' => 'expense'
            ],
            [
                'type' => 'transport',
                'description' => 'Bus fare to school',
                'amount' => 100,
                'date' => '2024-09-03',
                'user_id' => 3,
                'transaction' => 'expense'
            ],
            [
                'type' => 'gift',
                'description' => 'Gift from parents',
                'amount' => 5000,
                'date' => '2024-09-04',
                'user_id' => 3,
                'transaction' => 'income'
            ],
            [
                'type' => 'food',
                'description' => 'Groceries for the week',
                'amount' => 1200,
                'date' => '2024-09-05',
                'user_id' => 3,
                'transaction' => 'expense'
            ],
            [
                'type' => 'transport',
                'description' => 'Taxi to friend’s house',
                'amount' => 700,
                'date' => '2024-09-06',
                'user_id' => 3,
                'transaction' => 'expense'
            ],
            [
                'type' => 'salary',
                'description' => 'Freelance gig payment',
                'amount' => 3500,
                'date' => '2024-09-07',
                'user_id' => 3,
                'transaction' => 'income'
            ],
            [
                'type' => 'gift',
                'description' => 'Birthday gift from friend',
                'amount' => 1000,
                'date' => '2024-09-08',
                'user_id' => 3,
                'transaction' => 'income'
            ],
            [
                'type' => 'food',
                'description' => 'Dinner with friends',
                'amount' => 600,
                'date' => '2024-09-09',
                'user_id' => 3,
                'transaction' => 'expense'
            ],
            [
                'type' => 'transport',
                'description' => 'Bus fare to campus',
                'amount' => 100,
                'date' => '2024-09-10',
                'user_id' => 3,
                'transaction' => 'expense'
            ],
        ];


        $this->db->table('transactions')->insertBatch($data);
    }
}
