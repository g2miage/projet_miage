<h1>Modifier l'événement</h1>
<?php
    echo $this->Form->create('Event', array('type' => 'file'));
    echo $this->Form->input('title', array('label' => 'Titre'));
    //echo $this->Form->input('desc', array('label' => 'Description','rows' => '3'));
    echo $this->Tinymce->input('Event.desc',array('label' => 'Description')); 

    echo $this->Form->input('startday', array('date', 'label' => 'Date de début'));
    echo $this->Form->input('starttime', array('label' => 'Heure de début'));
    echo $this->Form->input('endday', array('label' => 'Date de fin'));
    echo $this->Form->input('endtime', array('label' => 'Heure de fin'));
    echo $this->Form->input('address', array('label' => 'Adresse'));
    echo $this->Form->input('zip', array('label' => 'Code postal'));
    echo $this->Form->input('city', array('label' => 'Ville'));
    echo $this->Form->input('amount', array('label' => 'Prix d\'entrée'));
    echo 'Cochez si l\'événement est privé : '.$this->Form->checkbox('visibility');
    echo '<br /><br />';
    if(!empty($this->data['Event']['picture'])){
        echo $this->Html->image($this->data['Event']['picture'], array('alt' => ':/','height'=>'150px','width'=>'200px'));
        echo $this->Html->link('<i class="icon-remove"> Suprimer l\'image</i>', array('action' => 'deleteimg',$this->data['Event']['id']), array('escape' => false));
        echo $this->Form->input('picture', array('type' => 'file', 'label' => 'Modifier l\'image (taille maximum 2Mo)'));
        echo '<br /><br />';
    }  else {
        echo $this->Form->input('picture', array('type' => 'file', 'label' => 'Ajouter une image (taille maximum 2Mo)'));
        echo '<br /><br />';
    }
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end(array('label' => 'Enregistrer', 'class' => 'btn btn-primary', 'div' => false));
?>