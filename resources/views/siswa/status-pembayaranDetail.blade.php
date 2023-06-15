@extends('layouts.master')
@section('title', 'Status Pembayaran')

@push('css')
    {{-- DataTables --}}
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="col-12">
        <h5> Pembayaran SPP : {{ $siswa->nama_siswa }} </h5>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="callout callout-info">
                <h5>Info Siswa</h5>
                <p>
                    Nama Siswa : <b>{{ $siswa->nama_siswa }}</b><br>
                    Nisn : <b>{{ $siswa->nisn }}</b><br>
                    Kelas : <b>{{ $siswa->kelas->nama_kelas }}</b><br>
                    Jenis Kelamin : <b>{{ $siswa->jenis_kelamin }}</b>
                </p>
            </div>
            <div class="callout callout-danger">
                <h5>Pemberitahuan!</h5>
                <p>Garis biru pada list tahun menandakan tahun aktif / tahun sekarang.</p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card" style="margin-top: 30px;">
                <div class="card-header">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm periode-spp">
                        <i class="fas fa-circle fa-fw"></i> PILIH TAHUN
                    </a>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach ($periode as $item)
                            @if ($item->tahun == date('Y'))
                                <a href="{{ route('siswa.status-bulan', [$item->tahun]) }}"
                                    class="list-group-item list-group-item-action active">
                                    {{ $item->tahun }}
                                </a>
                            @else
                                <a href="{{ route('siswa.status-bulan', [$item->tahun]) }}"
                                    class="list-group-item list-group-item-action">
                                    {{ $item->tahun }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
