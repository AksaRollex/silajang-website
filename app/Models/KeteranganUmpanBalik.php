<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class KeteranganUmpanBalik extends Model
{
    use Uuid;
    protected $fillable = ['kode', 'keterangan'];
}
