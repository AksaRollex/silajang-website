<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultiPayment extends Model {
  protected $fillable = ['payment_id', 'titik_permohonan_id'];
  protected $with = ['titikPermohonan'];

  public function payment() {
    return $this->belongsTo(Payment::class, 'payment_id', 'id');
  }

  public function titikPermohonan() {
    return $this->belongsTo(TitikPermohonan::class, 'titik_permohonan_id', 'id');
  }
}
