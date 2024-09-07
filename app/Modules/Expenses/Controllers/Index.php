<?php

namespace App\Modules\Expenses\Controllers;

use App\Models\Transaction;
use App\Controllers\BaseController;
use CodeIgniter\Shield\Models\UserModel;
use App\Modules\Expenses\Models\Expenses;

class Index extends BaseController
{
    protected $folder_directory = "Modules\\Expenses\\Views\\";
    protected $model;
    protected $data = [];
    protected $rules = [];

    public function __construct()
    {
        $this->model = new Expenses;
    }

    public function index()
    {
        $session = session();
        $userId = $session->get('user')['id'] ?? null;
        $userModel = new UserModel();
        $userDetails = $userModel->find($userId);
        $userDetailsArray = $userDetails->toArray();
        $name = $userDetailsArray['username']; 


        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please log in to track expenses.');
        }

        $transactionModel = new Transaction();

        $adminId = $userDetailsArray['id'];

        try {
            if($adminId == 1){
                $totalExpenses = $transactionModel->selectSum('amount')->where(['transaction' => 'expense'])->get()->getRow()->amount ?? 0;


                $expensesByDate = $transactionModel->select('DATE(date) as date, SUM(amount) as total_expense')
                ->where(['transaction' => 'expense'])
                ->groupBy('DATE(date)')
                ->orderBy('date', 'asc')
                ->findAll();

                $dates = [];
                $expenses = [];
            } else {
                $totalExpenses = $transactionModel->selectSum('amount')->where(['user_id' => $userId, 'transaction' => 'expense'])->get()->getRow()->amount ?? 0;


                $expensesByDate = $transactionModel->select('DATE(date) as date, SUM(amount) as total_expense')
                ->where(['user_id' => $userId, 'transaction' => 'expense'])
                ->groupBy('DATE(date)')
                ->orderBy('date', 'asc')
                ->findAll();

                $dates = [];
                $expenses = [];
            }

            

            foreach ($expensesByDate as $expense) {
                $dates[] = $expense['date'];
                $expenses[] = $expense['total_expense'];
            }

            $this->data['totalExpenses'] = number_format($totalExpenses);
            $this->data['dates'] = json_encode($dates); 
            $this->data['expenses'] = json_encode($expenses);
            $this->data['username'] = $name;
            

        } catch (\Exception $e) {
            log_message('error', 'Error calculating balance: ' . $e->getMessage());
            $this->data['error'] = 'An error occurred while calculating your balance. Please try again later.';
        }

        echo view('/layouts/header.php');
        return self::render('index');
        echo view('/layouts/footer.php');
    }


    public function render(string $page): string
    {
        return view($this->folder_directory . $page, $this->data);
    }

    
}
