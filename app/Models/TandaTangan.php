<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class TandaTangan extends Model
{
    use Uuid;
    protected $fillable = ['bagian', 'user_id'];
    protected $appends = ['nama', 'jabatan', 'nip', 'nik', 'tanda_tangan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNamaAttribute()
    {
        return $this->user->nama;
    }

    public function getJabatanAttribute()
    {
        return $this->user->role->full_name;
    }

    public function getNipAttribute()
    {
        return $this->user->nip;
    }

    public function getNikAttribute()
    {
        return $this->user->nik;
    }

    public function getTandaTanganAttribute()
    {
        return @$this->user->detail->tanda_tangan ?? null;
    }
}
