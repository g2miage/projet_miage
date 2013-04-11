<?php
$this->set('title_for_layout', 'Mon profil');
?>
<div class="masthead">
    <h3 class="muted">Project name</h3>
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <ul class="nav">
                    <li class="active"><?php echo $this->Html->link('Mon Compte', array('controller' => 'users', 'action' => 'edit')); ?></li>
                    <li><?php echo $this->Html->link('Mes Evenements', array('controller' => 'events', 'action' => 'user_events')); ?></li>
                </ul>
            </div>
        </div>
    </div><!-- /.navbar -->
</div>                   

<div class="container">

      <!-- Example row of columns -->
      <div class="row">
        <div class="span3">
      		<div class="dash-unit">
                   <?php echo $this->Html->image('fonctionnement_accueil.png', array('alt' => 'fonctionnement','class'=>'img-rounded')); ?>
	          <h1>BRIAN SMITH</h1>
	          <h4>London, UK.</h4>
	          <h6>Joined April 19, 2009</h6>
	          <p><i class="icon-envelope icon-white"></i> <a href="#" class="tooltip-test" data-placement="top" title="New Mails"><span class="badge badge-one">6</span></a> 
	          - <i class="icon-comment icon-white"></i> <a href="#" class="tooltip-test" data-placement="top" title="New Messages"><span class="badge badge-one">2</span></a></p>
			</div>
        </div>
        <div class="span3">
            <hr>   
            <h4>REVENUE INFO</h4>
	        <div id="money"></div>
            <h5>- DETAILS:</h5>
			<p><i class="icos-heart" style="vertical-align:baseline"></i> Total Earnings: <b style="color:#ff6e01">$44.550</b></p>
        </div>
        <div class="span3">
			<hr>
	        <h4>MONTHLY VISITS</h4>
	        <div id="site"></div>
	        <h5>- DETAILS:</h5>
	        <p><i class="icos-fire" style="vertical-align:baseline"></i> Total Visits: <b style="color:#ff6e01">447.763</b></p>
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