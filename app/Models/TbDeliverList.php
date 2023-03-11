<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbDeliverList extends Model
{
    use HasFactory;

    protected $fillable = [
        'deliver_id',
        'research_source_id',
        'Type_research',
        'Date_start_contract',
        'Date_end_contract',
        'lesson1',
        'lesson2',
        'lesson3',
        'lesson4',
        'lesson5',
        'lesson6',
        'lesson7',
        'lesson8',
        'lesson9',
        'lesson10',
    ];
}
