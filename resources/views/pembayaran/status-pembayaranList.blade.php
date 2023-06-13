@extends('layouts.master')
@section('title', 'Status Pembayaran List')

@push('css')
    {{-- DataTables --}}
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h5>Status Pembayaran : {{ $siswa->nama_siswa }}</h5>
            <h5>Periode / Tahun : {{ $periode->tahun }}</h5>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('pembayaran.status-pembayaran.detail', $siswa->nisn) }}"
                        class="btn btn-danger btn-sm">
                        <i class="fas fa-fw fa-arrow-left"></i> KEMBALI
                    </a>
                </div>
                <div class="card-body">
                    @if ($pembayaran->count() > 0)
                        <table id="dataTable1" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Nisn</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Nominal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}

    {{-- list bulan status --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($pembayaran->count() > 0)
                        <table id="dataTable2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bulan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Universe::bulanAll() as $key => $item)
                                    <tr>
                                        <td style="width: 5%">{{ $loop->iteration }}</td>
                                        <td>{{ $item['nama_bulan'] }}</td>
                                        <td>
                                            @if (Universe::statusPembayaran($siswa->id, $periode->tahun, $item['nama_bulan']) == 'LUNAS')
                                                <a href="javascript:(0)" class="btn btn-success btn-sm"><i
                                                        class=""></i>
                                                    {{ Universe::statusPembayaran($siswa->id, $periode->tahun, $item['nama_bulan']) }}
                                                </a>
                                            @else
                                                <a href="javascript:(0)" class="btn btn-danger btn-sm"><i
                                                        class=""></i>
                                                    {{ Universe::statusPembayaran($siswa->id, $periode->tahun, $item['nama_bulan']) }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Data Status Pembayaran Tidak Tersedia!</h4>
                            <p>Status Pembayaran Spp {{ $siswa->nama_siswa }} di Tahun {{ $periode->tahun }} belum
                                tersedia
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            {{-- card --}}
        </div>
        {{-- col --}}
    </div>
    {{-- row --}}
@endsection

@push('customJS')
    {{-- Plugin & Datatables  --}}
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Data Table 2
            $('#dataTable2').DataTable({
                "pagging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            })
        })
    </script>
@endpush
