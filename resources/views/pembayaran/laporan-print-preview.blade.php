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
    <h2 class="laporan-title" style="font-family:sans-serif;">Laporan Pembayaran Spp Walang Jaya</h2>
    <br>
    <b>Dari Tanggal {{ \Carbon\Carbon::parse(request()->tanggal_mulai)->format('d-m-Y') }} -
        {{ \Carbon\Carbon::parse(request()->tanggal_selesai)->format('d-m-Y') }}</b>
    <br><br>
    <div class="dataLaporan">
        <table class="table table-striped table-bordered">
    </div>

    </table>
</body>

</html>
