<?php

namespace App\Modules\Income\Controllers;

use App\Models\Transaction;
use App\Controllers\BaseController;
use App\Modules\Income\Models\Income;
use CodeIgniter\Shield\Models\UserModel;

class Index extends BaseController
{
    protected $folder_directory = "Modules\\Income\\Views\\";
    protected $model;
    protected $data = [];
    protected $rules = [];

    public function __construct()
    {
        $this->model = new Income;
    }

    public function index()
    {
        $session = session();
        $userId = $session->get('user')['id'] ?? null;

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please log in to track income.');
        }

        $userModel = new UserModel();
        $userDetails = $userModel->find($userId);
        $userDetailsArray = $userDetails->toArray();

        if (!$userDetails) {
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        $name = $userDetails->username;
        $transactionModel = new Transaction();
        $adminId = $userDetailsArray['id'];

        try {
            if ($adminId == 1){
                // Total income
                $totalIncome = $transactionModel->selectSum('amount')
                    ->where(['transaction' => 'income'])
                    ->get()
                    ->getRow()
                    ->amount ?? 0;

                // Income by date
                $incomeByDate = $transactionModel->select('DATE(date) as date, SUM(amount) as total_income')
                    ->where(['transaction' => 'income'])
                    ->groupBy('DATE(date)')
                    ->orderBy('date', 'asc')
                    ->findAll();

                // Prepare arrays for chart data
                $dates = [];
                $incomeValues = [];  // Avoid conflict with $income array
            } else {
                // Total income
                $totalIncome = $transactionModel->selectSum('amount')
                    ->where(['user_id' => $userId, 'transaction' => 'income'])
                    ->get()
                    ->getRow()
                    ->amount ?? 0;

                // Income by date
                $incomeByDate = $transactionModel->select('DATE(date) as date, SUM(amount) as total_income')
                    ->where(['user_id' => $userId, 'transaction' => 'income'])
                    ->groupBy('DATE(date)')
                    ->orderBy('date', 'asc')
                    ->findAll();

                // Prepare arrays for chart data
                $dates = [];
                $incomeValues = [];  // Avoid conflict with $income array
            }
            

            foreach ($incomeByDate as $incomeData) {
                $dates[] = $incomeData['date'];
                $incomeValues[] = $incomeData['total_income'];
            }

            // Pass data to view
            $this->data['totalIncome'] = number_format($totalIncome);
            $this->data['dates'] = json_encode($dates);
            $this->data['income'] = json_encode($incomeValues);
            $this->data['username'] = $name;
        } catch (\Exception $e) {
            log_message('error', 'Error calculating income: ' . $e->getMessage());
            $this->data['error'] = 'An error occurred while calculating your income. Please try again later.';
        }

        // Render the views
        echo view('/layouts/header.php');
        return self::render('index');
        echo view('/layouts/footer.php');
    }


    public function render(string $page): string
    {
        return view( $this->folder_directory . $page, $this->data);
    }
}