<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'project',
        'material',
        'count',
        'done_count',
        'shipped_count',
        'archived',
        'status',
        'finishing',
        'finish_date',
        'order_date',
        'start_date',
        'unit',
        'pdf_file',
        'dxf_file',
        'notes',
        'problems',
        'user_id',
    ];
}
