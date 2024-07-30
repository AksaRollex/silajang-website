<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class LiburCuti extends Model
{
    use Uuid;
    protected $fillable = ['tanggal', 'keterangan'];
}
