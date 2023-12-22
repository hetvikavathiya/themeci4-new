<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'product';
    protected $allowedFields = ['id', 'date', 'category_id', 'name', 'image', 'created_at', 'updated_at'];
    protected $primarykey = 'id';
}
