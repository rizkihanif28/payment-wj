@extends('layouts.master')
@section('content-title', 'Log Activity')

@push('css')
    {{-- DataTables --}}
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Log Activity</h5>
                </div>
                {{-- card-header --}}
                <div class="card-body">
                    <div class="accordion" id="accordionExample">
                        @forelse ($logs as $key => $log)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button {{ $key != 0 ? 'collapsed' : '' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-{{ $key }}"
                                        aria-expanded="true" aria-controls="collapse-{{ $key }}">
                                        <span>{{ $log->description }}</span> <small
                                            class="text-muted ms-2 pb-1">({{ $log->created_at->diffForHumans() }})</small>
                                    </button>
                                </h2>
                                <div id="collapse-{{ $key }}"
                                    class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @if ($log->event == 'updated')
                                            <ul class="list-group">
                                                <li class="list-group-item bg-secondary text-white">Old Data</li>
                                                <li class="list-group-item"><strong>Status:</strong>
                                                    {{ $log['properties']['old']['status'] }}</li>
                                                <li class="list-group-item"><strong>Tanggal Bayar:</strong>
                                                    {{ $log['properties']['old']['tanggal_bayar'] }}</li>
                                                <li class="list-group-item"><strong>Bulan Bayar:</strong>
                                                    {{ $log['properties']['old']['bulan_bayar'] }}</li>
                                                <li class="list-group-item"><strong>Tahun Bayar:</strong>
                                                    {{ $log['properties']['old']['tahun_bayar'] }}</li>
                                                <li class="list-group-item"><strong>Jumlah Bayar:</strong>
                                                    {{ $log['properties']['old']['jumlah_bayar'] }}</li>
                                                <li class="list-group-item bg-secondary text-white">New Data</li>
                                                <li class="list-group-item"><strong>Status:</strong>
                                                    {{ $log['properties']['attributes']['status'] }}</li>
                                                <li class="list-group-item"><strong>Tanggal Bayar:</strong>
                                                    {{ $log['properties']['attributes']['tanggal_bayar'] }}</li>
                                                <li class="list-group-item"><strong>Bulan Bayar:</strong>
                                                    {{ $log['properties']['attributes']['bulan_bayar'] }}</li>
                                                <li class="list-group-item"><strong>Tahun Bayar:</strong>
                                                    {{ $log['properties']['attributes']['tahun_bayar'] }}</li>
                                                <li class="list-group-item"><strong>Jumlah Bayar:</strong>
                                                    {{ $log['properties']['attributes']['jumlah_bayar'] }}</li>
                                            </ul>
                                        @else
                                            {{ $log->description }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{ $key }}" aria-expanded="true"
                                        aria-controls="collapse-{{ $key }}">
                                        No activity found.
                                    </button>
                                </h2>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
