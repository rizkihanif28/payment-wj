<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Generate PDF</title>
</head>

<body>
    <center>
        <h2 style="font-family:sans-serif;">Laporan Pembayaran Spp Walang Jaya</h2>
        <hr>
    </center>
    <br>
    <b>Dari Tanggal {{ \Carbon\Carbon::parse(request()->tanggal_mulai)->format('d-m-Y') }} -
        {{ \Carbon\Carbon::parse(request()->tanggal_selesai)->format('d-m-Y') }}</b>
    <br><br>
    <table border="1" cellspacing="0" cellpadding="10" width="100%">
        <thead>
            <tr>
                <th scope="col" style="font-family: sans-serif;">No</th>
                <th scope="col" style="font-family: sans-serif;">Nama Siswa</th>
                <th scope="col" style="font-family: sans-serif;">Nisn</th>
                <th scope="col" style="font-family: sans-serif;">Kelas</th>
                <th scope="col" style="font-family: sans-serif;">Tanggal Bayar</th>
                <th scope="col" style="font-family: sans-serif;">Petugas</th>
                <th scope="col" style="font-family: sans-serif;">Jumlah Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayaran as $item)
                <tr>
                    <th scope="row" style="font-family: sans-serif;">{{ $loop->iteration }}</th>
                    <td style="font-family: sans-serif;">{{ $item->siswa->nama_siswa }}</td>
                    <td style="font-family: sans-serif;">{{ $item->nisn }}</td>
                    <td style="font-family: sans-serif;">{{ $item->siswa->kelas->nama_kelas }}</td>
                    <td style="font-family: sans-serif;">
                        {{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d-m-Y') }}
                    </td>
                    <td style="font-family: sans-serif;">{{ $item->petugas->nama_petugas }}</td>
                    <td style="font-family: sans-serif;">{{ $item->jumlah_bayar }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
</body>

</html>
