# Expense Tracker Installation Guide

## Installation

### Step 1: Clone the Repository
Clone the repository using the following command:
```bash
git clone https://github.com/FarajaOmbeni/expense-tracker.git
```

### Step 2: Enter the expense-tracker directory
```bash
cd expense-tracker
```
### Step 3: Install composer
```bash
composer install
```

### Step 4: Copy the env file to your folder
```bash
cp env .env
```

### Step 5: Turn on your local server (i.e. XAMPP) on Windows

### Step 6: Modify the settings in your .env like this
```bash
database.default.hostname = localhost
database.default.database = expense_tracker
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix = st_
database.default.port = 3306
```

### Step 7: Install codeigniter shield
```bash
composer require simpletine/hmvc-shield
```

### Step 8: Set up your project by running:
```bash
php spark simpletine:setup
```

### Step 9: Create a database called expense_tracker and agree to everything

### Step 8: Seed the database
```bash
php spark db:seed DatabaseSeeder
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
