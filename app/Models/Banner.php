<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use Uuid;
    protected $fillable = ['judul', 'gambar', 'link'];
}
