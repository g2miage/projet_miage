<script type="text/javascript" language="JavaScript">
function WhenChecked()
{
    if(document.getElementById('UserRoleId').checked == 1) 
        { 
          
       document.getElementById('prestat').style.visibility='visible';
       
    }else{
        document.getElementById('prestat').style.visibility='hidden';
    }
}

</script>
<h2>S'enregistrer</h2>
<?php
echo $this->Form->create('User');
echo $this->Form->input('username', array('label' => 'Login :'));
echo $this->Form->input('mail', array('label' => 'Email :'));
echo $this->Form->input('password', array('label' => 'Mot de passe :'));
echo $this->Form->input('password_confirm', array('label' => 'Confirmation Mot de passe :', 'type' => 'password'));
echo $this->Form->input('role_id', array('label' => 'Prestataire', 'type' => 'checkbox','onclick'=>'WhenChecked()'));
?>
<div id='prestat' style="visibility: hidden" >
<?php
echo $this->Form->input('scorpname', array('label' => 'Raison Sociale :'));
echo $this->Form->input('ssiret', array('label' => 'SIRET :'));

?>
</div>
<?php
echo $this->Form->end(array('label' => 'Enregistrer', 'class' => 'btn btn-primary'));
?>