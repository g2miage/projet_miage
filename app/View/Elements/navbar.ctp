<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?php echo $this->Html->link('Accueil', array('controller' => 'pages', 'action' => 'display'), array('class' => 'brand')); ?>
            <div class="nav-collapse collapse">
                <ul class="nav">
                     <li><?php echo $this->Html->link('Contact', array('controller' => 'pages', 'action' => 'display', 'contact')); ?></li>
                </ul>      
                <form class="navbar-form pull-right" action="/projet_miage/users/login" id="UserLoginForm" method="post" accept-charset="utf-8">
                    <input type="hidden" name="_method" value="POST"/>
                    <input name="data[User][username]" maxlength="50" type="text" id="UserUsername" required="required" placeholder="Login"/>
                    <input name="data[User][password]" type="password" id="UserPassword" required="required" placeholder="Mot de passe"/>                 
                    <input class="btn" type="submit" value="Login"/>
                </form>
            </div>
        </div>
    </div>
</div>        
 
