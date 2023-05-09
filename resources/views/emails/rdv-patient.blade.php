<!DOCTYPE html>
<html>
<head>
    <title>Rendez-vous patient</title>
</head>
<body>

    <p>Bonjour Dr {{ $details['professional']  }} ,</p>

    <p>Nous vous informons qu'un patient a récemment pris un rendez-vous avec vous via notre plateforme médicale. Voici les détails du rendez-vous :
    
    <p>Nom du patient : {{ $details['patient']  }}</p>
    <p>Téléphone du patient : {{ $details['patient_tel']  }}</p>
    <p>Date et heure du rendez-vous : {{ $details['date']  }}</p>
    @if (!empty($details['motif_consultation']))
    <p>Motif de la consultation : {{ $details['motif_consultation'] }}</p>
@endif
    
    <p>Nous vous remercions de la confiance que vous accordez à notre plateforme médicaleet restons à votre disposition pour toute question ou besoin d'assistance.</p>

    <p>Pour rappel, vous pouvez accéder à votre compte professionnel sur la plateforme médicale.</p> 


    <p>Plateforme médicale</p>

    
</body>
</html>
