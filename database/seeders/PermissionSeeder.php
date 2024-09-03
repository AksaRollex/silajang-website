<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('roles')->delete();
        // DB::table('permissions')->delete();
        // DB::table('model_has_roles')->delete();
        // DB::table('model_has_permissions')->delete();
        DB::table('role_has_permissions')->delete();

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionsByRole = [
            'admin' => ['dashboard', 'pengujian', 'administrasi', 'kontrak', 'persetujuan', 'penerima-sample', 'pengambil-sample', 'verifikasi', 'analis', 'koordinator-teknis', 'kepala-upt', 'report', 'lhu', 'kendali-mutu', 'rekap-data', 'rekap-parameter', 'registrasi-sampel', 'pembayaran', 'pembayaran-pengujian', 'pembayaran-non-pengujian', 'pembayaran-global', 'master', 'acuan-metode', 'peraturan', 'parameter', 'paket', 'pengawetan', 'jenis-sampel', 'jenis-wadah', 'jasa-pengambilan', 'radius-pengambilan', 'libur-cuti', 'kode-retribusi', 'user', 'jabatan', 'wilayah', 'kota-kabupaten', 'kecamatan', 'kelurahan', 'konfigurasi', 'log-tte', 'tanda-tangan', 'umpan-balik', 'konfigurasi-pengujian', 'website', 'setting', 'banner', 'layanan', 'produk-hukum', 'faq', 'pengumuman', 'whatsapp', 'tracking-pengujian'],
            'pengambil-sample' => ['dashboard', 'pengujian', 'administrasi', 'pengambil-sample'],
            'analis' => ['dashboard', 'pengujian', 'verifikasi', 'analis'],
            'koordinator-administrasi' => ['dashboard', 'pengujian', 'administrasi', 'persetujuan', 'penerima-sample', 'report', 'rekap-parameter', 'registrasi-sampel', 'lhu', 'pembayaran', 'pembayaran-pengujian', 'konfigurasi', 'konfigurasi-pengujian', 'tracking-pengujian', 'pembayaran-non-pengujian', 'pembayaran-global'],
            'koordinator-teknis' => ['dashboard', 'pengujian', 'verifikasi', 'analis', 'koordinator-teknis', 'report', 'lhu', 'kendali-mutu', 'rekap-data', 'rekap-parameter', 'registrasi-sampel', 'konfigurasi', 'konfigurasi-pengujian', 'tracking-pengujian', 'pembayaran', 'pembayaran-pengujian', 'pembayaran-non-pengujian', 'pembayaran-global'],
            'kepala-upt' => ['dashboard', 'pengujian', 'persetujuan', 'verifikasi', 'analis', 'koordinator-teknis', 'kepala-upt', 'report', 'lhu', 'kendali-mutu', 'rekap-data', 'rekap-parameter', 'registrasi-sampel', 'konfigurasi', 'konfigurasi-pengujian', 'tracking-pengujian', 'pembayaran', 'pembayaran-pengujian', 'pembayaran-non-pengujian', 'pembayaran-global'],
            'customer' => ['dashboard', 'pengujian', 'permohonan', 'titik-permohonan', 'tracking-pengujian-customer', 'pembayaran-customer'],
        ];

        $insertPermissions = fn ($role) => collect($permissionsByRole[$role])
            ->map(function ($name) {
                $check = Permission::whereName($name)->first();

                if (!$check) {
                    return Permission::create([
                        'name' => $name,
                        'guard_name' => 'api',
                    ])->id;
                }

                return $check->id;
            })
            ->toArray();

        $permissionIdsByRole = [
            'admin' => $insertPermissions('admin'),
            'pengambil-sample' => $insertPermissions('pengambil-sample'),
            'analis' => $insertPermissions('analis'),
            'koordinator-administrasi' => $insertPermissions('koordinator-administrasi'),
            'koordinator-teknis' => $insertPermissions('koordinator-teknis'),
            'kepala-upt' => $insertPermissions('kepala-upt'),
            'customer' => $insertPermissions('customer'),
        ];

        foreach ($permissionIdsByRole as $role => $permissionIds) {
            $role = Role::whereName($role)->first();

            DB::table('role_has_permissions')
                ->insert(
                    collect($permissionIds)->map(fn ($id) => [
                        'role_id' => $role->id,
                        'permission_id' => $id
                    ])->toArray()
                );
        }
    }
}
