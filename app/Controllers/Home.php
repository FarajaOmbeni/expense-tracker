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
            $transactions = $transactionModel->where('user_id', $userId)->orderBy('date', 'desc')->findAll();
            
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
        $transaction = 'expense';

        $transactionModel = new Transaction();
        $expenseModel = new Expenses();

        $data = [
            'type' => $expenseType,
            'description' => $expenseDescription,
            'amount' => $expenseAmount,
            'date' => $expenseDate,
            'user_id' => $userId,
            'transaction' => $transaction
        ];

        if (!$expenseModel->save($data) || !$transactionModel->save($data)) {
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
        $incomeModel = new Income();

        $data = [
            'type' => $incomeType,
            'description' => $incomeDescription,
            'amount' => $incomeAmount,
            'date' => $incomeDate,
            'user_id' => $userId,
            'transaction' => $transaction,
        ];

        if (!$transactionModel->save($data) || !$incomeModel->save($data)) {
            return redirect()->to('/')->with('errors', $incomeModel->errors());
        }

        return redirect()->to('/')->with('success', 'Income added successfully.');
    }
    public function edit_transaction($id)
    {
        $transactionModel = new Transaction();
        $expenseModel = new Expenses();
        $incomeModel = new Income();

        $transaction = $transactionModel->find($id);
        $expense = $expenseModel->find($id);
        $income = $incomeModel->find($id);

        if (!$transaction && !$expense && !$income) {
            return redirect()->to('/')->with('error', 'Transaction not found.');
        }

        $data = [
            'description' => $this->request->getVar('description'),
            'amount' => $this->request->getVar('amount'),
            'date' => $this->request->getVar('date'),
        ];

        $success = true;

        // Update transaction table
        if ($transaction) {
            $data['type'] = $this->request->getVar('type');
            if (!$transactionModel->update($id, $data)) {
                $success = false;
            }
        }

        // Update expense table
        if ($expense) {
            $expenseData = $data;
            $expenseData['type'] = $this->request->getVar('type');
            if (!$expenseModel->update($id, $expenseData)) {
                $success = false;
            }
        }

        // Update income table
        if ($income) {
            $incomeData = $data;
            $incomeData['type'] = $this->request->getVar('incomeType') ?? $this->request->getVar('type');
            if (!$incomeModel->update($id, $incomeData)) {
                $success = false;
            }
        }

        if (!$success) {
            return redirect()->to('/')->with('error', 'Failed to update transaction in all tables.');
        }

        return redirect()->to('/')->with('success', 'Transaction updated successfully.');
    }
    public function delete_transaction($id)
    {
        $transactionModel = new Transaction();
        $expenseModel = new Expenses();
        $incomeModel = new Income();

        $transaction = $transactionModel->find($id);
        $expense = $expenseModel->find($id);
        $income = $incomeModel->find($id);

        if (!$transaction && !$expense && !$income) {
            return redirect()->to('/')->with('error', 'Transaction not found.');
        }

        $success = true;

        if ($transaction && !$transactionModel->delete($id)) {
            $success = false;
        }

        if ($expense && !$expenseModel->delete($id)) {
            $success = false;
        }

        if ($income && !$incomeModel->delete($id)) {
            $success = false;
        }

        if (!$success) {
            return redirect()->to('/')->with('error', 'Failed to delete transaction from all tables.');
        }

        return redirect()->to('/')->with('success', 'Transaction deleted successfully.');
    }
}
