<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class KodeRetribusi extends Model
{
    use Uuid;
    protected $fillable = ['kode', 'nama'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
