<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
</head>
<body>
<x-navbar :links="[ 
        ['url' => '/home', 'label' => 'Home'], 
        ['url' => '/topup', 'label' => 'Topup'], 
        ['url' => '/cekTransaksi', 'label' => 'Cek Transaksi'], 
        ['url' => '/kontak', 'label' => 'kontak'], 
    ]" />

    <div class="container mx-auto mt-20 p-5">
        <h1>hello world</h1>

    </div>
</body>
</html>