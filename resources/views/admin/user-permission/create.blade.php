@extends('layouts.master')
@section('title', 'User Permission')

@push('css')
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
                    <a href="{{ route('user-permission.index') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-window-close fa-fw"></i>BACK
                    </a>
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-tie fa-fw"></i>Username: {{ $users->username }}
                    </a>
                </div>
                {{-- card header --}}
                <div class="card-body">
                    <form method="POST" action="{{ route('user-permission.store', $users->id) }}">
                        @csrf
                        <div class="form-group select2-purple" id="form-permission">
                            <label style="font-size: 18px">Permission</label>
                            <select name="permission[]" class="select2" multiple data-dropdown-css-class="select2-purple"
                                data-placeholder="Select a Permission" style="width: 100%;">
                                @foreach ($permission as $item)
                                    @if ($users->hasAnyPermission($item->name))
                                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save fa-fw"></i> SIMPAN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJS')
    {{-- Select2 --}}
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endpush
