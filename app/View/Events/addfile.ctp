<?php
// Erwann et Paul upload fichier ---------------------------------------------

// Création du formulaire d'upload d'invités
echo $this->form->create('User', array('type' => 'file'));
echo $this->form->input('',array('type' => 'file'));
echo $this->form->end('Sauvegarder le fichier');

?>