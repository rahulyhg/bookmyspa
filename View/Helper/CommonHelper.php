<?php

App::uses('Helper', 'View');
App::uses('CommonComponent', 'Controller/Component');
class CommonHelper extends Helper {

    var $components = array('RequestHandler', 'Session', 'Acl', 'Auth', 'Cookie','Common');
    var $helpers = array('Form', 'Html', 'Session', 'Js');

    /**********************************************************************************    
      @Function Name : getThemeId
      @Params	 : $auth_user => Logged In User Details
      @Description   : return Admin theme chose by Any Vendor/Admin
      @Author        : Aman Gupta
      @Date          : 11-Nov-2014
     * ********************************************************************************* */

    function getThemeId($auth_user){
        App::import("Model", "ChosenTheme");
        $model = new ChosenTheme();
        $chosen_by = $auth_user['User']['id'];
        if ($auth_user['User']['type'] == 1) {
            $chosen_by = 0;
        }
        $themeId = $model->find("first", array('conditions' => array('ChosenTheme.user_id' => $chosen_by), 'fields' => array('ChosenTheme.theme')));
        if (empty($themeId)) {
            return 'magenta';
        } else {
            return $themeId['ChosenTheme']['theme'];
        }
    }

    /*     * ********************************************************************************    
      @Function Name : theStatusImage
      @Params	 : $status => true/false
      @Description   : Return image for particular staus
      @Author        : Aman Gupta
      @Date          : 11-Nov-2014
     * ********************************************************************************* */

    function theStatusImage($status , $class="changeStatus"){
        if ($status) {
            return $this->Html->link('<i class="icon-ok-sign"></i>', 'javascript:void(0);', array('data-status' => 0, 'title' => 'Click to De-activate.', 'class' => $class, 'escape' => false));
        } else {
            return $this->Html->link('<i class="icon-remove-sign"></i>', 'javascript:void(0);', array('data-status' => 1, 'title' => 'Click to Activate.', 'class' => $class, 'escape' => false));
        }
    }

    
    
    function convertToHoursMins($time, $format = '%d:%d') {
        settype($time, 'integer');
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        if($time < 60){
            return sprintf($format, $minutes);
        }else{
            return sprintf($format, $hours, $minutes);    
        }
        
    }
    /*     * ********************************************************************************    
      @Function Name : get_list
      @Params	 : $type
      @Description   : Return list for particular type
      @Author        : Sanjeev
      @Date          : 13-Nov-2014
     * ********************************************************************************* */

    function get_list($type) {
        $fields = array($type);
        App::import("Model", "BlogCategory");
        $model = new BlogCategory();
        $data = $model->find('list', array('conditions' => array('BlogCategory.status' => 1, 'BlogCategory.is_deleted' => 0), 'fields' => array($type), 'order' => array('BlogCategory.eng_name ASC')));
        return $data;
    }

    /**********************************************************************************    
      @Function Name : get_categoryName
      @Params	 : id's
      @Description   : Return categories name!!
      @Author        : Sanjeev
      @Date          : 13-Nov-2014
    ***********************************************************************************/

    function get_categoryName($cat_id = NUll) {
        $fields = array('eng_name', 'ara_name');
        App::import("Model", "BlogCategory");
        $model = new BlogCategory();
        $model->recursive = -1;
        $ret_cat_name = array();
        $cat_names = $model->find('all', array('conditions' => array('BlogCategory.id' => $cat_id, 'BlogCategory.is_deleted' => 0), 'fields' => $fields));

        foreach ($cat_names as $cat_name) {
            $ret_cat_name[] = $cat_name['BlogCategory']['eng_name'];
        }
        return implode(" , ", $ret_cat_name);
    }

    /*     * ********************************************************************************    
      @Function Name : getTimeDifference
      @Params	 : datetime
      @Description   : Return time/days
      @Author        : Sanjeev
      @Date          : 18-Nov-2014
     * ********************************************************************************* */

    public function getTimeDifference($time){
        //Let's set the current time
        $currentTime = date('Y-m-d H:i:s');
        $toTime = strtotime($currentTime);
        //And the time the notification was set
        $fromTime = strtotime($time);
        //Now calc the difference between the two
        $timeDiff = floor(abs($toTime - $fromTime) / 60);
        //Now we need find out whether or not the time difference needs to be in
        //minutes, hours, or days
        if ($timeDiff < 2) {
            $timeDiff = "Just now";
        } elseif ($timeDiff > 2 && $timeDiff < 60) {
            $timeDiff = floor(abs($timeDiff)) . " minutes ago";
        } elseif ($timeDiff > 60 && $timeDiff < 120) {
            $timeDiff = floor(abs($timeDiff / 60)) . " hour ago";
        } elseif ($timeDiff < 1440) {
            $timeDiff = floor(abs($timeDiff / 60)) . " hours ago";
        } elseif ($timeDiff > 1440 && $timeDiff < 2880) {
            $timeDiff = floor(abs($timeDiff / 1440)) . " day ago";
        } elseif ($timeDiff > 2880) {
            $timeDiff = floor(abs($timeDiff / 1440)) . " days ago";
        }

        return $timeDiff;
    }
    
     function getpackageDuration($packageId = null){
        $packageOptions = array('duration'=>'','price'=>'','maxduration'=>'','maxprice'=>''); 
        if($packageId){
            App::import('Model', 'PackagePricingOption');
            $this->PackagePricingOption = new PackagePricingOption();
            $packagePricings = $this->PackagePricingOption->find('all',array('conditions'=>array('PackagePricingOption.package_id'=>$packageId),'group'=>'option_id'));
            if(!empty($packagePricings)){
                $packageoptionCount = count($packagePricings);
                if($packageoptionCount == 1){
                    $packageOptions['duration']= $packagePricings[0]['PackagePricingOption']['option_duration'];
                    $packageOptions['price'] = $packagePricings[0]['PackagePricingOption']['option_price'];
                }else{
                    foreach($packagePricings as $packagepricing){
                       $packageOptions['duration'][] =  $packagepricing['PackagePricingOption']['option_duration'];
                       $packageOptions['price'][] =  $packagepricing['PackagePricingOption']['option_price'];
                    }
                    $packageOptions['maxprice'] = max($packageOptions['price']);
                    $packageOptions['maxduration'] = max($packageOptions['duration']);
                    $packageOptions['price'] = min($packageOptions['price']);
                    $packageOptions['duration'] = min($packageOptions['duration']);
                }
            }
           
        }
        return $packageOptions;
        
    }

    function getLowestSalonPackage($user_id = null){
        $packageOptions = array('lowestprice'=>'','packagecount'=>''); 
        if($user_id){
            App::import('Model', 'PackagePricingOption');
            App::import('Model', 'Package');
            $this->Package = new Package();
            $salonPackages = $this->Package->find('list',array('conditions'=>array('Package.user_id'=>$user_id,'Package.status'=>1,'Package.is_deleted'=>0,'Package.type'=>'Package')));
            $packageOptions['packagecount'] = count($salonPackages);
            if(!empty($salonPackages)){
                foreach($salonPackages as $package){
                    $this->PackagePricingOption = new PackagePricingOption();
                    $packagePricings = $this->PackagePricingOption->find('all',array('conditions'=>array('PackagePricingOption.package_id'=>$package),'group'=>'option_id'));
                    if(!empty($packagePricings)){
                        $packageoptionCount = count($packagePricings);
                            foreach($packagePricings as $packagepricing){
                           
                               $packageOptions['lowestprice'][] =  $packagepricing['PackagePricingOption']['option_price'];
                            }
                            
                    }
                }
                $packageOptions['lowestprice'] = min($packageOptions['lowestprice']);
            }
        }
       return $packageOptions;
    }
    
    function getLowestSalonSpadays($user_id = null){
        $packageOptions = array('lowestprice'=>'','packagecount'=>''); 
        if($user_id){
            App::import('Model', 'PackagePricingOption');
            App::import('Model', 'Package');
            $this->Package = new Package();
            $salonPackages = $this->Package->find('list',array('conditions'=>array('Package.user_id'=>$user_id,'Package.status'=>1,'Package.is_deleted'=>0,'Package.type'=>'Spaday')));
            $packageOptions['packagecount'] = count($salonPackages);
            if(!empty($salonPackages)){
                foreach($salonPackages as $package){
                    $this->PackagePricingOption = new PackagePricingOption();
                    $packagePricings = $this->PackagePricingOption->find('all',array('conditions'=>array('PackagePricingOption.package_id'=>$package),'group'=>'option_id'));
                    if(!empty($packagePricings)){
                        $packageoptionCount = count($packagePricings);
                            foreach($packagePricings as $packagepricing){
                           
                               $packageOptions['lowestprice'][] =  $packagepricing['PackagePricingOption']['option_price'];
                            }
                            
                    }
                }
                $packageOptions['lowestprice'] = min($packageOptions['lowestprice']);
            }
        }
        //pr($packageOptions);
       return $packageOptions;
    }
    
    /*     * ********************************************************************************    
      @Function Name : changeStatusImage
      @Params	 : $status => true/false
      @Description   : Return image for particular staus
      @Author        : Shibu Kumar
      @Date          : 19-Nov-2014
     * ********************************************************************************* */

    function changeStatusImage($status, $id) {
        if ($status) {
            return $this->Html->link($this->Html->image('admin/icons2/hand_thumbsup.png', array('alt' => 'Active', 'class' => 'utopia-icons2-small-img')), 'javascript:void(0);', array('data-status' => 0, 'title' => 'De-Activate', 'id' => $id, 'escape' => false));
        } else {
            return $this->Html->link($this->Html->image('admin/icons2/hand_thumbsdown.png', array('alt' => 'InActive', 'class' => 'utopia-icons2-small-img')), 'javascript:void(0);', array('data-status' => 1, 'title' => 'Activate', 'id' => $id, 'escape' => false));
        }
    }

    /***************************************************************************************    
      @Function Name : getYoutubeThumb
      @Params	 :$url
      @Description   : Return youtube video thumb.
      @Author        : Sanjeev
      @Date          : 25-Nov-2014
     * ********************************************************************************* */

    function getYoutubeThumb($url){
        $host = @parse_url($url);
        if (@$host['host'] == "www.youtube.com" or @$host['host'] == "youtube.com"){
            parse_str(@$host['query']);
            if (!empty($v)) {
                return "http://img.youtube.com/vi/$v/3.jpg";
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**************************************************************************************    
      @Function Name : getDateFormat
      @Params	 :$date
      @Description   : Return date
      @Author        : Sanjeev
      @Date          : 27-Nov-2014
     ***********************************************************************************/

    function getDateFormat($date){
        if ($date) {
            $date = date_create($date);
            return date_format($date, "d/m/Y");
        } else {
            return false;
        }
    }

    /*
     * @author        Shibu Kumar
     * @method        getStatesbyCid 
     * @param         Function to get List of States by Country ID
     * @return        void 
     * 
     */

    public function getStatesbyCid($id = null) {
        App::import('Model', 'State');
        $this->State = new State();
        $stateData = $this->State->find('list', array('fields' => array('State.id', 'State.name'), 'conditions' => array('State.status' => 1, 'State.country_id' => $id)));
        return $stateData;
    }

    /*
     * @author        Aman Gupta
     * @method        getState 
     * @param         Function to get States by state ID
     * @return        void 
     * 
     */
    public function getState($id = null) {
        App::import('Model', 'State');
        $this->State = new State();
        $this->State->unbindModel(array('hasMany'=>array('City')));
        $stateData = $this->State->find('first', array('fields' => array('State.id', 'State.name'), 'conditions' => array('State.status' => 1, 'State.id' => $id,'Country.status'=>1)));
        if(isset($stateData['State']['name']) && !empty($stateData['State']['name'])){
            return $stateData['State']['name'];
        }
        return 0;
    }
    
    /*
     * @author        Aman Gupta
     * @method        getState 
     * @param         Function to get States by state ID
     * @return        void 
     * 
     */
    public function getCity($id = null) {
        App::import('Model', 'City');
        $this->City = new City();
        //$this->City->unbindModel(array('hasMany'=>array('City')));
        $cityData = $this->City->find('first', array('fields' => array('City.id', 'City.city_name'), 'conditions' => array('City.status' => 1, 'City.id' => $id,'Country.status'=>1)));
        if(isset($cityData['City']['city_name']) && !empty($cityData['City']['city_name'])){
            return $cityData['City']['city_name'];
        }
        return false ;
    }
    
    /*
     * @author        Shibu Kumar
     * @method        getCitiesbySid 
     * @param         Function to get List of Cities by State ID
     * @return        void 
     * 
     */

    public function getCitiesbySid($id = null) {
        App::import('Model', 'City');
        $this->City = new City();
        $cityData = $this->City->find('list', array('fields' => array('City.id', 'City.city_name'), 'conditions' => array('City.status' => 1, 'City.state_id' => $id)));
        return $cityData;
    }

    /*     * ********************************************************************************    
      @Function Name : kidsfrnd
      @Params	 : NULL
      @Description   : Return kids friendly array
      @Author        : Aman Gupta
      @Date          : 03-Dec-2014
     * ********************************************************************************* */

    public function kidsfrnd() {
        $frndArr = array('1' => __('yes',true), '2' => __('kids_only',true), '3' => __('no_kids',true));
        return $frndArr;
    }

    /*     * ********************************************************************************    
      @Function Name : paymentTypes
      @Params	 : NULL
      @Description   : Return all type of payment Methods
      @Author        : Aman Gupta
      @Date          : 03-Dec-2014
     * ********************************************************************************* */

    public function paymentTypes() {
        $paymentArr = array('1' => __('visa_n_master',true), '2' => __('discover',true), '3' => __('american_express',true), '4' => __('debit',true), '5' => __('other_credit_cards',true), '6' => __('cash',true), '7' => __('Cheque',true) );
        return $paymentArr;
    }

    /*     * ********************************************************************************    
      @Function Name : parkingFee
      @Params	 : NULL
      @Description   : Return all type of parking Type
      @Author        : Aman Gupta
      @Date          : 03-Dec-2014
     * ********************************************************************************* */

    public function parkingFee() {
        $paymentArr = array('1' => __('free_parking',true), '2' => __('metered_parking',true));
        return $paymentArr;
    }

    /*     * ********************************************************************************    
      @Function Name : spokenLang
      @Params	 : NULL
      @Description   : Return all spoken Lang for Facility Profile
      @Author        : Aman Gupta
      @Date          : 03-Dec-2014
     * ********************************************************************************* */

    public function spokenLang() {
        $langArr = array('1' => __('english',true), '2' => __('arabic',true), '3' => __('spanish',true), '4' => __('chinese',true), '5' => __('hindi',true));
        return $langArr;
    }

      public function limitCustomer() {
        $langArr = array('0' => __('No limit',true),'1' => __('1',true), '2' => __('2',true), '3' => __('3',true), '4' => __('4',true), '5' => __('5',true), '6' => __('6',true), '7' => __('7',true), '8' => __('8',true), '9' => __('9',true), '10' => __('10',true), '11' => __('11',true), '12' => __('12',true), '13' => __('13',true), '14' => __('14',true), '15' => __('15',true));
        return $langArr;
    }
    /********************************************************************************    
      @Function Name : businessModal
      @Params	 : NULL
      @Description   : Return all business Modal for
      @Author        : Aman Gupta
      @Date          : 04-Dec-2014
    ***********************************************************************************/

    public function businessModal() {
        $BusinessModal = array('4' => 'Individual','2' => 'Franchise', '-1' => 'Business Under Franchise'/*,'3' => 'Corporate', '-2' => 'Business Under Corporate'*/);
        return $BusinessModal;
    }

    public function serviceprovidedTo() {
        $serviceTo = array('K'=>'Kid\'s Only', 'M' => 'Men Only','P'=>'Pet\'s','B' => 'Unisex', 'W' => 'Women Only',);
     
        return $serviceTo;
    }

    /*     * ********************************************************************************    
      @Function Name : printAddress
      @Params	 : $userId
      @Description   : Return User Address
      @Author        : Aman Gupta
      @Date          : 04-Dec-2014
     * ********************************************************************************* */

    public function printAddress($userId = NULL){
        App::import('Model', 'Address');
        $this->Address = new Address();
        $address = $this->Address->find('first', array('conditions' => array('Address.user_id' => $userId)));

        $addData = '';
        if (!empty($address)) {
            if (isset($address['Address']['address']) && !empty($address['Address']['address'])) {
                $addData = $address['Address']['address'] . ", <br>";
                $addData .= ($address['Address']['po_box']) ? $address['Address']['po_box'] . ', <br>' : '';
                $addData .= ($address['City']['city_name']) ? $address['City']['city_name'] . ', <br>' : '';
                $addData .= ($address['State']['name']) ? $address['State']['name'] . ', <br>' : '';
                $addData .= ($address['Country']['name']) ? $address['Country']['name'] . '' : '';
            }
        }
        return $addData;
    }

    public function countAlbumFiles($id, $type) {
        App::import('Model', 'AlbumFile');
        $this->AlbumFile = new AlbumFile();
        $total_images = $this->AlbumFile->find('count', array('conditions' => array('AlbumFile.album_id' => $id, 'type' => $type)));
        return $total_images;
    }

    public function get_image($imageName = NULL, $user_id, $modal) {
        if ($imageName != '') {
            if (filter_var($imageName, FILTER_VALIDATE_URL)) {
                return $imageName;
            } else {
                //return "/images/$user_id/$modal/350/" . $imageName;
                if($modal == 'User'){
                    if (file_exists(WWW_ROOT ."/images/$user_id/$modal/400/".$imageName)) {
                    return "/images/$user_id/$modal/400/" . $imageName;
                    }else{
                        return '/img/admin/treat-pic.png';
                    }

                }else{
                    return "/images/$user_id/$modal/resized/" . $imageName;
                }
            }
        } else {
            return '/img/admin/treat-pic.png';
        }
    }
    public function get_image_stylist($imageName = NULL, $user_id, $modal, $size=150) {
        if ($imageName != '') {
            if (filter_var($imageName, FILTER_VALIDATE_URL)) {
                return $imageName;
            } else {
                if($modal == 'User'){
                   if (file_exists(WWW_ROOT ."/images/$user_id/$modal/$size/" . $imageName)) {
                         return "/images/$user_id/$modal/$size/" . $imageName;
                    }else if(file_exists(WWW_ROOT ."/images/$user_id/$modal/resized/" . $imageName)){
                        return "/images/$user_id/$modal/resized/" . $imageName;
                    }else{
                        return '/img/admin/treat-pic.png';
                    }

                }else{
                    return "/images/$user_id/$modal/resized/" . $imageName;
                }
            }
        } else {
            return '/img/admin/treat-pic.png';
        }
    }
    
     public function get_image_staff($imageName = NULL, $user_id, $modal,$w=200) {
        if ($imageName != '') {
            if (filter_var($imageName, FILTER_VALIDATE_URL)) {
                return $imageName;
            } else {
                if (file_exists(WWW_ROOT ."/images/$user_id/$modal/$w/".$imageName)) {
                    return "/images/$user_id/$modal/$w/" . $imageName;

                }else{
                    return '/img/admin/treat-pic.png';
                }
            }
        } else {
            return '/img/admin/treat-pic.png';
        }
    }
    /*     * ********************************************************************************    
      @Function Name : get_security_question
      @Params	 : $type
      @Description   : Return list of security questions.
      @Author        : Sanjeev
      @Date          : 5jan-2015
     * ********************************************************************************* */

    function get_security_question(){
        //$fields = array($type);
        App::import("Model", "SecurityQuestion");
        $model = new SecurityQuestion();
        $data = $model->find('list', array('fields' => array('id', 'question')));
        return $data;
    }

    /*     * ********************************************************************************    
      @Function Name : get_employee_type
      @Params	 : $type
      @Description   : Return list of employee types.
      @Author        : Sanjeev
      @Date          : 6jan-2015
     * ********************************************************************************* */
    function get_employee_type() {
           $employee_type_array = array('1' => 'Account Admin', '2' => 'Service Provider');
           return $employee_type_array;
       }
    
    public function getPhoneCode($id=null){
		if($id){
			App::import("Model", "Country");
                        $this->Country = new Country();
			$phCode = $this->Country->find('first',array('fields'=>array('Country.phone_code'),'conditions'=>array('Country.id'=>$id)));
			return $phCode['Country']['phone_code'];
		}
		return;
    }
    
    /**********************************************************************************    
      @Function Name : get_employee_access_level
      @Params	 : $type
      @Description   : Return list of employee types.
      @Author        : Sanjeev
      @Date          : 6jan-2015
     * ********************************************************************************* */

    function get_employee_access_level(){
        App::import("Model", "Group");
        $model = new Group();
        $data = $model->find('list', array('fields' => array('id', 'name'), 'conditions' => array('Group.created_by' => array($this->Session->read('Auth.User.id'),'1'), 'status' => '1')));
        return $data;
    }
    
    function get_duration(){
        $duration_array = array('0'=>__('not_set',true),'10'=>__('10mins',true),'15'=>__('15mins',true),'20'=>__('20mins',true),'25'=>__('25mins',true),'30'=>__('30mins',true),'35'=>__('35mins',true),'40'=>__('40mins',true),'45'=>__('45mins',true),'50'=>__('50mins',true),'55'=>__('55mins',true),'60'=>__('1hr',true),'65'=>__('1hr05mins',true),'70'=>__('1hr10mins',true),'75'=>__('1hr15mins',true),'80'=>__('1hr20mins',true),'85'=>__('1hr25mins',true),'90'=>__('1hr30mins',true),'95'=>__('1hr35mins',true),'100'=>__('1hr40mins',true),'105'=>__('1hr45mins',true),'110'=>__('1hr50mins',true),'115'=>__('1hr55mins',true),'120'=>__('2hr',true),'135'=>__('2hr15mins',true),'150'=>__('2hr30mins',true),'165'=>__('2hr45mins',true),'180'=>__('3hr',true),'195'=>__('3hr15mins',true),'210'=>__('3hr30mins',true),'225'=>__('3hr45mins',true),'240'=>__('4hr',true),'270'=>__('4hr30mins',true),'300'=>__('5hr',true),'330'=>__('5hr30mins',true),'360'=>__('6hr',true),'390'=>__('6hr30mins',true),'420'=>__('7hr',true),'450'=>__('7hr30mins',true),'480'=>__('8hr',true),'540'=>__('9hr',true),'600'=>__('10hr',true),'660'=>__('11hr',true),'720'=>__('12hr',true));
        return $duration_array;
    }
     function get_validduration(){
        $duration_array = array('10'=>__('10mins',true),'15'=>__('15mins',true),'20'=>__('20mins',true),'25'=>__('25mins',true),'30'=>__('30mins',true),'35'=>__('35mins',true),'40'=>__('40mins',true),'45'=>__('45mins',true),'50'=>__('50mins',true),'55'=>__('55mins',true),'60'=>__('1hr',true),'65'=>__('1hr05mins',true),'70'=>__('1hr10mins',true),'75'=>__('1hr15mins',true),'80'=>__('1hr20mins',true),'85'=>__('1hr25mins',true),'90'=>__('1hr30mins',true),'95'=>__('1hr35mins',true),'100'=>__('1hr40mins',true),'105'=>__('1hr45mins',true),'110'=>__('1hr50mins',true),'115'=>__('1hr55mins',true),'120'=>__('2hr',true),'135'=>__('2hr15mins',true),'150'=>__('2hr30mins',true),'165'=>__('2hr45mins',true),'180'=>__('3hr',true),'195'=>__('3hr15mins',true),'210'=>__('3hr30mins',true),'225'=>__('3hr45mins',true),'240'=>__('4hr',true),'270'=>__('4hr30mins',true),'300'=>__('5hr',true),'330'=>__('5hr30mins',true),'360'=>__('6hr',true),'390'=>__('6hr30mins',true),'420'=>__('7hr',true),'450'=>__('7hr30mins',true),'480'=>__('8hr',true),'540'=>__('9hr',true),'600'=>__('10hr',true),'660'=>__('11hr',true),'720'=>__('12hr',true));
        return $duration_array;
    }
    
    function search_interval(){
        $search_interval_array = array('15'=>'15','20'=>'20','30'=>'30','45'=>'45','60'=>'60','75'=>'75','90'=>'90','120'=>'120');
        return $search_interval_array;
    }
    
     function search_limit(){
        $search_limit_array = array();
        for($i=1;$i<=60;$i++){
            $search_limit_array[] = $i;
        }
        return $search_limit_array;
    }
    
    function get_days(){
        $days_array = array();
        for($i=1;$i<=30;$i++){
            if($i==1){
                $days_array[] = $i.' day';
            }else{
                $days_array[] = $i.' days';    
            }
            
        }
        return $days_array;
    }
    function getDealQty(){
        $dealqtyarray = array('0'=>'Unlimited','1'=>'Limited');
        return $dealqtyarray;
        
    }
    
    function getDealDuration(){
        $dealdurationarray = array('1'=>'1 day','2'=>'2 days','3'=>'3 days','4'=>'4 days','5'=>'5 days','7'=>'1 week','10'=>'10 days','14'=>'2 weeks');
        return $dealdurationarray;
        
    }
    function get_listedonline_options(){
        $listedonline_array = array('0'=>'Always','1'=>'From','3'=>'Range','2'=>'Untill');
        return $listedonline_array;
    }
     
    function get_offerdays_options(){
        $offerdays_array = array('0'=>'all venue opening days','1'=>'on these week days');
        return $offerdays_array;
    }
    function get_soldas_options(){
        $soldas_array = array('0'=>'Appointment or eVoucher','1'=>'Appointment','2'=>'eVoucher');
        return $soldas_array;
    }
    function get_evoucherexpire_options(){
        $evoucherexpire_array = array('0'=>'according to venue policy','1'=>'after');
        return $evoucherexpire_array;
    }
    function get_leadtime_options(){
        $leadtime_array = array('0'=>'No closeouts','1'=>'1 hour','2'=>'2 hours','3'=>'3 hours','4'=>'4 hours','5'=>'5 hours','6'=>'6 hours','7'=>'7 hours','8'=>'8 hours','24'=>'1 day','48'=>'2 days','72'=>'3 days','96'=> '4 days','120'=>'5 days','144'=>'6 days','168'=>'7 days');
        return $leadtime_array;
    }
    
    function get_leadtime_appointment(){
        $leadtime_array = array('0.5'=>'0.5 hour','1'=>'1 hour','2'=>'2 hours','3'=>'3 hours','4'=>'4 hours','5'=>'5 hours','6'=>'6 hours','7'=>'7 hours','8'=>'8 hours','9'=>'9 hours','10'=>'10 hours','11'=>'11 hours','12'=>'12 hours','13'=>'13 hours','14'=>'14 hours','15'=>'15 hours','16'=>'16 hours','17'=>'17 hours','18'=>'18 hours','19'=>'19 hours','20'=>'20 hours','21'=>'21 hours','22'=>'22 hours','23'=>'23 hours','24'=>'24 hours');
        return $leadtime_array;
    }
    
    function get_expireafter_options(){
        
        $evoucherexpireafter_array = array('1'=>'1 month','2'=>'2 months','3'=>'3 months','4'=>'4 months','5'=>'5 months','6'=>'6 months');
        return $evoucherexpireafter_array;
    }
    
    /*     * ********************************************************************************    
      @Function Name : RecursiveServices
      @Params	 : $type
      @Description   : Return list of employee types.
      @Author        : Sanjeev
      @Date          : 6jan-2015
     * ********************************************************************************* */

    function ServicesPrice($id = NULL, $uid = NULL){
        App::import("Model", "ServiceDetail");
        $model = new ServiceDetail();
        $data = $model->find('first', array('conditions' => array('user_id' => $uid, 'service_id' => $id)));
        if (!count($data)) {
            $data = $model->find('first', array('conditions'=>array('user_id' =>0, 'service_id'=>$id)));
        }
        return $data;
    }
    
    function tax_options($uid = NULL){
        App::import("Model", "TaxCheckout");
        $model = new TaxCheckout();
        $conditions = array(
            'user_id' => $uid
        );
        if ($model->hasAny($conditions)){
             $data = $model->find('first', array('conditions' =>$conditions));
        }else{
             $data = $model->find('first', array('conditions' =>array('user_id'=>1)));
        }
      
        $datae['tax1']= "Tax1(".$data['TaxCheckout']['tax1'].")";
        $datae['tax2'] ="Tax2(".$data['TaxCheckout']['tax2'].")";
        return $datae;
    }
    function deduction_options($uid = NULL){
        App::import("Model", "TaxCheckout");
        $model = new TaxCheckout();
         $conditions = array(
            'user_id' => $uid
        );
        if ($model->hasAny($conditions)){
             $data = $model->find('first', array('conditions' =>$conditions));
        }else{
             $data = $model->find('first', array('conditions' =>array('user_id'=>1)));
        }
        $datae['deduction1'] = "Deduction1(".$data['TaxCheckout']['deduction1'].")";
        $datae['deduction2'] = "Deduction2(".$data['TaxCheckout']['deduction2'].")";;
        return $datae;
    }
  
     /*****************************************************************************************    
      @Function Name : RecursiveServices
      @Params	 : $type
      @Description   : Return list of employee types.
      @Author        : Sanjeev
      @Date          : 6jan-2015
     ********************************************************************************** */

    function get_price_level($id = NULL){
        App::import("Model", "PricingLevel");
        $model = new PricingLevel();
        $data1 = $model->find('list', array('fields' => array('id', 'eng_name'), 'conditions' => array('user_id' =>1, 'status' => '1','is_deleted'=>0)));
        
        $data = $model->find('list', array('fields' => array('id', 'eng_name'), 'conditions' => array('user_id' =>$this->Session->read('Auth.User.id'), 'status' => '1','is_deleted'=>0)));
       
        return @($data + $data1);
    }
    
    function get_price_level_name($id = NULL){
            $lang = Configure::read('Config.language'); 
            $data = array();
            App::import("Model", "PricingLevelAssigntoStaff");
            $model = new PricingLevelAssigntoStaff();
            $priceLevel = $model->find('first',array('conditions'=>array('user_id'=>$id)));
            if(isset($priceLevel['PricingLevelAssigntoStaff']['pricing_level_id']) && $priceLevel['PricingLevelAssigntoStaff']['pricing_level_id']!=0){
                App::import("Model", "PricingLevel");
                $model = new PricingLevel();   
                $model->recursive = -1;
                $data = $model->find('first', array('fields' => array('id', 'eng_name','ara_name'), 'conditions' => array('PricingLevel.id' =>$priceLevel['PricingLevelAssigntoStaff']['pricing_level_id'], 'status' => '1','is_deleted'=>0)));
                }
                if(count($data)){
                 return $data['PricingLevel'][$lang.'_name'];   
                }else{
                 return '';   
                }
           
    }
    
    function get_price_level_id($id = NULL){
            $lang = Configure::read('Config.language'); 
            $data = array();
            App::import("Model", "PricingLevelAssigntoStaff");
            $model = new PricingLevelAssigntoStaff();
            $priceLevel = $model->find('first',array('conditions'=>array('user_id'=>$id)));
            if(isset($priceLevel['PricingLevelAssigntoStaff']['pricing_level_id']) && $priceLevel['PricingLevelAssigntoStaff']['pricing_level_id']!=0){
                App::import("Model", "PricingLevel");
                $model = new PricingLevel();   
                $model->recursive = -1;
                $data = $model->find('first', array('fields' => array('id', 'eng_name','ara_name'), 'conditions' => array('PricingLevel.id' =>$priceLevel['PricingLevelAssigntoStaff']['pricing_level_id'], 'status' => '1','is_deleted'=>0)));
                }
                if(count($data)){
                 return $data['PricingLevel']['id'];   
                }else{
                 return '';   
                }
    }
    
    
    // function to get Pricing Level name By passing Pricing Level Id as Parameter
    function get_pricing_option_name($id = null){
        App::import("Model", "PricingLevel");
        $model = new PricingLevel();
        if($id != 0){
        $data = $model->find('first', array('fields' => array('eng_name'),'conditions'=>array('PricingLevel.id'=>$id)));
        return $data['PricingLevel']['eng_name'];
        
        }else{
            return 'Same for all staff';
        }
    }
    
    function getStaffService($id = NULL){
       App::import("Model", "SalonStaffService");
       $model = new SalonStaffService();
       $data = $model->find('list', array('fields' => array('salon_service_id'),'conditions' => array('staff_id' =>$id,'status'=>1)));
       return $data;
    }
    
    function homeserviceName($id = NULL , $return_array=NULL){
	App::import("Model", "Service");
	$model = new Service();
	$model->unbindModel(array('hasMany'=>array('ServiceImage')));
	$data = $model->find('first', array('fields' => array('eng_name','ara_name'),'conditions' => array('id' =>$id)));
        if($return_array){
            return $data;   
        }
        $lang = Configure::read('Config.language'); 
	if($lang != 'eng'){
	    if(!empty($data['Service']['ara_name'])){
               return $data['Service']['ara_name'];
	    }
	}
	 return $data['Service']['eng_name'];
    }

    function getserviceImage($id = NULL,$created_by = NULL,$size = 350){
	App::import("Model", "ServiceImage");
	$model = new ServiceImage();
	$data = $model->find('first', array('fields' => array('image'),'conditions' => array('service_id' =>$id,'created_by'=>$created_by),'order'=>array('order')));
	if(!empty($data)){
	    return "/images/Service/$size/".$data['ServiceImage']['image'];
	}
	return '/img/admin/treat-pic.png';
    }
    
    function getsalonserviceImage($id = NULL,$created_by = NULL,$size = 350){
	App::import("Model", "SalonServiceImage");
	$model = new SalonServiceImage();
        if(!empty($created_by)){
            $data = $model->find('first', array('fields' => array('image'),'conditions' => array('salon_service_id' =>$id,'created_by'=>$created_by),'order'=>array('order')));
        } else {
            $data = $model->find('first', array('fields' => array('image'),'conditions' => array('salon_service_id' =>$id),'order'=>array('order')));
        }
	if(!empty($data)){
	    return "/images/Service/$size/".$data['SalonServiceImage']['image'];
	}
	return '/img/admin/treat-pic.png';
    }
    
    function getpackageImage($id = NULL,$created_by = NULL,$size = 350){
	App::import("Model", "Package");
	$model = new Package();
	$data = $model->find('first', array('fields' => array('image'),'conditions' => array('Package.id' =>$id)));
       if(!empty($data)){
	    return "/images/Service/$size/".$data['Package']['image'];
	}
	return '/img/admin/treat-pic.png';
    }
    
    function getDealImage($id = NULL,$created_by = NULL,$size = 350){
	App::import("Model", "Deal");
	$model = new Deal();
	$data = $model->find('first', array('fields' => array('image'),'conditions' => array('Deal.id' =>$id)));
       if(!empty($data)){
	    return "/images/Service/$size/".$data['Deal']['image'];
	}
	return '/img/admin/treat-pic.png';
    }
    
    function getspabreakImage($id = NULL,$created_by = NULL,$size = 350){
	App::import("Model", "SalonSpabreakImage");
	$model = new SalonSpabreakImage();
        $data = array();
        if(!empty($id)){
            $data = $model->find('first', array('fields' => array('image'),'conditions' => array('spabreak_id' =>$id),'order'=>array('order')));
        }
        if(!empty($data)){
	    return "/images/Service/$size/".$data['SalonSpabreakImage']['image'];
	}else{
            return '/img/admin/treat-pic.png'; 
        }
        
    }
    
    function notification_type($type=NULL){
         $label ='';
         switch ($type){
                case 1:
                    $label = "added new customer";
                    break;
                case 2:
                    $label = "added new staff";;
                    break;
                case 3:
                    $label = "added new service";
                    break;
                default:
                    $label = '';
    } 
        return $label;  
    }
    
    function checkStaffService($uid=NULL){
        App::import("Model", "SalonStaffService");
        $model = new SalonStaffService();
        $total  = $model->find('count' , array('conditions'=>array('staff_id'=>$uid)));
        return $total;
    }
    
    function checkStaffHours($uid=NULL){
        App::import("Model", "SalonOpeningHour");
        $model = new SalonOpeningHour();
        $total  = $model->find('count' , array('conditions'=>array('user_id'=>$uid,
                'OR' => array(
                                'is_checked_disable_mon' => 1,
                                'is_checked_disable_tue' => 1,
                                'is_checked_disable_wed' => 1,
                                'is_checked_disable_thu' => 1,
                                'is_checked_disable_fri' => 1,
                                'is_checked_disable_sat' => 1,
                                'is_checked_disable_sun' => 1,
                              )
            )));
        return $total;
    }
    
    function checkStaffServiceVendor($uid=NULL){
        App::import("Model", "SalonService");
        $model = new SalonService();
         $model->unbindModel(array('belongsTo'=>array('Service')));
        $total  = $model->find('count' , array('conditions'=>array('SalonService.salon_id'=>$uid ,'SalonService.status'=>1)));
        return $total;
    }
    
    function get_access_level_name($groupId=NULL){
        App::import("Model", "Group");
        $model = new Group();
        $data = $model->find('first', array('fields' => array('name','status'), 'conditions' => array('Group.id' =>$groupId)));
        if(@$data['Group']['status'] == 2){
	    return 'Account Owner';
	}
        
        return @$data['Group']['name'];
    }
    
    function get_user_name($id=null){
        
         App::import("Model", "User");
        $model = new User();
        $data = $model->find('first', array('fields' => array('first_name','last_name'), 'conditions' => array('User.id' =>$id)));
        return $data['User']['first_name'].' '.$data['User']['last_name'];
    }
    
    function notifications(){
        $ret =array();
        App::import("Model", "UserNotification");
        $model = new UserNotification();
        $ret['total']  = $model->find('count', array('conditions' => array('notification_to' =>$this->Session->read('Auth.User.id'),'UserNotification.status'=>0)));
        $ret['notifications']= $model->find('all', array('conditions' => array('notification_to' =>$this->Session->read('Auth.User.id'),'UserNotification.status'=>0),'limit'=>5,'order'=>array('UserNotification.id desc')));
        return $ret;
    }
    
    function get_salon_name($uid=NULL){
        App::import("Model", "Salon");
        $model = new Salon();
        $notification = $model->find('first', array('conditions' => array('user_id' =>$uid)));
        if(count($notification)){
         return $notification['Salon']['eng_name'];   
        }else{
        return;  
        }
    }
    
     function get_my_salon_name($uid=NULL){
        $lang = Configure::read('Config.language');
        App::import("Model", "Salon");
        $model = new Salon();
        $notification = $model->find('first', array('conditions' => array('user_id' =>$uid)));
        if(count($notification)){
            if($lang != 'eng'){
                if(!empty($notification['Salon']['ara_name'])){
                    return $notification['Salon']['ara_name'];
                }
            }
            return $notification['Salon']['eng_name'];   
        }else{
            return '';  
        }
    }
    
    public function imageDesignCategoyList($lang = null,$userID = null) {
        App::import("Model", "GiftImage");
        $modelGift = new GiftImage();
        $ids = array($userID,1);
        $giftData  = $modelGift->find('list', array('fields' => array('GiftImage.gift_image_category_id'),'conditions'=>array('GiftImage.is_deleted'=>0,'GiftImage.user_id'=>$ids)));       
        App::import("Model", "GiftImageCategory");
        $model = new GiftImageCategory();
        $giftImageCategoryData  = $model->find('all', array("conditions"=>array("GiftImageCategory.id"=>$giftData,"GiftImageCategory.is_deleted"=>0,"GiftImageCategory.user_id"=>$ids),'fields' => array('GiftImageCategory.id', 'GiftImageCategory.eng_title', 'GiftImageCategory.ara_title')));
        if(empty($lang)){
            $lang = 'eng';
        }
    //    pr($giftImageCategoryData);
    
    
        $new_giftImageCategoryData = array();
        if(!empty($giftImageCategoryData)){
            foreach($giftImageCategoryData as $img_cat){
                if(!empty($img_cat['GiftImageCategory'][$lang.'_title'])){
                    $new_giftImageCategoryData[$img_cat['GiftImageCategory']['id']] = $img_cat['GiftImageCategory'][$lang.'_title'];
                } else {
                    $new_giftImageCategoryData[$img_cat['GiftImageCategory']['id']] = $img_cat['GiftImageCategory']['eng_title'];
                }
            }
        }
        return $new_giftImageCategoryData;
    }
    public function giftImagePrimaryId($userID = null){
        App::import("Model", "GiftImage");
        $modelGift = new GiftImage();
        $ids = array($userID,1);
        $modelPrimaryKey=$modelGift->find('first',array('fields'=>array('GiftImage.id'),'conditions'=>array('GiftImage.is_deleted'=>0,'GiftImage.user_id'=>$ids)));
        return $modelPrimaryKey;
    }
    
   function get_nofication_event($id=NULL , $modal=NULL){
       if($modal=='User' && $id){
        App::import("Model", "User");
        $model = new User();
        $model->recursive  = -1;
        $userdetail = $model->find('first', array('conditions'=>array('User.id'=>$id),'fields'=>array('id', 'first_name','last_name','username')));       
        return $userdetail;
        }elseif('Service'){
            return;  
        } 
   } 
   
   function checkServiceStatus($uid=NULL){
        App::import("Model", "SalonService");
        $SalonService = new SalonService();
        $SalonService->recursive = -1;
        $countService = $SalonService->find('count',array('conditions'=>array('SalonService.salon_id'=>  base64_decode($uid))));
        //echo $SalonService->getLastQuery(); 
        return $countService;
   }
   /**
    * Get the User List
    */
   public function getUserList() {        
        App::import('Model', 'User');
        $this->User = new User();
        $userList = $this->User->find('list', array('fields' => array('User.id', 'User.username'), 'conditions' => array('User.username <>'=>'','User.type' => 6, 'User.status' => 1, 'User.parent_id' => 0)));     
        return $userList;
    }
    
     /**
    * Get all  User List
    */
   public function getallUserList() {        
        App::import('Model', 'User');
        $this->User = new User();
        $userList = $this->User->find('list', array('fields' => array('User.id', 'User.username'), 'conditions' => array('User.username <>'=>'','User.status' => 1, 'User.parent_id' => 0,'User.type' => 6)));     
        return $userList;
    }
    /**
    * Get the Service List
    */
   public function getServiceList($userId = NULL) {        
        App::import('Model', 'SalonService');
        $theList = array();
        if($userId){
            $this->SalonService = new SalonService();
            $this->SalonService->unbindModel(array('hasMany'=>array('SalonStaffService','SalonServiceImage','ServicePricingOption'),'hasOne'=>array('SalonServiceDetail')));
            $this->SalonService->bindModel(array('belongsTo'=>array('Service')));
            $serviceList = $this->SalonService->find('threaded', array('conditions' => array('SalonService.salon_id' => $userId, 'SalonService.status' => 1,'SalonService.is_deleted' => 0)));
            
            if(!empty($serviceList)){
                foreach($serviceList as $theService){
                    if(!empty($theService['children'])){
                        foreach($theService['children'] as $theChildSer){
                            $theList[$theChildSer['SalonService']['id']] = (!empty($theChildSer['SalonService']['eng_display_name']))? $theChildSer['SalonService']['eng_display_name'] : (!empty($theChildSer['SalonService']['eng_name']))? $theChildSer['SalonService']['eng_name'] : $theChildSer['Service']['eng_name'];
                        }
                    }
                }
            }
        }        
        return $theList;
    }
    
    public function checkServiceSelected($id=null){
        App::import('Model', 'SalonService');
        $this->SalonService = new SalonService();
       // $user_id = $auth_user['User']['id'];
        $salonService = $this->SalonService->find('count',array('conditions'=>array('SalonService.salon_id'=>$this->Session->read('Auth.User.id'),'SalonService.service_id'=>$id,'SalonService.is_deleted'=>0)));
        if($salonService >0){
            return true;
        }else{
            return false;
        }
    }
    function get_salon_service_name($id=NULL){
        App::import("Model", "SalonService");
        $model = new SalonService();
        $salonService = $model->find('first', array('conditions' => array('SalonService.id' =>$id)));
        if(count($salonService)){
            if(empty($salonService['SalonService']['eng_name'])){
                return $this->get_service_name($salonService['SalonService']['service_id']);
            }else{
                return $salonService['SalonService']['eng_name'];       
            }
            
        }else{
            return '';  
        }
    }
    function get_salon_package_name($id=NULL){
        App::import("Model", "Package");
        $lang = Configure::read('Config.language');
        $model = new Package();
        $salonService = $model->find('first', array('conditions' => array('Package.id' =>$id)));
        if(count($salonService)){
            if(empty($salonService['Package'][$lang.'_name'])){
                return $salonService['Package'][$lang.'_name'];       
            }else{
                 return $salonService['Package']['eng_name'];     
            }
            
        }else{
            return '';  
        }
    }
    
    function getDealType($id = null){
        App::import("Model", "Deal");
        $model = new DealServicePackage();
        $model->bindModel(array('belongsTo'=>array('Deal')));
        $model->unbindModel(array('hasMany'=>array('DealServicePackagePriceOption')));
        $deal = $model->find('first',array('fields'=>array('Deal.type','DealServicePackage.salon_service_id','DealServicePackage.package_id'),'conditions'=>array('Deal.id'=>$id)));
        return $deal;
    }
    
     function get_salon_deal_name($id=NULL){
        App::import("Model", "Deal");
        $lang = Configure::read('Config.language');
        $model = new Deal();
        $deal = $model->find('first', array('fields'=>array('eng_name','ara_name'),'conditions' => array('Deal.id' =>$id)));
        if(count($deal)){
            if(empty($deal['Deal'][$lang.'_name'])){
                return $deal['Deal'][$lang.'_name'];       
            }else{
                 return $deal['Deal']['eng_name'];     
            }
            
        }else{
            return '';  
        }
     }
     
    function get_spabreak_name($id=NULL){
        App::import("Model", "Spabreak");
        $lang = Configure::read('Config.language');
        $model = new Spabreak();
        $salonService = $model->find('first', array('conditions' => array('Spabreak.id' =>$id)));
        if(count($salonService)){
            if(empty($salonService['Spabreak'][$lang.'_name'])){
                return $salonService['Spabreak'][$lang.'_name'];       
            }else{
                 return $salonService['Spabreak']['eng_name'];     
            }
            
        }else{
            return '';  
        }
    }
     function get_service_name($id=NULL){
        App::import("Model", "Service");
        $model = new Service();
        $Service = $model->find('first', array('conditions' => array('Service.id' => $id)));
        if(count($Service)){
         return $Service['Service']['eng_name'];   
        }else{
        return;  
        }
    }
    
    function get_my__salon_service_name($id=NULL){
        $lang = Configure::read('Config.language');
        App::import("Model", "SalonService");
        $model = new SalonService();
        $salonService = $model->find('first', array('conditions' => array('SalonService.id' =>$id)));
        if(count($salonService)){
            if(empty($salonService['SalonService']['eng_name'])){
                return $this->get_service_name($salonService['SalonService']['service_id']);
            }else{
                if($lang != 'eng'){
                    if(!empty($salonService['SalonService']['ara_name'])){
                       return $salonService['SalonService']['ara_name'];
                    }
                }
                return $salonService['SalonService']['eng_name'];       
            }
        }else{
            return '';  
        }
    }
    
     function get_my_service_name($id=NULL){
        $lang = Configure::read('Config.language');
        App::import("Model", "Service");
        $model = new Service();
        $Service = $model->find('first', array('conditions' => array('Service.id' =>$id)));
        if(count($Service)){
            if($lang != 'eng'){
                if(!empty($Service['Service']['ara_name'])){
                    return $Service['Service']['ara_name'];
                }
            }
         return $Service['Service']['eng_name'];   
            
        }else{
            return '';  
        }
    }
    
    public function checkPackageServiceSelected($id=null,$package_id=null){
        App::import('Model', 'PackageService');
        $this->PackageService = new PackageService();
       // $user_id = $auth_user['User']['id'];
        $salonService = $this->PackageService->find('count',array('conditions'=>array('PackageService.package_id'=>$package_id,'PackageService.salon_service_id'=>$id)));
        if($salonService >0){ 
            return true;
        }else{
            return false;
        }
    }
    
     public function gifcertificateImage($order_id=null){
        App::import('Model', 'GiftCertificate');
        $this->GiftCertificate = new GiftCertificate();
       // $user_id = $auth_user['User']['id'];
        $fields = array('image');
        $Giftcertificate = $this->GiftCertificate->find('first',array('conditions'=>array('GiftCertificate.order_id'=>$order_id),'fields'=>$fields));
        if(isset($Giftcertificate['GiftCertificate']['image']) && !empty($Giftcertificate['GiftCertificate']['image'])){ 
         return "/images/GiftImage/original/".$Giftcertificate['GiftCertificate']['image'];
        }else{
            return false;
        }
    }
    
    function serviceImage($image=NULL,$size = 350){
        //echo $image;exit;
		if(!empty($image)){
                 return "/images/Service/$size/".$image;
	}
	return '/img/admin/treat-pic.png';
    }
    
    function giftImage($image=NULL,$size = 350){
        //echo $image;exit;
		if(!empty($image)){
                 return "/images/GiftImage/$size/".$image;
	}
	return '/img/admin/treat-pic.png';
    }
    
    function getdate_diff($future_date){
        $daysleft = 0;
        $future = $future_date;
        $now = time();
        $timeleft = $future-$now;
        $daysleft = round((($timeleft/24)/60)/60);
        if($daysleft == '1'){
            return '1 day left !! </br>';
        }else{
            return $daysleft.' days left !!</br>';
        }
        return $daysleft;
    }
    
    //function getServicePrice($user_id = NULL, $service_id = NUll) {
    //    App::import('Model', 'ServicePricingOption');
    //    $this->ServicePricingOption = new ServicePricingOption();
    //    // $user_id = $auth_user['User']['id'];
    //    $salonServicePrices = $this->ServicePricingOption->find('all', array('conditions' => array('salon_service_id' => $service_id, 'user_id' => $user_id)));
    //    $fullprice = array();
    //    $sell_price = array();
    //    if (count($salonServicePrices)) {
    //        $price = 0;
    //        foreach ($salonServicePrices as $price) {
    //            if ($price['ServicePricingOption']['sell_price'])
    //                $sell_price[] = $price['ServicePricingOption']['sell_price'];
    //
    //            if ($price['ServicePricingOption']['full_price'])
    //                $fullprice[] = $price['ServicePricingOption']['full_price'];
    //        }
    //        if (count($sell_price)) {
    //            sort($sell_price);
    //        }
    //        if (count($fullprice)) {
    //            sort($fullprice);
    //        }
    //        if (count($sell_price) && count($fullprice)) {
    //            if ($fullprice['0'] > $sell_price['0']) {
    //                return "<span>AED " . $fullprice['0'] . "</span> from AED " . $sell_price['0'] . "</p>";
    //            } else if ($fullprice['0'] == $sell_price['0']) {
    //                return "AED " . $fullprice['0'];
    //            }
    //        } else if (!count($sell_price) && count($fullprice)) {
    //            return "AED " . $fullprice['0'];
    //        } else if (count($sell_price) && !count($fullprice)) {
    //            return "AED " . $sell_price['0'];
    //        }
    //    }
    //}
    
    public function getStatesBYid($id = null) {
        if(!empty($id)){
            App::import('Model', 'State');
            $this->State = new State();
            $stateData = $this->State->find('first', array('fields' => array('State.name'), 'conditions' => array('State.status' => 1, 'State.id' => $id)));
            if(isset($stateData['State']['name'])){
               return $stateData['State']['name'];
            }
        }
        return;
    }
     public function getCountryBYid($id = null){
        if(!empty($id)){
           App::import('Model', 'Country');
           $this->Country = new Country();
           $stateData = $this->Country->find('first', array('fields' => array('Country.name'), 'conditions' => array('Country.id' => $id)));
           if($stateData['Country']['name']){
              return $stateData['Country']['name'];
           }
        }
        return;
    }
    
    function getImplodeVal($allValAray=array() ,$inValarays=array() ,$implodeicon){
                  $display_lan = array();
                  if((count($allValAray) && $allValAray) && (count($inValarays) && $inValarays)) {
                                foreach (@$inValarays as $inValaray){
                                 $display_lan[] = $allValAray[$inValaray];  
                                } 
                      return implode($implodeicon ,$display_lan); 
                  }
                  return __('not_mentioned',true);        
    }
    
    function encrypt_string($input){
        $inputlen = strlen($input);// Counts number characters in string $input
        $randkey = rand(1, 9); // Gets a random number between 1 and 9
        $i = 0;
            while ($i < $inputlen){
                $inputchr[$i] = (ord($input[$i]) - $randkey);//encrpytion
                $i++; // For the loop to function
            }
        $encrypted = implode('-', $inputchr) . '-' . (ord($randkey)+50);
        return $encrypted;
    }

    function decrypt_string($input){
        $input_count = strlen($input);
        $real = '';
        $dec = explode("-", $input);// splits up the string to any array
        $x = count($dec);
        $y = $x-1;// To get the key of the last bit in the array
        $calc = $dec[$y]-50;
        $randkey = chr($calc);// works out the randkey number
        $i = 0;
       while ($i < $y){
          $array[$i] = $dec[$i]+$randkey; // Works out the ascii characters actual numbers
          $real .= chr($array[$i]); //The actual decryption
          $i++;
        };
        $input = $real;
        return $input;
    }
  
  
  function checkMobileVerified($id){
    App::import('Model', 'User');
    $this->User = new User();
    $data = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
    
    if($data['User']['is_phone_verified']==1){
        return true;
    }else{
        return false;
    }
    
  }
  
  function get_room_options($id=null,$spabreakID =null ,$type="room"){
     App::import('Model', 'SalonRoom');
    $this->SalonRoom = new SalonRoom();
    App::import('Model', 'SpabreakOption');
    $this->SpabreakOption = new SpabreakOption();
    $roomIds = array();
    if($spabreakID){
        $roomIds = $this->SpabreakOption->find('list',array('fields'=>array('id','salon_room_id'),'conditions'=>array('SpabreakOption.spabreak_id'=>$spabreakID)));
       
    }
    $data = $this->SalonRoom->find('list',array('fields'=>array('id','eng_room_type'),'conditions'=>array('SalonRoom.user_id'=>$id,'SalonRoom.is_deleted'=>0 ,'SalonRoom.type'=>$type, 'NOT'=>array('SalonRoom.id'=>$roomIds))));
     return $data;
  }
  
   public function get_pricingLevel_staff($pricingLevelid = null){
        App::import('Model', 'PricingLevelAssigntoStaff');
        $this->PricingLevelAssigntoStaff = new PricingLevelAssigntoStaff();
        $PricingLevelAssigntoStaff = $this->PricingLevelAssigntoStaff->find('list', array('fields' => array('PricingLevelAssigntoStaff.id', 'PricingLevelAssigntoStaff.user_id'), 'conditions' => array('PricingLevelAssigntoStaff.pricing_level_id' =>$pricingLevelid)));
        return $PricingLevelAssigntoStaff;
        
    }
    
  function get_room_name($id=null){
     App::import('Model', 'SalonRoom');
    $this->SalonRoom = new SalonRoom();
    $data = $this->SalonRoom->find('first',array('fields'=>array('id','eng_room_type'),'conditions'=>array('SalonRoom.id'=>$id,)));
    
    return $data['SalonRoom']['eng_room_type'];
  }
  function getNumberRange(){
    $getNumbers = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10');
        return $getNumbers;
    }
    
    function getmailaddress($id = NULL){
        if($id){
            App::import('Model', 'User');
            $this->User = new User();
            $data = $this->User->find('first',array('fields'=>array('User.email'),'conditions'=>array('User.id'=>$id)));
            return $data['User']['email'];
        }
        else{
            return '-';
        }
    }

    function checkdayDisabled($day = null , $id = null){
        $dayPriceSet = false;
        App::import('Model', 'SpabreakOptionPerday');
        $this->SpabreakOptionPerday = new SpabreakOptionPerday();
        $data = $this->SpabreakOptionPerday->find('all',array('conditions'=>array('SpabreakOptionPerday.spabreak_option_id'=>$id)));
        if(!empty($data) && !empty($day)){
            foreach($data as $SpabreakOptionPerday){
                if($SpabreakOptionPerday['SpabreakOptionPerday'][$day] == 1){
                 $dayPriceSet = true;    
                }   
            }
        }else{
            return $dayPriceSet;
        }
        return $dayPriceSet;
    } 
  
  function getCount($userId,$type,$chkspaday=NULL){
    App::import('Model', $type);
    if($type=="SalonService"){
         $this->SalonService = new SalonService();
    return $this->SalonService->find('count',array('conditions'=>array('SalonService.salon_id'=>$userId,'SalonService.is_deleted'=>0,'SalonService.status'=>1,'SalonService.parent_id'=>0)));
    }else if($type=="Package"){
         $this->Package = new Package();
         if($chkspaday && $chkspaday == 'spaday'){
            return $this->Package->find('count',array('conditions'=>array('Package.user_id'=>$userId,'Package.type'=>'Spaday','Package.is_deleted'=>0)));
         }else{
            return $this->Package->find('count',array('conditions'=>array('Package.user_id'=>$userId,'Package.type'=>'Package','Package.is_deleted'=>0)));
         }
    }
    else if($type=="Spabreak"){
         $this->Spabreak = new Spabreak();
    return $this->Spabreak->find('count',array('conditions'=>array('Spabreak.user_id'=>$userId,'Spabreak.is_deleted'=>0)));
    }
    else if($type=="Deal"){
        $this->Deal = new Deal();
        return $this->Deal->find('count',array('conditions'=>array('Deal.salon_id'=>$userId,'Deal.is_deleted'=>0, 'Deal.status'=>1, 'Deal.max_time <= '=>date('Y-m-d'))));
    }
    return 0;
  }
  
  
  function get_spabreakPerdayCount($spabreakOptionID  = null){
    $optionID = $spabreakOptionID;
    App::import('Model', 'SpabreakOptionPerday');
    $this->SpabreakOptionPerday = new SpabreakOptionPerday();
     return $this->SpabreakOptionPerday->find('count',array('conditions'=>array('SpabreakOptionPerday.spabreak_option_id'=>$spabreakOptionID)));
  }
  
   function checkStaffServiceAssociation($uid=NULL){
        App::import("Model", "SalonStaffService");
        $model = new SalonStaffService();
        $total  = $model->find('count' , array('conditions'=>array('staff_id'=>$uid,'status'=>1)));
        return $total;
    }
    
    
    function get_salon_staff($uid=NULL){
        App::import("Model", "User");
        $model = new User(); 
        $total  = $model->find('all',array('fields'=>array('id','first_name','last_name' ),'conditions'=>array('OR' => array(array('User.parent_id'=>$uid,'User.type'=>5,'User.is_deleted'=>0,'UserDetail.employee_type'=>2,'User.status'=>1), array('User.id'=>$uid)))));
        return $total;
    }
    
    
    
    function checkServiceAssociation($SalonServiceId = null){
       
        //$pricingidsArray = array('0',$pricinglevelID);
        App::import("Model", "ServicePricingOption");
        $model = new ServicePricingOption();
        $total  = $model->find('list' , array('fields'=>array('id','pricing_level_id'),'conditions'=>array('salon_service_id'=>$SalonServiceId)));
        return $total;
    
    
    }
    
    
    
    
    
  function get_spabreakPrice($spaBreakID = null){
    $priceOpt = array('sell'=>0,'full'=>0,'from'=>0);
    if($spaBreakID){
        App::import('Model', 'SpabreakOption');
        $this->SpabreakOption = new SpabreakOption();
        $priceOptions = $this->SpabreakOption->find('all',array('conditions'=>array('SpabreakOption.spabreak_id'=>$spaBreakID,'SpabreakOption.is_deleted'=>0)));
        $optionArray = array();
        if(!empty($priceOptions)) {
            foreach($priceOptions as  $priceOption){
                foreach($priceOption['SpabreakOptionPerday'] as $optionPerDay){
                    $optionArray[] = $optionPerDay;
                }
            }
        }
       
        if(count($optionArray)!= '' && count($optionArray) === 1) {
					if($optionArray[0]['sell_price'] == ''){
						$priceOpt['full'] =  $optionArray[0]['full_price'];
					}else{
						$priceOpt['full'] = $optionArray[0]['full_price'];
						$priceOpt['sell'] = $optionArray[0]['sell_price'];
					}
				}else if(count($optionArray) >=1){
					$theFprive = array();
					foreach($optionArray as $theMinSellPrice){
						
						if(($theMinSellPrice['sell_price'] < $theMinSellPrice['full_price']) && !empty($theMinSellPrice['sell_price'])){
							$theFprive[] = $theMinSellPrice['sell_price'];	
						}else{
							$theFprive[] = $theMinSellPrice['full_price'];	
						}
						
					}
					$priceOpt['full'] = min(array_filter($theFprive));
					$priceOpt['from'] = 1;
				}
    
    }
     return $priceOpt;
  }
  
  function getParentName($user_id = null){
        App::import("Model", "User");
        $model = new User();
        $parent='';
        $name = $model->find('first', array('conditions' => array('User.id' => $user_id)));
        if(count($name)){
            $parent = ucfirst($name['User']['first_name']).' '.ucfirst($name['User']['last_name']);
            if(strlen($parent)>20){
                $parent = substr($parent,'0','20').'..';
            }
        }
        return $parent;
    }
  
    public function getRandPass($len = 8){
        // Array Declaration
        $pass = array();
        // Variable declaration
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $len; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function getAllserviceImage($serviceID){
        App::import("Model", "SalonServiceImage");
	$model = new SalonServiceImage();
        $images = array();
	$serviceImages = $model->find('all', array('fields' => array('image'),'conditions' => array('salon_service_id' =>$serviceID),'order'=>array('order')));
	if(!empty($serviceImages)){
           foreach($serviceImages as $serviceImage){
               $images[] =  $serviceImage['SalonServiceImage']['image'];
           }
        }
        return $images;
    }
    
    public function get_UserAddress($userId = NULL){
        App::import('Model', 'Address');
        $this->Address = new Address();
        $address = $this->Address->find('first', array('conditions' => array('Address.user_id' => $userId)));
        return $address;
    }

    public function get_SalonAddress($userId = NULL){
        if($userId){
            App::import('Model', 'User');
            App::import('Model', 'Address');
            $this->User = new User();
            $this->Address = new Address();
            $userD = $this->User->find('first',array('fields'=>array('User.type','User.parent_id'),'conditions'=>array('User.id'=>$userId)));
            $uid = $userId;
            if($userD['User']['type'] == 5){
                $uid = $userD['User']['parent_id'];    
            }
            $address = $this->Address->find('first',array('fields'=>array('Address.city_id','Address.state_id'),'conditions'=>array('Address.user_id'=>$uid)));
            $theAdd = '';
            if(isset($address['Address']['city_id']) && !empty($address['Address']['city_id'])){
                $city = $this->getCity($address['Address']['city_id']);
            }else{
                $city='';
            }
            if(!empty($city)){
                    $theAdd .= $city;
            }
            if(isset($address['Address']['state_id']) && !empty($address['Address']['state_id'])){
                $state = $this->getState($address['Address']['state_id']);
            }else{
                $state='';
            }
            if(!empty($state)){
                    $theAdd .= ', '.$state;
            }
            return $theAdd;
        }
        return '----';
    }
    
    // sold as option for spa breaks 
    function get_soldas_options_spabreak(){
        $soldas_array = array('2'=>'eVoucher');
        return $soldas_array;
    } 
    function get_customer($uid=NULL){
        App::import("Model", "User");
        $model = new User(); 
        $total  = $model->find('first',array('fields'=>array('id','first_name','last_name' ),'conditions'=>array('User.id'=>$uid,'User.status'=>1)));
        return $total;
    }
    
    function get_customer_details($uid=NULL){
        App::import("Model", "User");
        $model = new User(); 
        $total  = $model->find('first',array('conditions'=>array('User.id'=>$uid,'User.status'=>1)));
        return $total;
    }
    
    
    public function getCountryStates(){
        App::import('Model', 'Country');
        $this->Country = new Country();
        $countryData = $this->Country->find('all', array(
                'fields' => array('Country.id','Country.title', 'Country.name'),
                'conditions' => array('Country.status' => 1,'Country.is_deleted' => 0)));
        return $countryData;
    }
    
    /**********************************************************************************    
      @Function Name : getSpaBreakType
      @Params	     : null
      @Description   : return spa break types
      @Author        : Sonam Mittal
      @Date          : 23-June-2014
     * ********************************************************************************* */
    function getSpaBreakType(){
        $breakTypes = array('one-night'=>'1 Night Spa Break','two-night'=>'2 Night Spa Break','3'=>'3 Night Spa Break','5'=>'5 Night Spa Break','7'=>'7 Night Spa Break','50-percent-off'=>'50% off Spa Break','last-minute'=>'All Spa Break');
        return $breakTypes;
    }
    
    function getSpabreakRange(){
    $getNumbers = array('1'=>'1','2'=>'2','3'=>'3','5'=>'5','7'=>'7');
        return $getNumbers;
    }
    
    function getSalon($salon_id){
        App::import("Model", "Salon");
        $model = new Salon();
        $salon_detail = $model->find('first',array('fields'=>array('id','business_url'),'conditions'=>array('Salon.user_id'=>$salon_id)));
        if(!empty($salon_detail)){
            return $salon_detail['Salon']['business_url'];
        }
    }
    
    function get_expiryDate($salon_id = NULL){
        App::import("Model", "PolicyDetail");
        $model = new PolicyDetail();
        $fields = array('ev_validity');
        $ownerPolicy = $model->find('first',array('conditions'=>array('PolicyDetail.user_id'=>$salon_id),'fields'=>$fields));
        if(count($ownerPolicy) == 0){
          $ownerPolicy = $model->find('first' ,array('conditions'=>array('user_id'=>1),'fields'=>$fields));   
        }
        $validity = trim($ownerPolicy['PolicyDetail']['ev_validity']);
        $today = time();
        $MonthsLater = strtotime("+$validity months", $today); 
        $date =  date('Y-m-d ',$MonthsLater);
        return $date;
    }
    
     function get_defaultCheckIn($salon_id = NULL){
        App::import("Model", "PolicyDetail");
        $model = new PolicyDetail();
        $fields = array('arrival_time','departure_time');
        $ownerPolicy = $model->find('first',array('conditions'=>array('PolicyDetail.user_id'=>$salon_id),'fields'=>$fields));
        
        if(count($ownerPolicy) == 0){
          $ownerPolicy = $model->find('first' ,array('conditions'=>array('user_id'=>1),'fields'=>$fields));   
        }
        
        if(!empty($ownerPolicy)){
          return $ownerPolicy;
        }
        
        return;
    }
    
    
    function get_soldAs($id = null, $type = null){
        App::import("Model", "SalonServiceDetail");
        $model = new SalonServiceDetail();
        $details = $model->find('first',array('conditions'=>array('SalonServiceDetail.associated_id'=>$id,'SalonServiceDetail.associated_type'=>$type),'fields'=>array('sold_as')));
        return $details['SalonServiceDetail']['sold_as'];
    }
    
    function getYoutubeId($link){
        $video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
        if (empty($video_id[1]))
        $video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..
        $video_id = explode("&", $video_id[1]); // Deleting any other params
        $video_id = $video_id[0];
        return $video_id;
    }
    
    public function employeeName($empId=NULL){
        App::import("Model", "User");
        $model = new User(); 
        $model->recursive  = -1;
        $fields = array('first_name','last_name');
        $data = $model->find('first' , array('conditions'=>array('User.id'=>$empId) ,'fields'=>$fields));
        return $data;   
    } 
    
    public function getEvoucherPolicy($salonId){
            App::import("Model", "PolicyDetail");
            $this->PolicyDetail = new PolicyDetail();
            $policyDetail = $this->PolicyDetail->find('first', array('conditions' => array('user_id' => $salonId)));
           if (empty($policyDetail)) {
                $policyDetail = $this->PolicyDetail->find('first', array('conditions' => array('user_id' => 1)));
           }
           //pr($policyDetail);
           if($policyDetail){
              return $policyDetail['PolicyDetail']['eng_evocher_cancel_policy'];
           }else{
               return false;
           }
    }
    public function getEvoucherExpiry($typeID,$salonId, $type,$dealID = null){
        
            App::import("Model", "SalonServiceDetail");
            $model = new SalonServiceDetail();
            $theexpDate = date('Y-m-d');
            if(!empty($dealID)){
                App::import("Model", "Deal");
                $deal = new Deal();
                $dealData = $deal->find('first',array('conditions'=>array('Deal.id'=>$dealID)));
                
                if(!empty($dealData)){
                    $theexpDate = $dealData['Deal']['avail_time'];
                    return  date('d F Y', strtotime($theexpDate));    
                }
            }
            $details = $model->find('first',array('conditions'=>array('SalonServiceDetail.associated_id'=>$typeID,'SalonServiceDetail.associated_type'=>$type)));
            if(isset($details['SalonServiceDetail']['evoucher_expire']) && $details['SalonServiceDetail']['evoucher_expire'] == 1){
               
                $aftermonth = $details['SalonServiceDetail']['evoucher_expire_after'];
                return  date('d F Y', strtotime("+$aftermonth month", strtotime($theexpDate) ));
            }else{
                App::import("Model", "PolicyDetail");
                $this->PolicyDetail = new PolicyDetail();
                $policyDetail = $this->PolicyDetail->find('first', array('conditions' => array('user_id' => $salonId)));
            if (empty($policyDetail)) {
                 $policyDetail = $this->PolicyDetail->find('first', array('conditions' => array('user_id' => 1)));
            }
            
            if(isset($policyDetail['PolicyDetail']['ev_validity'])){
                $aftermonth = $policyDetail['PolicyDetail']['ev_validity'];
                return  date('d F Y', strtotime("+$aftermonth month", strtotime($theexpDate) ));
            }else{
                return  date('d F Y', strtotime("+6 month", strtotime($theexpDate) ));
            }
            
                
            }
    }
    
    /**********************************************************************************    
  @Function Name : getOrderDetails
  @Params	 : NULL
  @Description   : get order detail by id in frontend
  @Author        : Sonam Mittal
  @Date          : 05-August-2015
***********************************************************************************/
    function getOrderDetails($orderId=null){
        App::import("Model", "Order");
        $this->Order = new Order();
        $data = $this->Order->find('first',array(
            'conditions'=>array('Order.id'=>$orderId)
        ));
        return $data;
    }
    
    
    /**********************************************************************************    
  @Function Name : getGiftDetails
  @Params	 : NULL
  @Description   : get order detail by id in frontend
  @Author        : Sonam Mittal
  @Date          : 05-August-2015
***********************************************************************************/
    function getGiftDetails($giftId=null){
        App::import("Model", "Order");
        $this->Order = new Order();
        $data = $this->Order->find('first',array(
            'conditions'=>array('Order.used_gift_id'=>$giftId)
        ));
        return $data;
    }
    
    
    /**********************************************************************************    
  @Function Name : get_price_from_point
  @Params	 : NULL
  @Description   : get price from points in frontend
  @Author        : Sonam Mittal
  @Date          : 21-August-2015
***********************************************************************************/
    function get_price_from_point(){
        App::import("Model", "PointSetting");
        $model = new PointSetting();
        $get_total_points = $model->find('first',array('conditions'=>array('id'=>1),'fields' => array('aed_unit')));
        $total_points = $get_total_points['PointSetting']['aed_unit'];
        return 50*$total_points;
    }
    
    function get_user_booking_count($id){
        App::import("Model", "Appointment");
        $model = new Appointment();
        $conditions = array();
        
        $userType = $this->Session->read('Auth.User.type');
        $userId = $this->Session->read('Auth.User.id');
        $parentId = $this->Session->read('Auth.User.parent_id');
        if($userType == 4){
            $conditions = array(
                        "not" => array(
                            "Appointment.order_id" => null
                        ),
                        'Appointment.user_id' => $id,
                        'Appointment.salon_id' => $userId,
                        'Appointment.type'=>'A'
                    );
        } else if($userType == 1){
            $conditions = array(
                        "not" => array(
                            "Appointment.order_id" => null
                        ),
                        'Appointment.user_id' => $id,
                        'Appointment.type'=>'A'
                    );
        } else{
            $conditions = array(
                    "not" => array(
                        "Appointment.order_id" => null
                    ),
                    'Appointment.salon_id' => $parentId,
                    'Appointment.type'=>'A',
                    'Appointment.user_id' => $id,
            );
        }
        $count = $model->find('count',array('conditions'=>$conditions,'group' => array('Appointment.order_id,Appointment.evoucher_id ')));
        if(empty($count)){
            echo "0";
        }else{
            echo $count;
        }
    }
    
    function get_user_total_paid_amount($id){
        App::import("Model", "Order");
        $model = new Order();
        $conditions = array();
        
         $userType = $this->Session->read('Auth.User.type');
         $userId = $this->Session->read('Auth.User.id');
         $parentId = $this->Session->read('Auth.User.parent_id');
        //exit;
        $model->virtualFields['total'] = 'SUM(amount)';
        if($userType == 4){
            $conditions = array(
                        "not" => array(
                            "Order.id" => null
                        ),
                        'Order.user_id' => $id,
                        'Order.salon_id' => $userId,
                        'Order.transaction_status'=>1
                    );
        } else if($userType == 1){
            $conditions = array(
                        "not" => array(
                            "Order.id" => null
                        ),
                        'Order.user_id' => $id,
                        'Order.transaction_status'=>1
                    );
        } else{
            $conditions = array(
                    "not" => array(
                        "Order.id" => null
                    ),
                    'Order.salon_id' => $parentId,
                    'Order.user_id' => $id,
                    'Order.transaction_status'=>1
            );
        }
        $total = $model->find('first',array('fields' => array('total'),'conditions'=>$conditions,'recursive'=>'-1'));
        if(!empty($total[0]['Order__total'])){
            echo 'AED '.$total[0]['Order__total'];
        }else{
            echo "0";
        }
    }
    
    function get_cancelled_appointment_user($id){
        App::import("Model", "Appointment");
        $model = new Appointment();
        $conditions = array();
        
        $userType = $this->Session->read('Auth.User.type');
        $userId = $this->Session->read('Auth.User.id');
        $parentId = $this->Session->read('Auth.User.parent_id');
        $dateCheck = date('Y-m-d',strtotime("-1 year"));
        if($userType == 4){
            $conditions = array(
                        "not" => array(
                            "Appointment.order_id" => null
                        ),
                        'Appointment.user_id' => $id,
                        'Appointment.salon_id' => $userId,
                        'Appointment.type'=>'A',
                        'Appointment.status'=>5,
                        'Appointment.created <='=> $dateCheck
                    );
        } else if($userType == 1){
            $conditions = array(
                        "not" => array(
                            "Appointment.order_id" => null
                        ),
                        'Appointment.user_id' => $id,
                        'Appointment.type'=>'A',
                        'Appointment.status'=>5,
                        'Appointment.created <='=> $dateCheck
                    );
        } else{
            $conditions = array(
                    "not" => array(
                        "Appointment.order_id" => null
                    ),
                    'Appointment.salon_id' => $parentId,
                    'Appointment.type'=>'A',
                    'Appointment.user_id' => $id,
                    'Appointment.status'=>5,
                    'Appointment.created <='=> $dateCheck
            );
        }
        $count = $model->find('count',array('conditions'=>$conditions,'group' => array('Appointment.order_id,Appointment.evoucher_id ')));
        if(empty($count)){
            echo "0";
        }else{
            echo $count;
        }
    }
    
    function get_noshow_appointment_user($id){
        App::import("Model", "Appointment");
        $model = new Appointment();
        $conditions = array();
        
        $userType = $this->Session->read('Auth.User.type');
        $userId = $this->Session->read('Auth.User.id');
        $parentId = $this->Session->read('Auth.User.parent_id');
        $dateCheck = date('Y-m-d',strtotime("-1 year"));
        if($userType == 4){
            $conditions = array(
                        "not" => array(
                            "Appointment.order_id" => null
                        ),
                        'Appointment.user_id' => $id,
                        'Appointment.salon_id' => $userId,
                        'Appointment.type'=>'A',
                        'Appointment.status'=>8,
                        'Appointment.created <='=> $dateCheck
                    );
        } else if($userType == 1){
            $conditions = array(
                        "not" => array(
                            "Appointment.order_id" => null
                        ),
                        'Appointment.user_id' => $id,
                        'Appointment.type'=>'A',
                        'Appointment.status'=>8,
                        'Appointment.created <='=> $dateCheck
                    );
        } else{
            $conditions = array(
                    "not" => array(
                        "Appointment.order_id" => null
                    ),
                    'Appointment.salon_id' => $parentId,
                    'Appointment.type'=>'A',
                    'Appointment.user_id' => $id,
                    'Appointment.status'=>8,
                    'Appointment.created <='=> $dateCheck
            );
        }
        $count = $model->find('count',array('conditions'=>$conditions,'group' => array('Appointment.order_id,Appointment.evoucher_id ')));
        if(empty($count)){
            echo "0";
        }else{
            echo $count;
        }
    }
    
    
    //function gift_price_used($gift_id){
    //    App::import('Model', 'GiftCertificate');
    //    $this->GiftCertificate = new GiftCertificate();
    //    $this->GiftCertificate->bind(
    //            array('hasMany' => array(
    //                'GiftDetail'=>array(
    //                    'className'=>'GiftDetail',
    //                    'foreignKey'=>'gift_id'
    //                )
    //            )
    //        ));
    //     
    //    $gift_detail = $this->GiftCertificate->find('first', array('conditions'=>array('GiftCertificate.id'=>$gift_id)));
    //    //pr($gift_detail);
    //    die;
    //            
    //}
    
     /*public function admin_mail_pdf($appointment_title=NULL,$user_id=NULL,$service_name=NULL,$start_date=NULL,$duration=NULL,$tempate=NULL,$smsTo=NULL){
        App::import("Model", "User");
        $this->User = new User();
        $userData = $this->User->findById($user_id);
        $toEmail =   $userData['User']['email'];
        $fromEmail  =   Configure::read('fromEmail');
        $dynamicVariables = array('{FirstName}'=>ucfirst($userData['User']['first_name']),'{LastName}'=>ucfirst($userData['User']['last_name']));
        $path= $_SERVER['SERVER_NAME'];
        $file_name='/files/pdf/invoice-'.$user_id.'.pdf';
        //echo $path.'/'.$file_name; die; 
        //$file_name = 'bones.jpg';
        //echo $path; echo "====="; echo $file_name; die;
        //$userName = $userData['User']['first_name'];
        //$userEmail = $userData['User']['email'];
        //$mbNumber =  $userData['Contact']['cell_phone']; 
        //$country_code  = $userData['Contact']['country_code'];
       // App::import("Component", "CommonComponent");
       
       //$collection = new CommonComponent();
        //$acl = new CommonComponent($collection);
        
        $collection = new ComponentCollection();
        $common = new CommonComponent($collection);
        
        //$this->CommonComponent = new CommonComponent();
        //echo $toEmail; die;
        $templateID='mail_order_pdf';
        App::import('Model', 'Emailtemplate');
            $this->Emailtemplate = new Emailtemplate();
            $template = $this->Emailtemplate->find('first', array('conditions' => array('Emailtemplate.template_code' => $templateID)));
           
            if(isset($dynamicFields['{template_type}']) && $dynamicFields['{template_type}']==1){
                $messages = (!empty($template['Emailtemplate']['text_template']))?$template['Emailtemplate']['text_template']:$template['Emailtemplate']['template'];   
            }else{
                 
                $messages = $template['Emailtemplate']['template'];
            }
            $subject = $template['Emailtemplate']['name'];
        //pr($dynamicVariables); die;
       
       // echo 'toEmail>>>'; echo $file_name; die;
        $common->sendEmailAttach($toEmail,$fromEmail,$subject,$messages,$path,$file_name,$templateID,$dynamicVariables);
        
       
        
        
        //public function sendEmail($to = null, $from = null, $templateID = null, $dynamicFields = null, $reply = null, $path = null, $file_name = null) {
    }*/
    
    public function get_appointment_reviews($review_rating_id){
        if($review_rating_id!=''){
            App::import("Model", "ReviewRating");
        $Reviewmodel = new ReviewRating();
            $reviewRating=$Reviewmodel->find('all',array('conditions'=>array('ReviewRating.id'=>$review_rating_id)));
           // pr($reviewRating); //die;
            return $reviewRating;
        }
    }
    public function get_appointment_reviews_packageId($package_id){
        if($package_id!=''){
            App::import("Model", "ReviewRating");
        $Reviewmodel = new ReviewRating();
        $package=$Reviewmodel->find('all',array('conditions'=>array('ReviewRating.package_id'=>$package_id)));
            return $package;
        }
    }
    
    public function fetch_comments_by_review($review_id){
        if($review_id!=''){
            App::import("Model", "ReviewComment");
            $ReviewCommentModel = new ReviewComment();
            $ReviewCommentModel->bindModel(array('belongsTo'=>array('User')));
            $ReviewCommentModel->recursive = 1;
            $reviewComments=$ReviewCommentModel->find('all',array('fields'=>array('ReviewComment.comment_text','User.image','User.id','User.first_name','User.last_name'),'conditions'=>array('ReviewComment.review_id'=>$review_id),'order' => array('ReviewComment.id' => 'desc'),));
            return $reviewComments;
        }
    }
    
     public function get_rating_by_user($user_id){
        if($user_id!=''){
            App::import("Model", "ReviewRating");
            $ReviewRatingModel = new ReviewRating();
            $ReviewRatingModel->bindModel(array('belongsTo'=>array('User')));
            $ReviewRatingModel->recursive = 1;
            $reviewRating=$ReviewRatingModel->find('all',array('fields'=>array('AVG(ReviewRating.staff_rating) as avgRating'),'conditions'=>array('ReviewRating.user_id'=>$user_id)));
            return $reviewRating;
        }
    }
    public function get_rating_by_salon($salon_id){
        if($salon_id!=''){
            App::import("Model", "ReviewRating");
            $ReviewRatingModel = new ReviewRating();
            $ReviewRatingModel->bindModel(array('belongsTo'=>array('User')));
            $ReviewRatingModel->recursive = 1;
            $reviewRating=$ReviewRatingModel->find('all',array('fields'=>array('AVG(ReviewRating.venue_rating) as avgRating'),'conditions'=>array('ReviewRating.salon_id'=>$salon_id)));
            return $reviewRating;
        }
    }
    
     public function get_total_reviews_by_service($service_id){
        if($service_id!=''){
            //echo $service_id; die;
            App::import("Model", "ReviewRating");
            $ReviewRatingModel = new ReviewRating();
            $ReviewRatingModel->bindModel(array('belongsTo'=>array('User')));
            $joins= array(
                        array(
                            'alias' => 'Review',
                            'table' => 'reviews',
                            'type' => 'INNER',
                            'conditions' => '`Review`.`review_rating_id` = `ReviewRating`.`id`'
                ),
                        array(
                            'alias' => 'Appointment',
                            'table' => 'appointments',
                            'type' => 'INNER',
                            'conditions' => '`Appointment`.`review_id` = `Review`.`id`'
                ));
            $totalReviews=$ReviewRatingModel->find('count',array('conditions'=>array('ReviewRating.service_id'=>$service_id),'joins'=>$joins));
            return $totalReviews;
        }
     }
     public function get_helpful_count($review_id){
        if($review_id!=''){
            App::import("Model", "HelpfulReview");
            $HelpfulReviewModel = new HelpfulReview();
            $HelpfulReviewModel->bindModel(array('belongsTo'=>array('Review')));
            $HelpfulReviewModel->recursive = 1;
            $HelpfulReview=$HelpfulReviewModel->find('count',array('fields'=>array('HelpfulReview.id'),'conditions'=>array('HelpfulReview.review_id'=>$review_id)));
            return $HelpfulReview;
        }
    }
    public function findCommentsByBlogID($blog_id){
        App::import("Model", "BlogComment");
        
        $BlogCommentModel = new BlogComment();
        $BlogCommentModel->bindModel(array('belongsTo'=>array('User')));
        $comments=$BlogCommentModel->find('all',array('fields'=>array('BlogComment.id','BlogComment.eng_comment','BlogComment.created','BlogComment.eng_comment','User.id','User.first_name','User.last_name','User.image'),'conditions'=>array('BlogComment.blog_id'=>$blog_id)));
            return $comments;
    }
    
    
 }
