<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Permissions follow the "fitur.aksi" pattern, e.g. user.edit, kata.tambah.
     */
    private const FEATURES = [
        'dashboard' => ['read'],
        'kategori' => ['read', 'tambah', 'edit', 'delete'],
        'kata' => ['read', 'tambah', 'edit', 'delete'],
        'pengguna' => ['read', 'tambah', 'edit', 'delete'],
        'role' => ['read', 'tambah', 'edit', 'delete'],
    ];

    private const ACTION_LABELS = [
        'read' => 'Lihat',
        'tambah' => 'Tambah',
        'edit' => 'Ubah',
        'delete' => 'Hapus',
    ];

    private const FEATURE_LABELS = [
        'dashboard' => 'Dasbor',
        'kategori' => 'Kategori',
        'kata' => 'Kosakata',
        'pengguna' => 'Pengguna',
        'role' => 'Role & Hak Akses',
    ];

    public function run(): void
    {
        $permissions = collect();

        foreach (self::FEATURES as $feature => $actions) {
            foreach ($actions as $action) {
                $permissions->push(Permission::updateOrCreate(
                    ['slug' => "{$feature}.{$action}"],
                    [
                        'name' => self::FEATURE_LABELS[$feature].' - '.self::ACTION_LABELS[$action],
                        'feature' => $feature,
                        'action' => $action,
                    ]
                ));
            }
        }

        $admin = Role::updateOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Administrator', 'description' => 'Akses penuh ke seluruh fitur aplikasi.']
        );
        $admin->permissions()->sync($permissions->pluck('id'));

        $editor = Role::updateOrCreate(
            ['slug' => 'editor'],
            ['name' => 'Editor', 'description' => 'Mengelola kategori dan kosakata kamus.']
        );
        $editor->permissions()->sync(
            $permissions->filter(fn (Permission $permission) => in_array($permission->feature, ['dashboard', 'kategori', 'kata']))
                ->pluck('id')
        );

        Role::updateOrCreate(
            ['slug' => 'pengguna'],
            ['name' => 'Pengguna', 'description' => 'Pengguna terdaftar yang menjelajahi kamus.']
        );
    }
}
