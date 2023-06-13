@extends('layouts.master')
@section('title', 'Profile')

@section('content')
    <x-alert></x-alert>
    @role('admin|petugas')
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-header">
                        <h5>Profil</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="" name="" value="{{ Universe::petugas()->nama_petugas }}" readonly
                                        id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Kode Petugas</label>
                                    <input type="" name="" value="{{ Universe::petugas()->kode_petugas }}"
                                        readonly id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">NIP</label>
                                    <input type="" name="" value="{{ Universe::petugas()->nip }}" readonly
                                        id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="" name="" value="{{ Auth::user()->username }}" readonly
                                        id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="" name="" value="{{ Auth::user()->email }}" readonly
                                        id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5>Ubah Password Login</h5>
                </div>
                <form action="" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="old_password">Password Sekarang</label>
                            <input type="password" name="old_password" required id="old_password" class="form-control">
                            @error('old_password')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <input type="password" name="new_password" required id="new_password" class="form-control">
                            @error('new_password')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i>
                                Ubah Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="callout callout-danger">
                <h5>Pemberitahuan!</h5>
                <p>Password default / Password bawaan dari WEB SPP-WJ adalah : <b>password</p>
            </div>
        </div>
    </div>
@endsection
