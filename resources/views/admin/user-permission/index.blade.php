@extends('layouts.master')
@section('title', 'User Permission')

@push('css')
    {{-- DataTables --}}
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush


@section('content')
    <x-alert></x-alert>
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">User Permission</h4>
            <div class="card">
                <div class="card-header">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#createModal">
                        <i class="fas fa-users fa-fw"></i> User List
                    </a>
                </div>
                {{-- card header --}}
                <div class="card-body">
                    <table id="dataTable2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Permission</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>
                                        @foreach ($item->roles as $role)
                                            @if ($item->hasAnyRole('admin'))
                                                <span class="badge badge-primary">
                                                    {{ $role->name }}
                                                </span>
                                            @endif
                                            @if ($item->hasAnyRole('petugas'))
                                                <span class="badge badge-success">
                                                    {{ $role->name }}
                                                </span>
                                            @endif
                                            @if ($item->hasAnyRole('siswa'))
                                                <span class="badge badge-warning">
                                                    {{ $role->name }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="row mx-auto">
                                            <a href="{{ route('user-permission.create', $item->id) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit fa-fw"></i> Handle
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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

@push('customJS')
    {-- Plugin & Datatables --}
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $("#dataTable1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            });
            $('#dataTable2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        })
    </script>
@endpush
