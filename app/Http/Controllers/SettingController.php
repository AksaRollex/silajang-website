<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return response()->json(Setting::first());
    }

    public function update(Request $request)
    {
        if (request()->wantsJson()) {
            $request->validate([
                'app' => 'required',
                'description' => 'required',
                'dinas' => 'required',
                'pemerintah' => 'required',
                'alamat' => 'required',
                'telepon' => 'required',
                'email' => 'required',
                'logo_dalam' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'logo_depan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'banner' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'bg_auth' => 'required|image|mimes:jpeg,png,jpg|max:4096',
                'kop_app' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'kop_sni' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $setting = Setting::first();

            if ($setting->logo_dalam != null && $setting->logo_dalam != '') {
                $old_photo = str_replace('/storage/', '', $setting->logo_dalam);
                Storage::disk('public')->delete($old_photo);
            }

            if ($setting->logo_depan != null && $setting->logo_depan != '') {
                $old_photo = str_replace('/storage/', '', $setting->logo_depan);
                Storage::disk('public')->delete($old_photo);
            }

            if ($setting->banner != null && $setting->banner != '') {
                $old_photo = str_replace('/storage/', '', $setting->banner);
                Storage::disk('public')->delete($old_photo);
            }

            if ($setting->bg_auth != null && $setting->bg_auth != '') {
                $old_photo = str_replace('/storage/', '', $setting->bg_auth);
                Storage::disk('public')->delete($old_photo);
            }

            if ($setting->kop_app != null && $setting->kop_app != '') {
                $old_photo = str_replace('/storage/', '', $setting->kop_app);
                Storage::disk('public')->delete($old_photo);
            }

            if ($setting->kop_sni != null && $setting->kop_sni != '') {
                $old_photo = str_replace('/storage/', '', $setting->kop_sni);
                Storage::disk('public')->delete($old_photo);
            }

            $data = $request->all();

            if ($request->hasFile('logo_dalam')) {
                $data['logo_dalam'] = '/storage/' . $request->file('logo_dalam')->store('setting', 'public');
            }

            if ($request->hasFile('logo_depan')) {
                $data['logo_depan'] = '/storage/' . $request->file('logo_depan')->store('setting', 'public');
            }

            if ($request->hasFile('banner')) {
                $data['banner'] = '/storage/' . $request->file('banner')->store('setting', 'public');
            }

            if ($request->hasFile('bg_auth')) {
                $data['bg_auth'] = '/storage/' . $request->file('bg_auth')->store('setting', 'public');
            }

            if ($request->hasFile('kop_app')) {
                $data['kop_app'] = '/storage/' . $request->file('kop_app')->store('setting', 'public');
            }

            if ($request->hasFile('kop_sni')) {
                $data['kop_sni'] = '/storage/' . $request->file('kop_sni')->store('setting', 'public');
            }

            $setting->update($data);

            return response()->json([
                'message' => 'Berhasil memperbarui data Konfigurasi Website',
                'data' => $setting
            ]);
        } else {
            abort(404);
        }
    }
}
