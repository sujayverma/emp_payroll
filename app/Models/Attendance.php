<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'attend_date',
        'in_time',
        'out_time'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
