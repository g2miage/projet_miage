<?php

class Supplierrating extends AppModel {
    public $actsAs = array('Containable');
    public $belongsTo = array(
        'User' => array(
            'className'    => 'User',
            'foreignKey'   => 'id_supplier'
        )
    );
}
?>

