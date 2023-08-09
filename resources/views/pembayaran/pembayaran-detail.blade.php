@extends('layouts.master')
@section('title', 'Pembayaran Detail')
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4/css/bootstrap.min.css') }}">
@endpush

@section('content')
    <div class="card card-sm mt-0">
        <div class="card-header">
            <h5>Detail Pembayaran</h5>
            <hr>
            <div class="card-body">
                <form action="#">
                    <table>
                        <tr>
                            <td>Nama : </td>
                            <td>{{ $pembayaran->siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <td>Kelas : </td>
                            <td>{{ $kelas->nama_kelas }}</td>
                        </tr>
                        <tr>
                            <td>Kode Pembayaran : </td>
                            <td>{{ $pembayaran->id }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Bayar : </td>
                            <td>{{ $pembayaran->tanggal_bayar }}</td>
                        </tr>
                        <tr>
                            <td>Bulan Bayar : </td>
                            <td>{{ $pembayaran->bulan_bayar }}</td>
                        </tr>
                        <tr>
                            <td>Periode : </td>
                            <td>{{ $pembayaran->tahun_bayar }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah Bayar : </td>
                            <td>{{ $pembayaran->jumlah_bayar }}</td>
                        </tr>
                    </table>
                </form>
                <button type="submit" class="btn btn-primary mt-4" id="pay-button">Bayar Sekarang</button>
            </div>
        </div>
    </div>


@endsection

@push('customJS')
    <script src="{{ asset('plugins/bootstrap4/js/bootstrap.bundle.min.js') }}"></script>

    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.clientKey') }}"></script>

    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
    <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    alert("payment success!");
                    console.log(result);
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("wating your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });
    </script>
@endpush
