<?php

namespace App\Modules\Income\Models;

use CodeIgniter\Model;

class Income extends Model
{
    protected $table            = 'st_income';
    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['type', 'description', 'amount', 'date','user_id', 'transaction'];

}