<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $helpers = array('Html', 'Form');
    public $components = array('Session', 'Cookie',
        'Auth' => array('authenticate' => array(
                'Form' => array(
                    'scope' => array('User.active' => 1
                    )
                )
            )
        )
    );

    public function beforeFilter() {
        $this->Auth->allow();
    }

    /**
     * uploads files to the server
     * @params:
     * 		$folder 	= the folder to upload the files e.g. 'img/files'
     * 		$formdata 	= the array containing the form files
     * 		$itemId 	= id of the item (optional) will create a new sub folder
     * @return:
     * 		will return an array with the success of each file upload
     */
    function uploadFiles($folder, $formdata, $itemId = null) {
        // setup dir names absolute and relative
        $folder_url = WWW_ROOT . $folder;
        $rel_url = $folder;

        // create the folder if it does not exist
        if (!is_dir($folder_url)) {
            mkdir($folder_url);
        }

        // if itemId is set create an item folder
        if ($itemId) {
            // set new absolute folder
            $folder_url = WWW_ROOT . $folder . '/' . $itemId;
            // set new relative folder
            $rel_url = $folder . '/' . $itemId;
            // create directory
            if (!is_dir($folder_url)) {
                mkdir($folder_url);
            }
        }

        // list of permitted file types, this is only images but documents can be added
        $permitted = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
        // loop through and deal with the files
        foreach ($formdata as $file) {
            if (is_array($file)) {
                // replace spaces with underscores
                $filename = str_replace(' ', '_', $file['name']);
                // assume filetype is false
                $typeOK = false;
                // check filetype is ok
                foreach ($permitted as $type) {
                    if ($type == $file['type']) {
                        $typeOK = true;
                        break;
                    }
                }

                // if file type ok upload the file
                if ($typeOK) {
                    // switch based on error code
                    switch ($file['error']) {
                        case 0:
                            // check filename already exists
                            if (file_exists($folder_url . '/' . $filename)) {
                                $fileTmp = new File($folder_url . '/' . $filename, false, 0777);
                                $fileTmp->delete();
                            }
                            // create full filename
                            $full_url = $folder_url . '/' . $filename;
                            $url = $rel_url . '/' . $filename;
                            // upload the file
                            $success = move_uploaded_file($file['tmp_name'], $url);

                            // if upload was successful
                            if ($success) {
                                // save the url of the file
                                $result['urls'][] = $url;
                            } else {
                                $result['errors'][] = "Error uploaded $filename. Please try again.";
                            }
                            break;
                        case 3:
                            // an error occured
                            $result['errors'][] = "Error uploading $filename. Please try again.";
                            break;
                        default:
                            // an error occured
                            $result['errors'][] = "System error uploading $filename. Contact webmaster.";
                            break;
                    }
                } elseif ($file['error'] == 4) {
                    // no file was selected for upload
                    $result['nofiles'][] = "No file Selected";
                } else {
                    // unacceptable file type
                    $result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";
                }
            }
        }
        return $result;
    }

    function uploadCsv($folder, $formdata, $itemId = null, $filename) {
        // setup dir names absolute and relative
        $folder_url = WWW_ROOT . $folder;
        $rel_url = $folder;

        // create the folder if it does not exist
        if (!is_dir($folder_url)) {
            mkdir($folder_url);
        }

        // if itemId is set create an item folder
        if ($itemId) {
            // set new absolute folder
            $folder_url = WWW_ROOT . $folder . '/' . $itemId;
            // set new relative folder
            $rel_url = $folder . '/' . $itemId;
            // create directory
            if (!is_dir($folder_url)) {
                mkdir($folder_url);
            }
        }

        // list of permitted file types, this is only images but documents can be added
        // permitted csv
        $permitted = array('application/octet-stream', 'application/vnd.ms-excel', 'text/csv');

        // loop through and deal with the files
        foreach ($formdata as $file) {
            // replace spaces with underscores
            $filename = str_replace(' ', '_', $filename . '.csv');
            // assume filetype is false

            $typeOK = false;
            // check filetype is ok
            foreach ($permitted as $type) {
                if ($type == $file['type']) {
                    $typeOK = true;
                    break;
                }
            }

            // if file type ok upload the file
            if ($typeOK) {
                // switch based on error code
                switch ($file['error']) {
                    case 0:
                        // check filename already exists
                        if (file_exists($folder_url . '/' . $filename)) {
                            $fileTmp = new File($folder_url . '/' . $filename, false, 0777);
                            $fileTmp->delete();
                        }
                        // create full filename
                        $full_url = $folder_url . '/' . $filename;
                        $url = $rel_url . '/' . $filename;
                        // upload the file
                        $success = move_uploaded_file($file['tmp_name'], $url);

                        // if upload was successful
                        if ($success) {
                            // save the url of the file
                            $result['urls'][] = $url;
                        } else {
                            $result['errors'][] = "Error uploaded $filename. Please try again.";
                        }
                        break;
                    case 3:
                        // an error occured
                        $result['errors'][] = "Error uploading $filename. Please try again.";
                        break;
                    default:
                        // an error occured
                        $result['errors'][] = "System error uploading $filename. Contact webmaster.";
                        break;
                }
            } elseif ($file['error'] == 4) {
                // no file was selected for upload
                $result['nofiles'][] = "No file Selected";
            } else {
                // unacceptable file type
                $result['errors'][] = "$filename cannot be uploaded. Acceptable file types: csv.";
            }
        }
        if (isset($result)) {
            return $result;
        }
    }

    function uploadFile($folder, $formdata, $itemId = null) {
        // setup dir names absolute and relative
        $folder_url = WWW_ROOT . $folder;
        $rel_url = $folder;

        // create the folder if it does not exist
        if (!is_dir($folder_url)) {
            mkdir($folder_url);
        }

        // if itemId is set create an item folder
        if ($itemId) {
            // set new absolute folder
            $folder_url = WWW_ROOT . $folder . '/' . $itemId;
            // set new relative folder
            $rel_url = $folder . '/' . $itemId;
            // create directory
            if (!is_dir($folder_url)) {
                mkdir($folder_url);
            }
        }

        // loop through and deal with the files
        foreach ($formdata as $file) {

            if (is_array($file)) {
                // replace spaces with underscores
                $filename = str_replace(' ', '_', $file['name']);

                // switch based on error code
                switch ($file['error']) {
                    case 0:
                        // check filename already exists
                        if (file_exists($folder_url . '/' . $filename)) {
                            $path_parts = pathinfo($filename);
                            $extension = $path_parts['extension'];
                            $filename = $path_parts['filename'] . date('YmdHis') . '.' . $extension;
                        }
                        // create full filename
                        $full_url = $folder_url . '/' . $filename;
                        $url = $rel_url . '/' . $filename;
                        // upload the file
                        $success = move_uploaded_file($file['tmp_name'], $url);

                        // if upload was successful
                        if ($success) {
                            // save the url of the file
                            $result['urls'][] = $url;
                        } else {
                            $result['errors'][] = "Error uploaded $filename. Please try again.";
                        }
                        break;
                    case 3:
                        // an error occured
                        $result['errors'][] = "Error uploading $filename. Please try again.";
                        break;
                    default:
                        // an error occured
                        $result['errors'][] = "System error uploading $filename. Contact webmaster.";
                        break;
                }
            }
        }
        if (isset($result)) {
            return $result;
        }
    }
    
    
    // fonction qui check le nombre de messages non lus de l'utilisateur
    public function checkNbMsg(){
        $this->loadModel('MessagesUsers');
        $messages = $this->MessagesUsers->find('all', array(
            'conditions' => array(
                'MessagesUsers.user_id' => $this->Auth->user('id'),
                'MessagesUsers.status' => 0,
            )
        ));
        return $nbmsg = count($messages);
    } 

}
