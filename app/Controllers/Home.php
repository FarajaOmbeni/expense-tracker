<?php

namespace App\Controllers;

use App\Models\Transaction;
use App\Modules\Income\Models\Income;
use CodeIgniter\Shield\Models\UserModel;

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

        $userModel = new UserModel();
        $userDetails = $userModel->find($userId);

        if (!$userDetails) {
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        $userDetailsArray = $userDetails->toArray();
        $adminId = $userDetailsArray['id'];
        $name = $userDetailsArray['username'];

        $transactionModel = new Transaction();

        try {
            if ($adminId == 1) {
                $totalIncome = $transactionModel->selectSum('amount')->where('transaction', 'income')->get()->getRow()->amount ?? 0;
                $totalExpenses = $transactionModel->selectSum('amount')->where('transaction', 'expense')->get()->getRow()->amount ?? 0;
                $transactions = $transactionModel->orderBy('date', 'desc')->findAll();
            } else {
                $totalIncome = $transactionModel->selectSum('amount')->where(['user_id' => $userId, 'transaction' => 'income'])->get()->getRow()->amount ?? 0;
                $totalExpenses = $transactionModel->selectSum('amount')->where(['user_id' => $userId, 'transaction' => 'expense'])->get()->getRow()->amount ?? 0;
                $transactions = $transactionModel->where('user_id', $userId)->orderBy('date', 'desc')->findAll();
            }

            $balance = $totalIncome - $totalExpenses;

            $this->data['balance'] = number_format($balance);
            $this->data['totalIncome'] = number_format($totalIncome);
            $this->data['totalExpenses'] = number_format($totalExpenses);
            $this->data['transactions'] = $transactions;
            $this->data['adminId'] = $adminId;
            $this->data['username'] = $name;
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
        $expenseType = $this->request->getVar('expenseType');
        $expenseDescription = $this->request->getVar('expenseDescription');
        $expenseAmount = $this->request->getVar('expenseAmount');
        $expenseDate = $this->request->getVar('expenseDate');
        $userId = session()->get('user')['id'];
        $transaction = 'expense';

        $transactionModel = new Transaction();

        $data = [
            'type' => $expenseType,
            'description' => $expenseDescription,
            'amount' => $expenseAmount,
            'date' => $expenseDate,
            'user_id' => $userId,
            'transaction' => $transaction
        ];

        if (!$transactionModel->save($data)) {
            return redirect()->to('/')->with('errors', $transactionModel->errors());
        }

        return redirect()->to('/')->with('success', 'Expense added successfully.');
    }

    public function add_income()
    {
        $incomeType = $this->request->getVar('incomeType');
        $incomeDescription = $this->request->getVar('incomeDescription');
        $incomeAmount = $this->request->getVar('incomeAmount');
        $incomeDate = $this->request->getVar('incomeDate');
        $userId = session()->get('user')['id'];
        $transaction = 'income';

        $transactionModel = new Transaction();

        $data = [
            'type' => $incomeType,
            'description' => $incomeDescription,
            'amount' => $incomeAmount,
            'date' => $incomeDate,
            'user_id' => $userId,
            'transaction' => $transaction,
        ];

        if (!$transactionModel->save($data)) {
            return redirect()->to('/')->with('errors', $transactionModel->errors());
        }

        return redirect()->to('/')->with('success', 'Income added successfully.');
    }
    public function delete_transaction($id)
    {
        $transactionModel = new Transaction();

        if (!$transactionModel->delete($id)) {
            return redirect()->to('/')->with('errors', $transactionModel->errors());
        }

        return redirect()->to('/')->with('success', 'Transaction deleted successfully.');
    }
}
