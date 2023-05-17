<!DOCTYPE html>
<html>
<head>
    <title>Modification de votre rendez-vous médical</title>
</head>
<body>

    <p>Bonjour {{ $details['patient_name']  }} ,</p>

    <p>Nous tenons à vous informer que votre rendez-vous initial avec Dr {{ $details['patient_name']  }}  a dû être reporté.
       
    </p>

    <p>Votre nouveau rendez-vous a été reprogrammé pour le {{ $details['date']  }} à {{ $details['heure']  }}.
    </p>
    
    <p>Plateforme médicale</p>

    
</body>
</html>
