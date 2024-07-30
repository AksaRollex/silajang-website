<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use Uuid;
    protected $fillable = ['judul', 'judul_en', 'isi', 'isi_en'];
}
