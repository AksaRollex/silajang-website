<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class LogTTE extends Model
{
    use Uuid;
    protected $fillable = ['titik_permohonan_id', 'nik', 'status', 'message', 'ip_address', 'user_agent'];
    protected $appends = ['tanggal_indo'];

    public function titik_permohonan()
    {
        return $this->belongsTo(TitikPermohonan::class);
    }

    public function getTanggalIndoAttribute() {
        return \App\Helpers\AppHelper::tanggal_indo(\Carbon\Carbon::parse($this->created_at)->format('Y-m-d')) . ' ' . \Carbon\Carbon::parse($this->created_at)->format('H:i:s');
    }
}
