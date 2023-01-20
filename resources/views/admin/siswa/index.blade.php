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
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.css') }}">
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
                {{-- card header --}}
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
                {{-- card body --}}
            </div>
            {{-- card --}}
        </div>
        {{-- col --}}
    </div>
    {{-- row --}}


    {{-- modal create --}}
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
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
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="nama_siswa">Nama Siswa</label>
                                    <input required type="text" id="nama_siswa" name="nama_siswa" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input required type="text" id="username" name="username" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="nisn">NISN</label>
                                    <input required type="text" id="nisn" name="nisn" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="nis">NIS</label>
                                    <input required type="text" id="nis" name="nis" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select required name="jenis_kelamin" id="jenis_kelamin" class="form-control select2">
                                        <option disabled="" selected="">- PILIH JENIS KELAMIN -</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input required type="email" id="email" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input required type="text" id="alamat" name="alamat" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="telepon">Telepon</label>
                                    <input required type="text" id="telepon" name="telepon" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="kelas_id">Kelas</label>
                                    <select required name="kelas_id" id="kelas_id" class="form-control select2">
                                        <option disabled="" selected="">- PILIH KELAS -</option>
                                        @foreach ($kelas as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                        @endforeach
                                    </select>
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
    {{-- end create modal --}}

    {{-- modal edit --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Edit Data</h5>
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
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="nama_siswa_edit">Nama Siswa</label>
                                    <input type="hidden" id="id_edit" name="id_edit" class="form-control" readonly>
                                    <input required type="text" name="nama_siswa" id="nama_siswa_edit"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="nisn">NISN</label>
                                    <input required type="text" id="nisn_edit" name="nisn" class="form-control"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="nis">NIS</label>
                                    <input required type="text" id="nis_edit" name="nis" class="form-control"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="jenis_kelamin_edit">Jenis Kelamin</label>
                                    <select required name="jenis_kelamin" id="jenis_kelamin_edit"
                                        class="form-control select2">
                                        <option disabled="" selected="">- PILIH JENIS KELAMIN -</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input required type="email" id="email_edit" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="alamat_edit">Alamat</label>
                                    <input required type="text" name="alamat" id="alamat_edit" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="telepon_edit">Telepon</label>
                                    <input required type="text" name="telepon" id="telepon_edit"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="kelas_id_edit">Kelas</label>
                                    <select required name="kelas_id" id="kelas_id_edit" class="form-control select2">
                                        <option disabled="" selected="">- PILIH KELAS -</option>
                                        @foreach ($kelas as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal edit --}}
@endsection

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

    @include('admin/siswa/ajax')
@endpush
