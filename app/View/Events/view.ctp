<!-- File: /app/View/Events/index.ctp  (edit links added) -->

<h1>Détails de l'événement</h1>


<ul>
        <li><?php echo '<strong>Titre : </strong>'.$event['Event']['title']; ?></li><br>
        <li><?php echo '<strong>Déscription de l\'événement : </strong>'.$event['Event']['desc']; ?></li>
        <li><?php echo $event['Event']['start']; ?></li>
        <li><?php echo $event['Event']['end']; ?></li>
        <li><?php echo $event['Event']['address']; ?></li>
        <li><?php echo $event['Event']['city']; ?></li>
        <li><?php echo $event['Event']['zip']; ?></li>
        <li><?php echo $event['Event']['amount']; ?></li>
        
</ul>    
    