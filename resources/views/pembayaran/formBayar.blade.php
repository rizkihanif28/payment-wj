@extends('layouts.master')
@section('title', 'Form Pembayaran')

@section('css')
    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/templates/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
@endsection

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
                    <form method="POST" action="#">
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
                                    <select class="select2 form-control" name="tahun_bayar" id="tahun_bayar" required>
                                        <option>--PILIH PERIODE--</option>
                                        @foreach ($periode as $item)
                                            <option value="{{ $item->tahun }}">{{ $item->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="jumlah_bayar">Nominal</label>
                                    <input required type="" name="nominal" readonly id="nominal"
                                        class="form-control">
                                    <input required type="hidden" name="jumlah_bayar" readonly id="jumlah_bayar"
                                        class="form-control">
                                    @error('jumlah_bayar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="bulan_bayar">Bulan</label>
                                    <select required name="bulan_bayar[]" id="bulan_bayar" class="select2"
                                        multiple="multiple" data-placeholder="Pilih Bulan" style="width: 100%">
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
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({});
        });
    </script>
@endpush
