<?php

class GiftImageCategoriesController extends AppController {

    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Common', 'Email', 'Cookie', 'Paginator', 'Image',); //An array containing the names of components this controller uses.

      public function beforeFilter() {
        parent::beforeFilter();
    }
    /**
     * List Advertisements
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        admin_ads     
     * @since         version 0.0.1
     */

    public function admin_list() {
        $this->layout = 'admin';
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Advertisement' => array('controller' => 'SalonAds', 'action' => 'ads', 'admin' => true),
        );
        $this->set('breadcrumb', $breadcrumb);
        $created_by = $this->Auth->user('id');
        if ($this->Auth->user('type') == 1)
            $created_by = 0;
            $ads = $this->SalonAd->find('all', array('fields' => array(
                'SalonAd.id', 'SalonAd.image',
                'SalonAd.eng_title',
                'SalonAd.ara_title',
                'SalonAd.eng_description',
                'SalonAd.ara_description',
                'SalonAd.no_of_click',
                'SalonAd.url',
                'SalonAd.eng_location',
                'SalonAd.ara_location',
                'SalonAd.is_featured',
                'SalonAd.status'
            ),
            'conditions' => array(
                'SalonAd.created_by' => $created_by, 'SalonAd.is_deleted' => 0
        )));
        $this->set(compact('ads'));
        $this->set('page_title', 'Advertisement');
        $this->set('activeTMenu', 'salonAds');
        $this->set('plan', $this->checkPlan($this->Auth->user('id')));
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/salonAds";
            $this->render('list_salon_ads');
        }
    }

}
