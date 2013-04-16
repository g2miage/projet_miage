<p>Bonjour <?php echo $userName ?>,</p>

<p>Vous êtes invités à l'événement <?php echo $eventTitle; ?> créé par <?php echo $eventCreator ?>.</p>
<p>Un compte vient d'être créé pour vous :</p>

<table>
<tr>
    <td>Login</td> <td><?php echo $username; ?></td>
</tr>
<tr>
    <td>Mdp</td> <td> <?php echo $password; ?></td>
</tr>
</table>

<p>Vous pouvez dès à présent vous connecter au site pour confirmer ou non votre participation.</p>
<p style="padding-top:30px;">Cordialement,</p>
<p>Le groupe MyEvent</p>
