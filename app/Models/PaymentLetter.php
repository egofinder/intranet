<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLetter extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'payment_letter';
    public $timestamps = false;
}
