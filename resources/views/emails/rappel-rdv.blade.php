<!DOCTYPE html>
<html>
<head>
    <title>Rappel de Rendez-vous</title>
</head>
<body>
<p>Bonjour  {{ $details['patient_first_name']  }} {{ $details['patient_last_name']}},</p>

<p>
    Ceci est un rappel  de la part de la plateforme médicale concernant votre prochain rendez-vous.
</p>

<p>Détails du rendez-vous :</p>
<ul>
    <li>Date et heure :  {{ $details['date_debut']  }}</li>

    <li>Médecin : Dr {{ $details['pro_first_name']  }} {{ $details['pro_last_name']}}</li>

    <li>Adresse :  {{ $details['pro_address']  }}</li>

</ul>



<p>
    Plateforme medicale
</p>

<hr>
<small>
    Veuillez noter : C'est un message automatique, merci de ne pas y répondre. Pour toute question ou demande, veuillez nous contacter directement.
</small>


</body>
</html>



