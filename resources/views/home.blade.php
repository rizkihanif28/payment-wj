@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="jumbotron bg-info" style="margin-top: 5rem">
                @role('admin|petugas')
                    <h1 class=" home-user">Hello, {{ Universe::petugas()->nama_petugas }}!</h1>
                @endrole
                @role('siswa')
                    <h1 class="home-user">Hello, {{ Universe::siswa()->nama_siswa }}!</h1>
                @endrole
                <p class="lead">Selamat Datang Di Web SPP Walang Jaya</p>
                <hr class="my-4">
                <p class="lead text-center mb-0">Silahkan pilih menu untuk memulai aktifitas</p>
            </div>
        </div>
    </div>
@endsection
