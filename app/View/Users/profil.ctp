<?php
$this->set('title_for_layout', 'Mon profil');
?>
<div class='padding'><h1 class="muted">Mon Profil
        <?php
        echo $this->Html->link("Modifier le Profil", array('action' => 'edit', $user['User']['id']), array('class' => 'btn btn-info pull-right'));
        ?></h1>
</div>

<div class="container">

    <!-- Example row of columns -->
    <h2><?php echo $user['User']['firstname'].' '.$user['User']['lastname'] ?> </h2>
    <h5><?php echo $user['Suptype']['stype'] ; ?></h5>
    <div class="row">

        <div class="span3">
            <hr />
            <?php 
            if(file_exists($user['User']['picture'])) {
                $url = substr($user['User']['picture'], 4);
                echo $this->Html->image($url, array('alt' => 'fonctionnement','class'=>'img-rounded')); 
            }  else {
                echo $this->Html->image('user/defaultUser.png', array('alt' => 'fonctionnement','class'=>'img-rounded')); 
            }
            echo $this->Form->create('User', array('type' => 'File'));
            echo $this->Form->hidden('id',array('value' => $user['User']['id']));
            echo $this->Form->input('picture', array('type' => 'file', 'label' => 'Image du profil (taille maximum 2Mo)'));
            echo $this->Form->end(array('label' => 'Charger image', 'class' => 'btn btn-primary', 'div' => false));

            ?>
        </div>
        <div class="span3">
            <hr />
            <h6><?php echo 'Dernière connexion : '.$this->Time->format('d F y H:i', $user['User']['lastlogin'])?> </h6>
            <h6><?php echo 'Nous a rejoint le : '.$this->Time->format('d F y H:i', $user['User']['creationdate'])?></h6>	
        </div>
        <div class="span3">
            <hr />
            <address><?php echo $user['User']['address'].'<br>'.$user['User']['zip'].' '.$user['User']['city'].' <br>'.$user['User']['country'] ?></address>
            <?php
                if($user['User']['website'] != null) { 
                    echo '<h6>site web : '.$this->Html->link($user['User']['website'],$user['User']['website'], array('admin'=>false)).'</h6>';
                } ?>
            <h6><?php echo "mail : ".$user['User']['mail']?></h6>
            <h6><?php echo "Tél : ".$user['User']['tel'];$cars=array();?></h6>

        </div>
        <?php
        if($user['User']['suptype_id']!=0){
        ?>
        <div class="span3">
            <hr /> 
            <h5><?php echo $user['Suptype']['stype'] ; ?></h5>
            <h6><?php echo "Raison Sociale : ".$user['User']['scorpname']?></h6>
            <h6><?php echo "Siret : ".$user['User']['ssiret']?></h6>
            <p><?php echo "<b>Description :</b><br /> ".nl2br($user['User']['sdesc']);?></p>
        </div>
        <?php
        }
        ?>
    </div><!-- /row -->

</div>