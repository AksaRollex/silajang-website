<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function get(Request $request)
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => User::when(isset($request->golongan_id), function ($q) use ($request) {
                $q->where('golongan_id', $request->golongan_id);
            })->get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = User::where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('email', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('phone', 'LIKE', '%' . $request->search . '%');
                $q->orWhereHas('roles', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%');
                });
                $q->orWhereHas('golongan', function ($q) use ($request) {
                    $q->where('nama', 'LIKE', '%' . $request->search . '%');
                });
            })->where('golongan_id', $request->golongan_id)->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        if (request()->wantsJson()) {
            $request->validate([
                'nama' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'password' => 'required|confirmed',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'golongan_id' => 'required',
                'role_ids' => 'required|array',
                'detail.tanda_tangan' => 'nullable',
                'detail.instansi' => 'nullable',
                'detail.alamat' => 'nullable',
                'detail.pimpinan' => 'nullable',
                'detail.pj_mutu' => 'nullable',
                'detail.telepon' => 'nullable',
                'detail.fax' => 'nullable',
                'detail.email' => 'nullable',
                'detail.kecamatan_id' => 'nullable',
                'detail.kelurahan_id' => 'nullable',
                'detail.lat' => 'nullable',
                'detail.long' => 'nullable',
                'detail.jenis_kegiatan' => 'nullable',
            ]);

            $data = $request->all();
            $data['email_verified_at'] = now();
            $data['phone_verified_at'] = now();
            $data['password'] = bcrypt($request->password);
            $data['confirmed'] = 1;

            if ($request->hasFile('photo')) {
                $data['photo'] = '/storage/' . $request->file('photo')->store('user', 'public');
            }

            if ($request->hasFile('tanda_tangan')) {
                $data['detail']['tanda_tangan'] = '/storage/' . $request->file('tanda_tangan')->store('tanda_tangan', 'public');
            } else {
                $data['detail']['tanda_tangan'] = null;
            }

            if ($user = User::create($data)) {
                $role = Role::whereIn('id', $request->role_ids)->pluck('name');
                $user->syncRoles($role);

                try {
                    $user->detail()->create($data['detail']);
                } catch (\Throwable $th) {
                    return response()->json([
                        'message' => 'Data berhasil disimpan',
                        'data' => $data
                    ]);
                }

                return response()->json([
                    'message' => 'Data berhasil disimpan',
                    'data' => $data
                ]);
            }
        } else {
            return abort(404);
        }
    }

    public function confirm(Request $request, $uuid)
    {
        if (request()->wantsJson()) {
            $request->validate([
                'confirmed' => 'required'
            ]);

            $data = User::findByUuid($uuid);

            if (!$data) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data->update([
                'confirmed' => $request->confirmed
            ]);

            return response()->json([
                'message' => 'Data berhasil dikonfirmasi',
                'data' => $data
            ]);
        } else {
            return abort(404);
        }
    }

    public function edit($uuid)
    {
        if (request()->wantsJson()) {
            $data = User::findByUuid($uuid);

            if (!$data) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data->role_ids = $data->roles->pluck('id');
            return response()->json([
                'message' => 'Data berhasil ditemukan',
                'data' => $data
            ]);
        } else {
            return abort(404);
        }
    }

    public function update(Request $request, $uuid)
    {
        if (request()->wantsJson()) {
            $request->validate([
                'nama' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'password' => 'nullable|confirmed',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'golongan_id' => 'required',
                'role_ids' => 'required|array',
                'detail.tanda_tangan' => 'nullable',
                'detail.instansi' => 'nullable',
                'detail.alamat' => 'nullable',
                'detail.pimpinan' => 'nullable',
                'detail.pj_mutu' => 'nullable',
                'detail.telepon' => 'nullable',
                'detail.fax' => 'nullable',
                'detail.email' => 'nullable',
                'detail.kecamatan_id' => 'nullable',
                'detail.kelurahan_id' => 'nullable',
                'detail.lat' => 'nullable',
                'detail.long' => 'nullable',
                'detail.jenis_kegiatan' => 'nullable',
            ]);

            $user = User::findByUuid($uuid);

            if (!$user) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data = $request->all();

            if (isset($request->password) && $request->password != null && $request->password != '') {
                $data['password'] = bcrypt($request->password);
            } else {
                unset($data['password']);
            }

            // Remove old photo
            if ($user->photo != null && $user->photo != '') {
                $old_photo = str_replace('/storage/', '', $user->photo);
                Storage::disk('public')->delete($old_photo);
            }

            if ($request->hasFile('photo')) {
                $data['photo'] = '/storage/' . $request->file('photo')->store('user', 'public');
            } else {
                $data['photo'] = null;
            }

            // Remove old photo
            if (@$user->detail->tanda_tangan != null && @$user->detail->tanda_tangan != '') {
                $old_photo = str_replace('/storage/', '', $user->detail->tanda_tangan);
                Storage::disk('public')->delete($old_photo);
            }

            if ($request->hasFile('tanda_tangan')) {
                $data['detail']['tanda_tangan'] = '/storage/' . $request->file('tanda_tangan')->store('tanda_tangan', 'public');
            } else {
                $data['detail']['tanda_tangan'] = null;
            }

            if ($user->update($data)) {
                $role = Role::whereIn('id', explode(',', $request->role_ids[0]))->get()->pluck('name');
                $user->syncRoles($role);

                unset($data['detail']['id']);
                unset($data['detail']['user_id']);
                unset($data['detail']['created_at']);
                unset($data['detail']['updated_at']);

                try {
                    if (isset($user->detail)) {
                        $user->detail()->update($data['detail']);
                    } else {
                        $user->detail()->create($data['detail']);
                    }

                    return response()->json([
                        'message' => 'Data berhasil diubah',
                        'data' => $data
                    ]);
                } catch (\Throwable $th) {
                    return response()->json([
                        'message' => 'Data berhasil diubah',
                        'data' => $data
                    ]);
                }
            }
        } else {
            return abort(404);
        }
    }

    public function destroy($uuid)
    {
        if (request()->wantsJson()) {
            try {
                $user = User::findByUuid($uuid);

                if (!$user) {
                    return response()->json([
                        'message' => 'Data tidak ditemukan'
                    ], 404);
                }

                // Remove photo
                if ($user->photo != null && $user->photo != '') {
                    $old_photo = str_replace('/storage/', '', $user->photo);
                    Storage::disk('public')->delete($old_photo);
                }

                $user->delete();

                return response()->json([
                    'message' => 'Data berhasil dihapus',
                    'data' => $user
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'User tidak dapat dihapus karena memiliki data terkait',
                ], 500);
            }
        } else {
            return abort(404);
        }
    }

    public function updateAccount(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only('nama');

        // Remove old photo
        if (auth()->user()->photo != null && auth()->user()->photo != '') {
            $old_photo = str_replace('/storage/', '', auth()->user()->photo);
            Storage::disk('public')->delete($old_photo);
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = '/storage/' . $request->file('photo')->store('user', 'public');
        } else {
            $data['photo'] = null;
        }

        auth()->user()->update($data);

        return response()->json([
            'message' => 'Berhasil memperbarui data Akun',
            'data' => $request->user()
        ]);
    }

    public function updateCompany(Request $request)
    {
        $request->validate([
            'tanda_tangan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'instansi' => 'required|string',
            'alamat' => 'required|string',
            'pimpinan' => 'required|string',
            'pj_mutu' => 'required|string',
            'telepon' => 'required|string',
            'fax' => 'nullable|string',
            'email' => 'required|email',
            'jenis_kegiatan' => 'required|string',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'kab_kota_id' => 'required|exists:kab_kotas,id',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'kelurahan_id' => 'required|exists:kelurahans,id',
        ]);

        $data = $request->only('instansi', 'alamat', 'pimpinan', 'tanda_tangan', 'pj_mutu', 'telepon', 'fax', 'email', 'jenis_kegiatan', 'lat', 'long', 'kab_kota_id', 'kecamatan_id', 'kelurahan_id');

        // Remove old photo
        if (@auth()->user()->detail->tanda_tangan != null && @auth()->user()->detail->tanda_tangan != '') {
            $old_photo = str_replace('/storage/', '', auth()->user()->detail->tanda_tangan);
            Storage::disk('public')->delete($old_photo);
        }

        if ($request->hasFile('tanda_tangan')) {
            $data['tanda_tangan'] = '/storage/' . $request->file('tanda_tangan')->store('tanda_tangan', 'public');
        } else {
            $data['tanda_tangan'] = null;
        }

        if (isset(auth()->user()->detail)) {
            auth()->user()->detail()->update($data);
        } else {
            auth()->user()->detail()->create($data);
        }

        return response()->json([
            'message' => 'Berhasil memperbarui data Perusahaan',
            'data' => $request->user()
        ]);
    }

    public function updateSecurity(Request $request)
    {
        $data = $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|min:12|confirmed',
        ]);

        $user = User::find(auth()->user()->id);
        if (!Hash::check($data['old_password'], $user->password)) {
            return response()->json([
                'message' => 'Password Lama tidak valid'
            ], 400);
        }

        $user->password = bcrypt($data['password']);
        if ($user->update()) {
            return response()->json([
                'message' => 'Berhasil memperbarui password'
            ]);
        } else {
            return response()->json([
                'message' => 'Gagal memperbarui password'
            ]);
        }
    }
}
