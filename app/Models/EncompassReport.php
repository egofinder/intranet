<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncompassReport extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $primaryKey = 'UID';
    protected $table = 'encompass_report';
    public $timestamps = false;
}
