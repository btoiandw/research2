<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbDirector extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'username',
        'password',
        'pname',
        'full_name_th',
        'full_name_eng',
        'gender',
        'organization_id',
        'work_status', //1=work,0=not work
        'tel',
        'email',
        'address',
        'high_education',
        'certificate',
        'year_congrat',
        'institute_name',
        'major',

    ];
}
