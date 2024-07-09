<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coursee extends Model
{
    use HasFactory;

    protected $table = 'course';
    protected $primaryKey = 'course_id';
    protected $fillable = [
        'course_id',
        'date_pay',
        'learn_amount',
        'course_user_id',
        'learntype_id',
        'insert_at'
    ];

    public $timestamps = false;


    public function learn()
    {
        return $this->hasMany(learn::class, 'learn_course_id');
    }

    public function learn_type(){

        return $this->belongsTo(learn_type::class,'learntype_id');
    }

    public function user_course(){

        return $this->belongsTo(Users::class,'course_user_id');
    }
}
