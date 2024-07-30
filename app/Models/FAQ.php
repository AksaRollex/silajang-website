<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use Uuid;
    protected $fillable = ['pertanyaan', 'pertanyaan_en', 'jawaban', 'jawaban_en', 'gambar'];
}
