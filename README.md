# Expense Tracker Installation Guide

## Installation

### Step 1: Clone the Repository
Clone the repository using the following command:
```bash
https://github.com/FarajaOmbeni/expense-tracker.git
```

### Step 2: Enter the expenses-tracker directory
```bash
cd expenses-tracker
```
### Step 3: Update composer
```bash
composer update
```

### Step 4: Copy the env file to your folder
```bash
cp env .env
```

#### NOTE: Turn on your local server (i.e. XAMPP) on Windows

### Step 4: Modify the settings in your .env like this
```bash
database.default.hostname = localhost
database.default.database = expense_tracker
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix = st_
database.default.port = 3306
```

### Step 5: Set up your project by running:
```bash
php spark simpletine:setup
```

### Step 6: Create a database called expenses_tracker and agree to everuthing

### Step 7: Migrate the database
```bash
php spark:migrate
```

### Step 8: Seed the database
```bash
php spark seed DatabaseSeeder
```
### Step 9: These are the admin's credentials
```bash
email: super@admin.com
password: password
```

### Step 10: All Set! Run:
```bash
php spark serve
```
You can create a new user to see some of their expenes