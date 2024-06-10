<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class learn extends Model
{
    use HasFactory;

    protected $table = 'learn';
    protected $primaryKey = 'learn_id';
    protected $fillable = [
        'user_learn_id',
        'user_teach_id',
        'learn_at',
        'teach_at',
        'learn_type_id',
        'note'
    ];

    public $timestamps = false;

    public function user_learn(){

        return $this->belongsTo(Users::class,'user_learn_id');

    }

    public function user_teach(){

        return $this->belongsTo(Users::class,'user_teach_id');

    }

    public function learn_type(){

        return $this->belongsTo(learn_type::class,'learn_type_id');

    }
}
