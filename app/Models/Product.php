<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $collection = 'products';
    protected $primaryKey = '_id';
    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'slug',
        'category',
        'price',
        'qty'        
    ];

    protected $hidden = [
       
    ];

    public function detailProduct()
    {
        return $this->hasMany(DetailProduct::class, 'product_id');
    }

    public function detailTransaction()
    {
        return $this->hasMany(DetailTransaction::class, 'product_id');
    }
}
