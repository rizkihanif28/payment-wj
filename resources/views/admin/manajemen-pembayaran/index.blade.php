@extends('layouts.master')
@section('title', 'Manajemen Pembayaran')

@push('css')
    {{-- DataTables --}}
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    {{-- Sweetalert 2 --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endpush
@section('content')
    <x-alert></x-alert>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Manajemen Pembayaran</h5>
                </div>
                <div class="card-body">
                    <table id="dataTable2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Nisn</th>
                                <th>Kelas</th>
                                <th>Tanggal Bayar</th>
                                <th>Bulan</th>
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
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJS')
    {{-- Plugin & Datatables  --}}
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    {{-- Sweetalert 2 --}}
    <script type="text/javascript" src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            const table = $("#dataTable2").DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                ajax: "{{ route('pembayaran.manajemen') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'siswa.nama_siswa',
                        name: 'siswa.nama_siswa'
                    },
                    {
                        data: 'siswa.nisn',
                        name: 'siswa.nisn'
                    },
                    {
                        data: 'siswa.kelas.nama_kelas',
                        name: 'siswa.kelas.nama_kelas'
                    },
                    {
                        data: 'tanggal_bayar',
                        name: 'tanggal_bayar'
                    },
                    {
                        data: 'bulan_bayar',
                        name: 'bulan_bayar'
                    },
                    {
                        data: 'tahun_bayar',
                        name: 'tahun_bayar'
                    },
                    {
                        data: 'jumlah_bayar',
                        name: 'jumlah_bayar'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    },

                ]
            });

        });

        // delete action
        $("body").on('click', '.btn-delete', function() {
            const id = $(this).attr("id")

            Swal.fire({
                title: 'Yakin hapus data ini?',
                // text: "You won't be able to revert",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#fc544b',
                cancelButtonColor: '#78828a',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/pembayaran/" + id + "/delete",
                        method: "DELETE",
                        success: function(response) {
                            $('#dataTable2').DataTable().ajax.reload()
                            Swal.fire(
                                '',
                                response.message,
                                'success'
                            )
                        }
                    })
                }
            })
        })
    </script>
@endpush
