<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use Uuid;

    protected $fillable = ['nama'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
