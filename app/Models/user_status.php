<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_status extends Model
{
    use HasFactory;

    protected $table = 'user_status';
    protected $primaryKey = 'user_status_id';
    protected $fillable = ['user_status_name'];

    public function Users()
    {
        return $this->hasMany(Users::class, 'user_status_user_status_id');
    }

}
