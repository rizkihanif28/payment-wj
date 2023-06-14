<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Generate PDF</title>
</head>

<body>
    <br><br>
    <center>
        <h2 class="laporan-title" style="font-family:sans-serif;">Laporan Pembayaran Spp Walang Jaya</h2>
    </center>
    <br>
    <div style="float: left">
        <b style="font-family: sans-serif;">Nama Siswa : {{ $pembayaran->siswa->nama_siswa }}</b><br>
        <b style="font-family: sans-serif;">Kelas : {{ $pembayaran->siswa->kelas->nama_kelas }}</b><br>
        <b style="font-family: sans-serif;">Nisn : {{ $pembayaran->siswa->nisn }}</b><br>
        <b style="font-family: sans-serif;">Nis : {{ $pembayaran->siswa->nis }}</b><br>
    </div>
    <br><br><br>
    <table style="" border="1" cellspacing="0" cellpadding="10" width="100%">
        <thead>
            <tr>
                <th scope="col" style="font-family: sans-serif;">Petugas</th>
                <th scope="col" style="font-family: sans-serif;">Tahun</th>
                <th scope="col" style="font-family: sans-serif;">Bulan</th>
                <th scope="col" style="font-family: sans-serif;">Jumlah Bayar</th>
                <th scope="col" style="font-family: sans-serif;">Kode Pembayaran</th>
                <th scope="col" style="font-family: sans-serif;">Tanggal Bayar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-family: sans-serif;">{{ $pembayaran->petugas->nama_petugas }}</td>
                <td style="font-family: sans-serif;">{{ $pembayaran->tahun_bayar }}</td>
                <td style="font-family: sans-serif;">{{ $pembayaran->bulan_bayar }}</td>
                <td style="font-family: sans-serif;">{{ $pembayaran->jumlah_bayar }}</td>
                <td style="font-family: sans-serif;">{{ $pembayaran->kode_pembayaran }}</td>
                <td style="font-family: sans-serif;">
                    {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
