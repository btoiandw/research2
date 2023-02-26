<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbAdmin extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_admin_id',
        'employee_id',
        'username',
        'password',
        'status_workadmin', //1=ทำงาน,0=ไม่มำงาน
    ];
}
