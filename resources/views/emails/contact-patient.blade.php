<!DOCTYPE html>
<html>
<head>
    <title>Validation compte de patient</title>
</head>
<body>
    <h3>Votre compte de patient a été validé</h3>
    <p><b>Nom et Prenom:</b> {{ $details['first_name']  }} {{ $details['last_name']}}</p>
    <p><b>Adresse mail :</b> {{ $details['email'] }}</p>
    <p><b>Téléphone Mobile :</b> {{ $details['phone'] }}</p>
    <p>Plateforme médicale</p>
</body>
</html>
