<!DOCTYPE html>
<html>
<head>
    <title>Nouveau rendez-vous médical</title>
</head>
<body>

    <p>Bonjour {{ $details['patient_name']  }} ,</p>

   <p> Nous vous informons qu'un nouveau rendez-vous a été programmé pour vous par {{ $details['pro_name']  }}  via notre plateforme médicale. Voici les détails de ce rendez-vous :
   </p>

   
   <p> Médecin : {{ $details['pro_name']  }}</p>
    <p>Spécialité :  {{ $details['pro_spec']  }} </p>
    <p>Adresse :  {{ $details['pro_adresse']  }}</p>
    <p>Date et heure :  {{ $details['date']  }}</p>


    <p>Nous vous rappelons l'importance d'arriver à l'heure pour votre rendez-vous. Si vous ne pouvez pas vous présenter pour une raison quelconque, nous vous prions de bien vouloir nous prévenir au moins 24 heures à l'avance.</p>


    <p>Plateforme médicale</p>

    
</body>
</html>
