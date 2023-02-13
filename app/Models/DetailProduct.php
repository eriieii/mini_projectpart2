<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
// use Illuminate\Database\Eloquent\SoftDeletes;

class DetailProduct extends Model
{
    use HasFactory, SoftDeletes;

    // public $table = 'detail_product';
    protected $collection = 'detail_product';
    protected $primaryKey = '_id';
    protected $connection = 'mongodb';

    protected $fillable = [
        'product_id',
        'color',
        'size'                
    ];

    protected $hidden = [
       
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'products_id', 'id');
    }
}
