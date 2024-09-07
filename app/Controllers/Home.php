<?php

namespace App\Controllers;

use App\Models\Transaction;
use App\Modules\Income\Models\Income;
use CodeIgniter\Shield\Models\UserModel;
use App\Modules\Expenses\Models\Expenses;

class Home extends BaseController
{

    protected array $data = [];

    public function index()
    {
        $session = session();
        $userId = $session->get('user')['id'] ?? null;

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please log in to track expenses.');
        }

        $incomeModel = new Income();
        $expenseModel = new Expenses();
        $transactionModel = new Transaction();

        try {
            $totalIncome = $incomeModel->selectSum('amount')->where('user_id', $userId)->get()->getRow()->amount ?? 0;
            $totalExpenses = $expenseModel->selectSum('amount')->where('user_id', $userId)->get()->getRow()->amount ?? 0;


            $balance = $totalIncome - $totalExpenses;
            $transactions = $transactionModel->where('user_id', $userId)->findAll();

            $this->data['balance'] = number_format($balance);
            $this->data['totalIncome'] = number_format($totalIncome);
            $this->data['totalExpenses'] = number_format($totalExpenses);
            $this->data['transactions'] = $transactions;
        } catch (\Exception $e) {
            log_message('error', 'Error calculating balance: ' . $e->getMessage());
            $this->data['error'] = 'An error occurred while calculating your balance. Please try again later.';
        }

        echo view('/layouts/header.php');
        echo view('index', $this->data);
        echo view('/layouts/footer.php');
    }

    public function add_expense()
    {
        // Fetch the current user's data
        $expenseType = $this->request->getVar('expenseType');
        $expenseDescription = $this->request->getVar('expenseDescription');
        $expenseAmount = $this->request->getVar('expenseAmount');
        $expenseDate = $this->request->getVar('expenseDate');
        $userId = session()->get('user')['id'];

        $transactionModel = new Transaction();
        $expenseModel = new Expenses();

        $data = [
            'type' => $expenseType,
            'description' => $expenseDescription,
            'amount' => $expenseAmount,
            'date' => $expenseDate,
            'user_id' => $userId
        ];

        if (!$expenseModel->save($data) || !$transactionModel->save($data)) {
            return redirect()->to('/')->with('errors', $transactionModel->errors());
        }

        return redirect()->to('/')->with('success', 'Expense added successfully.');
    }

    public function add_income()
    {
        // Fetch the current user's data
        $incomeType = $this->request->getVar('incomeType');
        $incomeDescription = $this->request->getVar('incomeDescription');
        $incomeAmount = $this->request->getVar('incomeAmount');
        $incomeDate = $this->request->getVar('incomeDate');
        $userId = session()->get('user')['id'];

        $transactionModel = new Transaction();
        $incomeModel = new Income();

        $data = [
            'type' => $incomeType,
            'description' => $incomeDescription,
            'amount' => $incomeAmount,
            'date' => $incomeDate,
            'user_id' => $userId
        ];

        if (!$transactionModel->save($data) || !$incomeModel->save($data)) {
            return redirect()->to('/')->with('errors', $incomeModel->errors());
        }

        return redirect()->to('/')->with('success', 'Income added successfully.');
    }
}
