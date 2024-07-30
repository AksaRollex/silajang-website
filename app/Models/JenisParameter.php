<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class JenisParameter extends Model
{
    use Uuid;

    protected $fillable = ['nama'];
}
