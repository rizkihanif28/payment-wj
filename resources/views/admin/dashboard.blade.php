@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <h5>DASHBOARD</h5>

    <div class="row">
        <div class="col-lg">
            <div class="jumbotron bg-info">
                @role('admin|petugas')
                    <h1 class=" display-4">Hello, {{ Universe::petugas()->nama_petugas }}!</h1>
                @endrole

                @role('siswa')
                    <h1 class=" display-4">Hello, {{ Universe::siswa()->nama_siswa }}!</h1>
                @endrole
                <p class="lead">Selamat Datang Di Web SPP Walang Jaya</p>
                <hr class="my-4">
            </div>
        </div>
    </div>
@endsection
