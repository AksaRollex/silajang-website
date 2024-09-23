<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail {
  use Notifiable, Uuid, HasRoles;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'nama',
    'nip',
    'nik',
    'email',
    'password',
    'phone',
    'photo',
    'golongan_id',
    'confirmed',
    'email_verified_at',
    'phone_verified_at',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];

  protected $appends = ['permission', 'role', 'has_tagihan', 'has_umpan_balik'];
  protected $with = ['detail', 'golongan'];

  /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */
  public function getJWTIdentifier() {
    return $this->getKey();
  }

  /**
   * Return a key value array, containing any custom claims to be added to the JWT.
   *
   * @return array
   */
  public function getJWTCustomClaims() {
    return [];
  }

  public function umpanBalik() {
    return $this->hasOne(UmpanBalik::class)->where('tahun', date('Y'));
  }

  public function golongan() {
    return $this->belongsTo(Golongan::class);
  }

  public function permohonans() {
    return $this->hasMany(Permohonan::class);
  }

  public function titikPermohonans() {
    return $this->hasManyThrough(TitikPermohonan::class, Permohonan::class);
  }

  public function detail() {
    return $this->hasOne(DetailUser::class);
  }

  public function parameters() {
    return $this->belongsToMany(Parameter::class, 'user_parameters', 'user_id', 'parameter_id');
  }

  public function getRoleAttribute() {
    return $this->roles()->first();
  }

  public function getPermissionAttribute() {
    return $this->getAllPermissions()->pluck('name');
  }

  protected static function booted() {
    static::deleted(function ($user) {
      if ($user->photo != null && $user->photo != '') {
        $old_photo = str_replace('/storage/', '', $user->photo);
        Storage::disk('public')->delete($old_photo);
      }

      if (@$user->detail->tanda_tangan != null && @$user->detail->tanda_tangan != '') {
        $old_tanda_tangan = str_replace('/storage/', '', @$user->detail->tanda_tangan);
        Storage::disk('public')->delete($old_tanda_tangan);
      }
    });
  }

  public function getHasTagihanAttribute() {
    return false;
    return $this->titikPermohonans()->whereHas('payment', function ($q) {
      $q->where('status', '!=', 'success');
    })->exists();
  }

  public function getHasUmpanBalikAttribute() {
    return true;
    // if (!$this->permohonans()->whereYear('created_at', date('Y'))->count()) return true;
    // return isset($this->umpanBalik()->first()->id);
  }
}
