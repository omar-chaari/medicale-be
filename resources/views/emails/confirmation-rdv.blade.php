<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de votre rendez-vous médical</title>
</head>
<body>

    <p>Bonjour {{ $details['patient_name']  }} ,</p>

   <p> Nous avons le plaisir de vous confirmer votre rendez-vous chez Dr {{ $details['pro_name']  }}  le {{ $details['date']  }}  à {{ $details['heure']  }} .
    
    <p>Nous vous rappelons l'importance d'arriver à l'heure pour votre rendez-vous. Si vous ne pouvez pas vous présenter pour une raison quelconque, nous vous prions de bien vouloir nous prévenir au moins 24 heures à l'avance.</p>


    <p>Plateforme médicale</p>

    
</body>
</html>
