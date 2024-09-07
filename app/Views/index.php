<div class="d-flex flex-column justify-content-center align-items-center mt-5">
    <h3>Welcome to the expenses Tracker, <?= $username ?></h3>
    <h4>Balance: </h4>
    <h2>KES <?= $balance ?></h2>
    <div class="d-flex flex-row justify-content-between mb-4" style="gap: 20px;">
        <button class="btn btn-danger" data-toggle="modal" data-target="#expenseModal">Add Expense</button>
        <button class="btn btn-success" data-toggle="modal" data-target="#incomeModal">Add Income</button>
    </div>
    <!-- Display messages if any -->
    <?php if (session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <!-- Expense Modal -->
    <div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="expenseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="expenseModalLabel">Add Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/add-expense">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="expenseType">Type</label>
                            <select class="form-control" id="expenseType" name="expenseType" required>
                                <option value="Food">Food</option>
                                <option value="Transport">Transport</option>
                                <option value="Health">Health</option>
                                <option value="Leisure">Leisure</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Savings">Savings</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="expenseDescription">Description</label>
                            <input class="form-control" type="text" id="expenseDescription" name="expenseDescription" required>
                        </div>
                        <div class="form-group">
                            <label for="expenseAmount">Amount</label>
                            <input type="number" class="form-control" id="expenseAmount" name="expenseAmount" placeholder="Enter amount" required>
                        </div>
                        <div class="form-group">
                            <label for="expenseDate">Date</label>
                            <input type="date" class="form-control" id="expenseDate" name="expenseDate" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Income Modal -->
    <div class="modal fade" id="incomeModal" tabindex="-1" role="dialog" aria-labelledby="incomeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="incomeModalLabel">Add Income</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/add-income">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="expenseType">Type</label>
                            <select class="form-control" id="expenseType" name="incomeType" required>
                                <option value="Salary">Salary</option>
                                <option value="Pocket Money">Pocket Money</option>
                                <option value="Gift">Gift</option>
                                <option value="Business Income">Business Income</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="incomeDescription">Description</label>
                            <input class="form-control" type="text" id="incomeDescription" name="incomeDescription" required>
                        </div>
                        <div class="form-group">
                            <label for="incomeAmount">Amount</label>
                            <input type="number" class="form-control" id="incomeAmount" name="incomeAmount" placeholder="Enter amount" required>
                        </div>
                        <div class="form-group">
                            <label for="incomeDate">Date</label>
                            <input type="date" class="form-control" id="incomeDate" name="incomeDate" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <h4>Transactions</h4>
    <div class="w-50">
        <table class="table table-striped">
            <?php if (!empty($transactions)): ?>
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Type</th>
                        <th scope="col">Description</th>
                        <th scope="col">Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr style="color: white; background-color: <?= $transaction['transaction'] == 'expense' ? '#C82333' : '#218838' ?>;">
                            <td><?= $transaction['date'] ?></td>
                            <td><?= $transaction['type'] ?></td>
                            <td><?= $transaction['description'] ?></td>
                            <td><?= $transaction['amount'] ?></td>
                            <td>
                                <div class="d-flex mb-4" style="gap: 5px">
                                    <!-- Edit Modal -->
                                    <div style="color:black;" class="modal fade" id="editModal<?= $transaction['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit Transaction</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/edit-transaction/<?= $transaction['id'] ?>">
                                                        <?php csrf_token() ?>
                                                        <div class="form-group">
                                                            <label for="editType">Type</label>
                                                            <?php if ($transaction['transaction'] == 'expense'): ?>
                                                                <select class="form-control" id="editType" name="type" required>
                                                                    <option value="Food" <?= $transaction['type'] == 'Food' ? 'selected' : '' ?>>Food</option>
                                                                    <option value="Transport" <?= $transaction['type'] == 'Transport' ? 'selected' : '' ?>>Transport</option>
                                                                    <option value="Health" <?= $transaction['type'] == 'Health' ? 'selected' : '' ?>>Health</option>
                                                                    <option value="Leisure" <?= $transaction['type'] == 'Leisure' ? 'selected' : '' ?>>Leisure</option>
                                                                    <option value="Entertainment" <?= $transaction['type'] == 'Entertainment' ? 'selected' : '' ?>>Entertainment</option>
                                                                    <option value="Savings" <?= $transaction['type'] == 'Savings' ? 'selected' : '' ?>>Savings</option>
                                                                    <option value="Other" <?= $transaction['type'] == 'Other' ? 'selected' : '' ?>>Other</option>
                                                                </select>
                                                            <?php elseif ($transaction['transaction'] == 'income'): ?>
                                                                <select class="form-control" id="expenseType" name="incomeType" required>
                                                                    <option value="Salary" <?= $transaction['type'] == 'Salary' ? 'selected' : '' ?>>Salary</option>
                                                                    <option value="Pocket Money" <?= $transaction['type'] == 'Pocket Money' ? 'selected' : '' ?>>Pocket Money</option>
                                                                    <option value="Gift" <?= $transaction['type'] == 'Gift' ? 'selected' : '' ?>>Gift</option>
                                                                    <option value="Business Income" <?= $transaction['type'] == 'Business Income' ? 'selected' : '' ?>>Business Income</option>
                                                                    <option value="Other" <?= $transaction['type'] == 'Other' ? 'selected' : '' ?>>Other</option>
                                                                </select>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editDescription">Description</label>
                                                            <input value="<?= $transaction['description'] ?>" class="form-control" type="text" id="editDescription" name="description" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editAmount">Amount</label>
                                                            <input value="<?= $transaction['amount'] ?>" type="number" class="form-control" id="editAmount" name="amount" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editDate">Date</label>
                                                            <input value="<?= $transaction['date'] ?>" type="date" class="form-control" id="editDate" name="date" required>
                                                        </div>
                                                        <input type="hidden" id="editTransactionId" name="transactionId" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal<?= $transaction['id'] ?>">Edit</button>

                                    <!-- Delete Modal -->
                                    <div style="color: black;" class="modal fade" id="deleteModal<?= $transaction['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Delete Transaction</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this transaction?</p>
                                                    <form method="post" action="/delete-transaction/<?= $transaction['id'] ?>">
                                                        <?= csrf_field() ?>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?= $transaction['id'] ?>">Delete</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-primary">
            <p style="text-align: center;">No Transactions Found</p>
        </div>
    <?php endif; ?>
    </div>
</div>

<div>
    <h2>Balance: <?= $balance ?></h2>
    <h3>Total Income: <?= $totalIncome ?></h3>
    <h3>Total Expenses: <?= $totalExpenses ?></h3>
</div>
<canvas id="expenseIncomeChart"></canvas>

<script>
    const ctx = document.getElementById('expenseIncomeChart').getContext('2d');
    const expenseIncomeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Income', 'Expenses'],
            datasets: [{
                label: 'Income vs Expenses',
                data: [<?= $totalIncome ? $totalIncome : 0 ?>, <?= $totalExpenses ? $totalExpenses : 0 ?>],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Income vs Expenses'
                }
            }
        }
    });
</script>