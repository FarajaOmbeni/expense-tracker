<div class="d-flex flex-column justify-content-center align-items-center mt-5">
    <h3>Welcome to the expenses Tracker</h3>
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
                        <div class="form-group">
                            <label for="expenseType">Type</label>
                            <select class="form-control" id="expenseType" name="expenseType" required>
                                <option value="Food">Food</option>
                                <option value="Transportation">Transportation</option>
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
            <?php if(!empty($transactions)): ?>
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
                <tr>
                    <td><?= $transaction['date'] ?></td>
                    <td><?= $transaction['type'] ?></td>
                    <td><?= $transaction['description'] ?></td>
                    <td><?= $transaction['amount'] ?></td>
                    <td>
                        <div class="d-flex mb-4" style="gap: 5px">
                            <form action=" /edit/{id}"><button type="submit" class="btn btn-primary">Edit</button></form>
                            <form action="/delete/{id}"><button type="submit" class="btn btn-danger">Delete</button></form>
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