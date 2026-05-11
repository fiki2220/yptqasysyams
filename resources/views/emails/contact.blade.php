<!DOCTYPE html>
<html>
<head>
    <title>Pesan Baru</title>
</head>
<body>
    <h2>Pesan Baru dari Formulir Kontak Website</h2>
    <p><strong>Nama:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>No. WhatsApp:</strong> {{ $data['phone'] }}</p>
    <br>
    <p><strong>Isi Pesan:</strong></p>
    <p>{{ $data['message'] }}</p>
</body>
</html>