<!-- File: /app/View/Events/index.ctp  (edit links added) -->

<div class='padding'><h1 class='title_event'><?php echo $event['Event']['title']; ?></h1>
<?php echo $this->Html->link("Refuser", array('action' => 'refuse'),
      array('class' => 'btn btn-danger pull-right'));

      echo $this->Html->link("Participer", array('action' => 'participate'),
      array('class' => 'btn btn-info pull-right'));
?>

</div>


<table class="event_view">

    <tr>
        <td>
<?php   
    if($event['Event']['visibility'] == 0){
        echo "<i class='icon-globe'></i></td><td>
              Public a Créé par : ".$user;
    }else{
        echo "<i class='icon-group'></i></td><td>
             Privé . Créé par : "."jean valjeant</td>";
    }
?>
        
    </tr>
    
    <tr>
        

    <td><i class="icon-align-justify"></i></td>
    <td>
    <?php echo $event['Event']['desc'];?>
        </td>
</tr>

</table>

 
