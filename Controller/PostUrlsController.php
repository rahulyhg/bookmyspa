<?php

/*
 * PostUrls Controller class
 * Functionality -  Manage the admin login,listing,add 
 * Developer - Deepika Sharma
 * Created date - 08-Oct-2014
 * Modified date - 
 */
    App::uses('Sanitize', 'Utility');

class PostUrlsController extends AppController {

    var $name = 'Admins';
    var $components = array('Email', 'Cookie', 'Common', 'Paginator', 'Paypal', 'Braintree', 'Captcha');

    function beforeFilter() {
        parent::beforeFilter();
    }


    /*
     * admin_index function
     * Functionality -  Admins Listing
     * Developer - Navdeep
     * Created date - 11-Feb-2014
     * Modified date - 
     */

    function admin_index() {
        /* Active/Inactive/Delete functionality */
        if ((isset($this->data["PostUrl"]["setStatus"]))) {
            if (!empty($this->request->data['PostUrl']['status'])) {
                $status = $this->request->data['PostUrl']['status'];
            } else {
                $this->Session->setFlash("Please select the action.", 'default', array('class' => 'alert alert-danger'));
                $this->redirect(array('action' => 'index'));
            }
            $CheckedList = $this->request->data['checkboxes'];
            $model = 'PostUrl';
            $controller = $this->params['controller'];
            $action = $this->params['action'];
            $this->setStatus($status, $CheckedList, $model, $controller, $action);
        }
        /* Active/Inactive/Delete functionality */
        $value = "";
        $value1 = "";
        $show = "";
        $account_type = "";

        $criteria = "User.is_deleted =0  ";

        if (!empty($this->params)) {
            if (!empty($this->params->query['keyword'])) {
                $value = trim($this->params->query['keyword']);
            }
            if ($value != "") {
                $criteria .= " AND (User.first_name LIKE '%" . $value . "%' OR User.last_name LIKE '%" . $value . "%')";
            }
        }
        $this->Paginator->settings = array('conditions' => array($criteria),
            'limit' => 10,
            'fields' => array('Admin.id',
                'Admin.first_name',
                'Admin.last_name',
                'Admin.email',
                'Admin.phone',
                'Admin.status',
                'Admin.created',
            //'AdminProfile.id'
            ),
            'order' => array(
                'Admin.id' => 'DESC'
            )
        );

        $this->set('getData', $this->Paginator->paginate('Admin'));
        $this->set('keyword', $value);

        $this->set('show', $show);

        $this->set('navadmins', 'class = "active"');
        $this->set('breadcrumb', 'Admins');
    }
    
}

?>
