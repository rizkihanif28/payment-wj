@extends('layouts.master')
@section('title', 'Data Siswa')

@push('css')
    {{-- DataTables --}}
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    {{-- Sweetalert 2 --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <x-alert></x-alert>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @can('create-siswa')
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#createModal">
                            <i class="fas fa-plus fa-fw"></i> Tambah Data
                        </a>
                    @endcan
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="dataTable2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Nisn</th>
                                <th>Kelas</th>
                                <th>Jenis Kelamin</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
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
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection


@push('customJS')
    {{-- Plugin & Datatables  --}}
    <script src="{{ 'plugins/datatables/jquery.datatables.min.js' }}"></script>
    <script src="{{ 'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js' }}"></script>
    <script src="{{ 'plugins/datatables-responsive/js/dataTables.responsive.min.js' }}"></script>
    <script src="{{ 'plugins/datatables-responsive/js/responsive.bootstrap.min.js' }}"></script>
    {{-- Sweetalert 2 --}}
    <script type="text/javascript" src="{{ 'plugins/sweetalert2/sweetalert2.min.js' }}"></script>
    {{-- Select2 --}}
    <script src="{{ 'plugins/select2/js/select2.full.min.js' }}"></script>

    @include('admin/siswa/ajax')
@endpush
