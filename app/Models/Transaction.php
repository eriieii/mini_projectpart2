<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    // public $table = 'transactions';
    protected $collection = 'transactions';
    protected $primaryKey = '_id';
    protected $connection = 'mongodb';
    protected $fillable = [
        'uuid',
        'name',
        'address',
        'email',
        'number',
        'transaction_total',
        'transaction_status'
    ];

    protected $hidden = [

    ];

    public function details()
    {
        return $this->hasMany(DetailTransaction::class,'transaction_id');
    }
}
