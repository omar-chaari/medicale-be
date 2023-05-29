<!DOCTYPE html>
<html>
<head>
    <title>Activation de compte patient</title>
</head>
<body>

    <p>Merci de vous être inscrit sur plateforme médicale! Veuillez cliquer sur le lien ci-dessous pour activer votre compte:
    </p>

    <a href="{{ env('FRONTEND_APP_URL') }}/public/activation/{{ $details['token'] }}">Activer le compte</a>

    <p>Plateforme médicale</p>
</body>
</html>
