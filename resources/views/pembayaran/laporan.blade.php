@extends('layouts.master')
@section('title', 'Laporan Pembayaran')


@section('content')
    <x-alert></x-alert>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Laporan Pembayaran Spp</h5>
                </div>
                {{-- card header --}}
                <div class="card-body">
                    <form action="{{ route('pembayaran.print-laporan') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" required class="form-control"
                                id="tanggal_mulai_laporan">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" required class="form-control"
                                id="tanggal_selesai_laporan">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-print fa-fw"></i> PRINT
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- card --}}
        </div>
        {{-- col --}}
    </div>
    {{-- row --}}
@endsection
