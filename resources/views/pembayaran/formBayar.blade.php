@extends('layouts.master')
{{-- @extends('layouts.app') --}}
@section('title', 'Form Pembayaran')

@push('css')
    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap5/select2-bootstrap-5-theme.min.css') }}">
@endpush

@section('content')
    <x-alert></x-alert>
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <p style="font-size:20px; color:black; font-weight:400">Form Pembayaran Siswa</p>
                    <hr>
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-window-close fa-fw"></i>
                        BATALKAN
                    </a>
                </div>
                {{-- card header --}}
                <div class="card-body">
                    <form method="POST" action="{{ route('pembayaran.post', $siswa->nisn) }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="nama_siswa">Nama Siswa</label>
                                    <input required type="hidden" name="siswa_id" value="{{ $siswa->id }}" readonly
                                        id="siswa_id" class="form-control">
                                    <input required type="text" name="nama_siswa" value="{{ $siswa->nama_siswa }}"
                                        readonly id="nama_siswa" class="form-control">
                                    @error('nama_siswa')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="nisn">Nisn</label>
                                    <input required type="text" name="nisn" value="{{ $siswa->nisn }}" readonly
                                        id="nisn" class="form-control">
                                    @error('nisn')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="nis">Nis</label>
                                    <input required type="text" name="nis" value="{{ $siswa->nis }}" readonly
                                        id="nis" class="form-control">
                                    @error('nis')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="kelas">Kelas</label>
                                    <input required type="text" name="kelas" value="{{ $siswa->kelas->nama_kelas }}"
                                        readonly id="kelas" class="form-control">
                                    @error('kelas')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="tahun_bayar">Periode</label>
                                    <select required="" name="tahun_bayar" id="tahun_bayar"
                                        class="form-control select2bs5">
                                        <option disabled="" selected="">- PILIH TAHUN -</option>
                                        @foreach ($periode as $row)
                                            <option value="{{ $row->tahun }}">{{ $row->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="jumlah_bayar" id="nominal_spp_label">Nominal Spp</label>
                                    <input type="" name="nominal" readonly="" id="nominal" class="form-control">
                                    <input required="" type="hidden" name="jumlah_bayar" readonly=""
                                        id="jumlah_bayar" class="form-control">
                                    @error('jumlah_bayar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="bulan_bayar">Bulan</label>
                                    <select required="" name="bulan_bayar[]" id="bulan_bayar" class="select2"
                                        data-placeholder="-PILIH BULAN-" multiple="multiple">
                                        @foreach (Universe::bulanAll() as $bulan)
                                            <option value="{{ $bulan['nama_bulan'] }}">{{ $bulan['nama_bulan'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="total_bayar">Total Bayar</label>
                                    <input required type="" name="total_bayar" readonly id="total_bayar"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i>
                                KONFIRMASI
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJS')
    {{-- Select2  --}}
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize class select2
            $('.select2').select2({
                theme: "bootstrap-5",
                closeOnSelect: false,

            });
            //Initialize class Select2bs5
            $('.select2bs5').select2({
                theme: 'bootstrap-5'
            })

            function rupiah(number) {
                const formatter = new Intl.NumberFormat('ID', {
                    style: 'currency',
                    currency: 'idr',
                })

                return formatter.format(number)
            }


            $(document).on("change", "#tahun_bayar", function() {
                var tahun = $(this).val()

                $.ajax({
                    url: '/pembayaran/spp/' + tahun,
                    method: "GET",
                    success: function(response) {
                        $("#nominal_spp_label").html(`Spp ` + tahun + '')
                        $("#nominal").val(response.nominal_rupiah)
                        $("#jumlah_bayar").val(response.data.nominal)
                    }
                })
            })

            $(document).on("change", "#bulan_bayar", function() {
                var bulan = $(this).val()
                var total_bulan = bulan.length
                var total_bayar = $("#jumlah_bayar").val()
                var hasil_bayar = (total_bulan * total_bayar)

                var formatter = new Intl.NumberFormat('ID', {
                    style: 'currency',
                    currency: 'idr',
                })

                $("#total_bayar").val(formatter.format(hasil_bayar))
            })

        });
    </script>
@endpush
