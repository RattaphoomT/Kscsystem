<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class learn_type extends Model
{
    use HasFactory;

    protected $table = 'learn_type';
    protected $primaryKey = 'learn_type_id';
    protected $fillable = ['learn_type_name'];

    public function Learn()
    {
        return $this->hasMany(Users::class, 'learn_type_learn_type_id');
    }

    public function learn_history()
    {
        return $this->hasMany(learn::class, 'learn_type_id');
    }

}
