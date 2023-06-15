@extends('layouts.master')
@section('title', 'Data Periode SPP')

@push('css')
    {{-- DataTables --}}
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    {{-- Sweetalert 2 --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.css') }}">
@endpush

@section('content')
    <x-alert></x-alert>
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Data Periode</h4>
            <div class="card">
                <div class="card-header">
                    @can('create-periode')
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#createModal">
                            <i class="fas fa-plus fa-fw"></i> Tambah Data
                        </a>
                    @endcan
                </div>
                {{-- card header --}}
                <div class="card-body">
                    <table id="dataTable2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Nominal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {{-- card body --}}
            </div>
            {{-- card --}}
        </div>
        {{-- col --}}
    </div>
    {{-- row --}}
@endsection

{{-- create modal --}}
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <hr>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="store">
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display: none;">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="tahun">Periode / Tahun</label>
                                <input type="text" required id="tahun" name="tahun" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="nominal">Nominal</label>
                                <input required type="text" id="nominal" name="nominal" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end modal create --}}

{{-- modal edit --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data</h5>
                <hr>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update">
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display: none;">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="tahun_edit">Tahun/Periode</label>
                                <input type="hidden" name="id_edit" id="id_edit" class="form-control" readonly>
                                <input required type="text" name="tahun" id="tahun_edit" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="nominal_edit">Nominal</label>
                                <input required type="text" name="nominal" id="nominal_edit"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end modal edit --}}

@push('customJS')
    {{-- Plugin & Datatables  --}}
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    {{-- Sweetalert 2 --}}
    <script type="text/javascript" src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    {{-- Select2 --}}
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    @include('admin/periode/ajax')
@endpush
