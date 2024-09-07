<?php

namespace App\Modules\Income\Controllers;

use App\Controllers\BaseController;
use App\Modules\Income\Models\Income;

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
        return self::render('index');
    }

    public function render(string $page): string
    {
        return view( $this->folder_directory . $page, $this->data);
    }
}