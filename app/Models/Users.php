<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Users extends Authenticatable
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'nick_name',
        'school',
        'gender',
        'birthday',
        'Agee',
        'parent_name',
        'parent_relationship',
        'mobile_phone',
        'id_line',
        'bank_number',
        'bank_name',
        'user_img',
        'user_status_user_status_id',
        'learn_type_learn_type_id',
        'regis_at',
        'update_at',
        'password' // เพิ่มฟิลด์ password
    ];

    public $timestamps = false;

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function user_status()
    {
        return $this->belongsTo(user_status::class, 'user_status_user_status_id');
    }

    public function user_type()
    {
        return $this->belongsTo(learn_type::class, 'learn_type_learn_type_id');
    }

    public function learn()
    {
        return $this->hasMany(Learn::class, 'user_learn_id');
    }

    public function teach()
    {
        return $this->hasMany(Learn::class, 'user_teach_id');
    }
}
