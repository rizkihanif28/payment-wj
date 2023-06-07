<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Periode;
use App\Models\Petugas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //siswa
        Permission::create([
            'name' => 'create-siswa'
        ]);
        Permission::create([
            'name' => 'read-siswa'
        ]);
        Permission::create([
            'name' => 'update-siswa'
        ]);
        Permission::create([
            'name' => 'delete-siswa'
        ]);

        //users
        Permission::create([
            'name' => 'create-users'
        ]);
        Permission::create([
            'name' => 'read-users'
        ]);
        Permission::create([
            'name' => 'update-users'
        ]);
        Permission::create([
            'name' => 'delete-users'
        ]);

        Permission::create([
            'name' => 'create-petugas'
        ]);
        Permission::create([
            'name' => 'read-petugas'
        ]);
        Permission::create([
            'name' => 'update-petugas'
        ]);
        Permission::create([
            'name' => 'delete-petugas'
        ]);

        //periode
        Permission::create([
            'name' => 'create-periode'
        ]);
        Permission::create([
            'name' => 'read-periode'
        ]);
        Permission::create([
            'name' => 'update-periode'
        ]);
        Permission::create([
            'name' => 'delete-periode'
        ]);

        //kelas
        Permission::create([
            'name' => 'create-kelas'
        ]);
        Permission::create([
            'name' => 'read-kelas'
        ]);
        Permission::create([
            'name' => 'update-kelas'
        ]);
        Permission::create([
            'name' => 'delete-kelas'
        ]);

        //roles
        Permission::create([
            'name' => 'create-roles'
        ]);
        Permission::create([
            'name' => 'read-roles'
        ]);
        Permission::create([
            'name' => 'update-roles'
        ]);
        Permission::create([
            'name' => 'delete-roles'
        ]);

        //permission
        Permission::create([
            'name' => 'create-permissions'
        ]);
        Permission::create([
            'name' => 'read-permissions'
        ]);
        Permission::create([
            'name' => 'update-permissions'
        ]);
        Permission::create([
            'name' => 'delete-permissions'
        ]);

        //pembayaran
        Permission::create([
            'name' => 'create-pembayaran'
        ]);
        Permission::create([
            'name' => 'read-pembayaran'
        ]);
        Permission::create([
            'name' => 'update-pembayaran'
        ]);
        Permission::create([
            'name' => 'delete-pembayaran'
        ]);

        //seed periode
        Periode::create([
            'tahun' => '2021',
            'nominal' => 300000,
        ]);
        Periode::create([
            'tahun' => '2020',
            'nominal' => 300000
        ]);
        Periode::create([
            'tahun' => '2023',
            'nominal' => 400000
        ]);

        //seed role 
        $role1 = Role::create([
            'name' => 'admin'
        ]);

        $role1->syncPermissions([
            'create-siswa', 'read-siswa', 'update-siswa', 'delete-siswa',
            'create-kelas', 'read-kelas', 'update-kelas', 'delete-kelas',
            'create-periode', 'read-periode', 'update-periode', 'delete-periode',
            'create-users', 'read-users', 'update-users', 'delete-users',
            'create-petugas', 'read-petugas', 'update-petugas', 'delete-petugas',
            'create-roles', 'read-roles', 'update-roles', 'delete-roles',
            'create-pembayaran', 'read-pembayaran', 'update-pembayaran', 'delete-pembayaran',
            'create-permissions', 'read-permissions', 'update-permissions', 'delete-permissions',
        ]);

        $role2 = Role::create([
            'name' => 'petugas'
        ]);

        $role2->syncPermissions([
            'create-siswa', 'read-siswa', 'update-siswa', 'delete-siswa',
            'create-kelas', 'read-kelas', 'update-kelas', 'delete-kelas',
            'create-periode', 'read-periode', 'update-periode', 'delete-periode',
            'create-pembayaran', 'read-pembayaran', 'update-pembayaran', 'delete-pembayaran',
        ]);

        $role3 = Role::create([
            'name' => 'siswa'
        ]);

        //seed kelas
        $kelas1 = Kelas::create([
            'nama_kelas' => 'X TKR 1',
            'kompetensi_keahlian' => 'Teknik Kendaraan Ringan'
        ]);

        $kelas2 = Kelas::create([
            'nama_kelas' => 'X TSM 1',
            'kompetensi_keahlian' => 'Teknik Sepeda Motor'
        ]);

        $kelas3 = Kelas::create([
            'nama_kelas' => 'X AK 1',
            'kompetensi_keahlian' => 'Akutansi'
        ]);

        $kelas4 = Kelas::create([
            'nama_kelas' => 'X AP 1',
            'kompetensi_keahlian' => 'Administrasi Perkantoran'
        ]);

        $user1 = User::create([
            'username' => 'admin123',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ]);
        $user1->assignRole('admin');

        $petugas1 = Petugas::create([
            'user_id' => $user1->id,
            'kode_petugas' => 'WJ' . Str::upper(Str::random(5)),
            'nip' => '00111',
            'nama_petugas' => 'Administrator',
            'jenis_kelamin' => 'Laki-Laki',
            'email' => 'admin@gmail.com'
        ]);

        $user2 = User::create([
            'username' => 'tatausaha1',
            'email' => 'tatausaha1@gmail.com',
            'password' => Hash::make('password')
        ]);
        $user2->assignRole('petugas');

        $petugas2 = Petugas::create([
            'user_id' => $user2->id,
            'kode_petugas' => 'PTGS' . Str::upper(Str::random(2)),
            'nip' => '00112',
            'nama_petugas' => 'Tata Usaha',
            'jenis_kelamin' => 'Laki-Laki',
            'email' => 'tatausaha1@gmail.com'
        ]);

        $user3 = User::create([
            'username' => 'rizkihanif',
            'email' => 'rizkihnf2@gmail.com',
            'password' => Hash::make('hanif28')
        ]);
        $user3->assignRole('siswa');

        Siswa::create([
            'user_id' => $user3->id,
            'kelas_id' => $kelas1->id,
            'kode_siswa' => 'SSW' . Str::upper(Str::random(5)),
            'nisn' => '09080701',
            'nis' => '20201111',
            'nama_siswa' => 'Mohamad Rizki Hanif',
            'jenis_kelamin' => 'Laki-Laki',
            'email' => 'rizkihnf2@gmail.com',
            'alamat' => 'Jl. Walang Jaya 10',
            'telepon' => '089526456198'
        ]);

        $user4 = User::create([
            'username' => 'rian07',
            'email' => 'rian07@gmail.com',
            'password' => Hash::make('rian07')
        ]);
        $user4->assignRole('siswa');

        Siswa::create([
            'user_id' => $user4->id,
            'kelas_id' => $kelas2->id,
            'kode_siswa' => 'SSW' . Str::upper(Str::random(5)),
            'nisn' => '09080702',
            'nis' => '20201112',
            'nama_siswa' => 'Andriansyah',
            'jenis_kelamin' => 'Laki-Laki',
            'email' => 'rian07@gmail.com',
            'alamat' => 'Jl. Walang Jaya 11',
            'telepon' => '089626456196'
        ]);

        $user5 = User::create([
            'username' => 'zizah79',
            'email' => 'zizah79@gmail.com',
            'password' => Hash::make('zizah79')
        ]);
        $user5->assignRole('siswa');

        Siswa::create([
            'user_id' => $user5->id,
            'kelas_id' => $kelas3->id,
            'kode_siswa' => 'SSW' . Str::upper(Str::random(5)),
            'nisn' => '09080703',
            'nis' => '20201113',
            'nama_siswa' => 'Nurul Azizah',
            'jenis_kelamin' => 'Perempuan',
            'email' => 'zizah79@gmail.com',
            'alamat' => 'Jl. Walang Jaya 9',
            'telepon' => '089626456196'
        ]);
    }
}
