<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class ProdukHukumItem extends Model
{
    use Uuid;
    protected $fillable = ['produk_hukum_id', 'nama', 'file'];

    public function produkHukum()
    {
        return $this->belongsTo(ProdukHukum::class);
    }
}
