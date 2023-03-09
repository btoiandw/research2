<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'research_id',
        'employee_referees_id',
        'date_send_referess',
        'status',
        'feedback',
        'Assessment_result',
        'suggestionFile',
        'Date_feedback_research',

    ];
}
