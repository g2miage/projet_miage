<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class SupplierratingsController extends AppController {

    public function rate() {
        if ($this->request->is('post')) {
            $userId = $this->Auth->user('id');
           
            $supplierId = $this->request->data['Supplierratings']['supplier_id'];
            $note = $this->request->data['Supplierratings']['rating'];

            $exist = $this->Supplierrating->hasAny(array('id_user' => $userId, 'id_supplier' => $supplierId));
            /*if (empty($exist)) {
                $this->Supplierrating->save(array('id_user' => $userId, 'id_supplier' => $supplierId, 'note' => $note));
            } else {
                $this->Supplierrating->updateAll(array('note' => $note), array('id_user' => $userId, 'id_supplier' => $supplierId));
            }*/
          $this->redirect(array('controller' => 'users', 'action' => 'view' , $supplierId));
   
        }
         
       }

}