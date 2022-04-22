<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobLoanInfoExtraLoan extends Model
{
    use HasFactory;


    protected $fillable = [
        'loanNumber',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
