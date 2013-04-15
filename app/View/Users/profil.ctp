<?php
$this->set('title_for_layout', 'Mon profil');
?>
<h3 class="muted">Mon Profil</h3>

<div class="container">

      <!-- Example row of columns -->
      <div class="row">
        <div class="span3">
                    <h3><?php echo $user['User']['username']?></h3>
                   <?php if(file_exists($user['User']['picture'])) {
                      $url = substr($user['User']['picture'], 4);
                      echo $this->Html->image($url, array('alt' => 'fonctionnement','class'=>'img-rounded')); 
                   }  else {
                      echo $this->Html->image('user/defaultUser.png', array('alt' => 'fonctionnement','class'=>'img-rounded')); 
                   }
                   ?>
        </div>
        <div class="span3">
            <hr>
	          <h1><?php echo $user['User']['firstname'].' '.$user['User']['lastname'] ?> </h1>
                  <h6><?php echo 'Dernière connexion : '.$this->Time->format('d F y H:i', $user['User']['lastlogin'])?> </h6>
                  <h6><?php echo 'Nous a rejoint le : '.$this->Time->format('d F y H:i', $user['User']['creationdate'])?></h6>	
        </div>
        <div class="span3">
		<hr>
                <address><?php echo $user['User']['address'].'<br>'.$user['User']['zip'].' '.$user['User']['city'].' <br>'.$user['User']['country'] ?></address>
                <h6><?php echo "mail : ".$user['User']['mail']?></h6>
                <h6><?php echo "Tél : ".$user['User']['tel'];$cars=array();?></h6>
	        
        </div>
        <div class="span3">
	        <hr>   
	        <h4>TOTAL USERS</h4>
	        <div id="users"></div>
	        <h5>- DETAILS:</h5>
	        <p><i class="icos-user1" style="vertical-align:baseline"></i> Total Users: <b style="color:#ff6e01">17.110</b></p>
	       </div>

      </div><!-- /row -->
     </div>