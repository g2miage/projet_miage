<?php
if ($type == 'organisateurs') {
    echo '<h1>Communication avec ' . $supplierName . '</h1>';
} else {

    echo '<h1>Communication avec les organisateurs</h1>';
}
echo '<h3>' . $this->html->link($eventName, array('action' => 'view', 'controller' => 'events', $eventId)) . '</h3>';
?>
<div class="tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">Description</a></li>
        <li><a href="#tab2" data-toggle="tab">Fichiers échangés</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <?php
            foreach ($messages as $message) {
                echo '<table class="table">';

                if ($message['Message']['orga_username'] == NULL) {

                    echo $message['Message']['date'] . '  ' . $supplierName;
                    echo '<tr class="warning"><td>' . $message['Message']['message'] . '</td>';
                    if ($type == 'prestataires') {
                        echo '<td>';
                        echo $this->Html->link('<i class="icon-trash"></i>', array('action' => 'delete', $message['Message']['id'], $eventId, $type), array('escape' => false, 'class' => 'pull-right'));
                        echo '</td>';
                    }
                } else {
                    echo $message['Message']['date'] . '  ' . $message['Message']['orga_username'];
                    echo '<tr class="success"><td>' . $message['Message']['message'] . '</td>';
                    if ($type == 'organisateurs') {
                        echo '<td>';
                        echo $this->Html->link('<i class="icon-trash"></i>', array('action' => 'delete', $message['Message']['id'], $eventId, $type, $supplierId), array('escape' => false, 'class' => 'pull-right'));
                        echo '</td>';
                    }
                }
                echo '</tr></table>';
            }

            // Création du formulaire de contact presta

            echo $this->Form->create('Message', array('action' => 'addMessage', 'div' => false));

            echo $this->Tinymce->input('Message.message', array('label' => ''), null, 'basic');
            echo $this->Form->input('Message.eventId', array('type' => 'hidden', 'value' => $eventId));
            echo $this->Form->input('Message.type', array('type' => 'hidden', 'value' => $type));
            if (isset($supplierId)) {
                echo $this->Form->input('Message.supplierId', array('type' => 'hidden', 'value' => $supplierId));
            }
            echo $this->Form->end(array('label' => 'Envoyer', 'class' => 'btn btn-primary'));
            ?>
        </div>
        <div class="tab-pane" id="tab2">

            <?php
            foreach ($files as $file) {
                $path = pathinfo($file['Message']['file']);
                echo '<table class="table">';

                if ($file['Message']['orga_username'] == NULL) {
                    echo $file['Message']['date'] . '  ' . $supplierName;
                    echo '<tr class="warning"><td>' . $this->Html->link($path['filename'], '/' . $file['Message']['file']) . '</td>';

                    if ($type == 'prestataires') {
                        if ($file['Message']['status'] == 1) {
                            echo '<td>Document Validé</td>';
                        } else {
                            echo '<td>Document Refusé</td>';
                        }
                        echo '<td>';
                        echo $this->Html->link('<i class="icon-trash"></i>', array('action' => 'delete', $file['Message']['id'], $type, $eventId), array('escape' => false, 'class' => 'pull-right'));
                        echo '</td>';
                    } else {
                        if ($file['Message']['status'] == 1) {
                            
                            echo '<td>Document Validé</td>';
                        } else {
                            echo '<td>Document Refusé</td>';
                        }
                        echo '<td>';
                        echo $this->Html->link('<i class="icon-ok"></i>', array('action' => 'validateDoc', $file['Message']['id'], $type, $eventId, $supplierId), array('escape' => false, 'class' => 'pull-right'));
                        echo '</td>';
                        echo '<td>';
                        echo $this->Html->link('<i class="icon-remove"></i>', array('action' => 'refuseDoc', $file['Message']['id'], $type, $eventId, $supplierId), array('escape' => false, 'class' => 'pull-right'));
                        echo '</td>';
                    }
                } else {
                    echo $file['Message']['date'] . '  ' . $file['Message']['orga_username'];
                    echo '<tr class="success"><td>' . $this->Html->link($path['filename'], '/' . $file['Message']['file']) . '</td>';

                    if ($type == 'organisateurs') {
                        if ($file['Message']['status'] == 1) {
                            echo '<td>Document Validé</td>';
                        } else {
                            echo '<td>Document Refusé</td>';
                        }
                        echo '<td>';
                        echo $this->Html->link('<i class="icon-trash"></i>', array('action' => 'delete', $file['Message']['id'], $type, $eventId, $supplierId), array('escape' => false, 'class' => 'pull-right'));
                        echo '</td>';
                    } else {
                        echo '<td>';
                        if ($file['Message']['status'] == 1) {
                            echo '<td>Document Validé</td>';
                        } else {
                            echo '<td>Document Refusé</td>';
                        }
                        echo '</td>';

                        echo '<td>';
                        echo $this->Html->link('<i class="icon-ok"></i>', array('action' => 'validateDoc', $file['Message']['id'], $type, $eventId), array('escape' => false, 'class' => 'pull-right'));
                        echo '</td>';

                        echo '<td>';
                        echo $this->Html->link('<i class="icon-remove"></i>', array('action' => 'refuseDoc', $file['Message']['id'], $type, $eventId), array('escape' => false, 'class' => 'pull-right'));
                        echo '</td>';
                    }
                }
                echo '</tr></table>';
            }
            echo $this->form->create('Message', array('type' => 'file', 'action' => 'addfile'));
            echo $this->Form->input('Message.eventId', array('type' => 'hidden', 'value' => $eventId));
            echo $this->Form->input('typeUser', array('type' => 'hidden', 'value' => $type));
            if (isset($supplierId)) {
                echo $this->Form->input('Message.supplierId', array('type' => 'hidden', 'value' => $supplierId));
            }
            echo $this->form->input('', array('type' => 'file'));
            echo $this->form->end('Sauvegarder le fichier');
            ?>
        </div>
    </div>
</div>

