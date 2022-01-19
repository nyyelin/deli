<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Laravel QR Code Example</title>
</head>
<body>

<div class="text-center" style="margin-top: 50px;">
    <h3>Laravel QR Code Example</h3>

    {!! QrCode::size(100)->generate('www.youtube.com'); !!}

    <p>MyNotePaper</p>
</div>

</body>
</html>