<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbResearch extends Model
{
    use HasFactory;
    protected $fillable = [
        'research_id',
        'date_upload_file',
        'research_th',
        'research_en',
        'research_source_id',
        'type_research_id',
        'keyword',
        'date_research_start',
        'date_research_end',
        'research_area',
        'budage_research',
        'word_file',
        'pdf_file',
        'research_summary_feedback',
        'summary_feedback_file',
        'research_status',
        'year_research'
    ];
}
