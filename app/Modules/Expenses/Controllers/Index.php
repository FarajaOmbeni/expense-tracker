<?php

namespace App\Modules\Expenses\Controllers;

use App\Controllers\BaseController;
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
        return self::render('index');
    }

    public function render(string $page): string
    {
        return view($this->folder_directory . $page, $this->data);
    }

    
}
