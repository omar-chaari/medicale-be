<!DOCTYPE html>
<html>
<head>
    <title>Validation compte de professionnel de santé</title>
</head>
<body>
    <h3>Votre compte de profetionnel de santé a été validé</h3>
    <p><b>Nom et Prenom:</b> {{ $details['first_name']  }} {{ $details['last_name']}}</p>
    <p><b>Gouvernorat:</b> {{ $details['governorate'] }}</p>
    <p><b>Spécialité:</b> {{ $details['speciality'] }}</p>
    <p><b>Adresse mail :</b> {{ $details['email'] }}</p>
    <p><b>Téléphone Mobile :</b> {{ $details['phone'] }}</p>


    <p>Plateforme médicale</p>
</body>
</html>
