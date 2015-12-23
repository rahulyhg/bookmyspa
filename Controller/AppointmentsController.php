<?php
class AppointmentsController extends AppController {
    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session','Common','Paginator'); //An array containing the names of components this controller uses.
    
/**********************************************************************************    
  @Function Name : admin_index
  @Params	 : NULL
  @Description   : The Function to show calendar with appointments
  @Author        : Aman Gupta
  @Date          : 27-Feb-2014
***********************************************************************************/
    public function admin_index(){
        $this->set('title_for_layout', 'Sieasta | Appointments');
        $this->layout = 'calender';
        $this->loadmodel('User');
        $this->loadmodel('SalonOpeningHour');
        $this->loadModel('SalonService');
        $this->loadModel('SalonCalendarSetting');
	$userid = $this->Auth->user('type');
	if(!in_array($userid,array(4,5))){
	      $this->Session->setFlash('You cannot access the Calendar.', 'flash_error');
              $this->redirect(array('controller' => 'Dashboard', 'action' => 'index', 'admin' => true));
	}
        $calsettings = $this->SalonCalendarSetting->find('first',array('fields'=>array('id','user_id','week_start_day','default_view','provider_max_day_limit','calendar_resolution','calendar_line_space','mark_current_time','retention','service_provider_order','display_badges'),'conditions'=>array('SalonCalendarSetting.user_id'=>$this->Auth->user('id'))));
        if(empty($calsettings)){
            $calsettings = $this->SalonCalendarSetting->find('first',array('fields'=>array('id','user_id','week_start_day','default_view','provider_max_day_limit','calendar_resolution','calendar_line_space','mark_current_time','retention','service_provider_order','display_badges'),'conditions'=>array('SalonCalendarSetting.user_id'=>1)));
        }
        $staff = $this->Common->get_salon_staff($this->Auth->user('id'));
        if(isset($calsettings['SalonCalendarSetting']['service_provider_order']) && !empty($calsettings['SalonCalendarSetting']['service_provider_order'])){
            $staffOrder = explode(',',$calsettings['SalonCalendarSetting']['service_provider_order']);
            $staff = $this->Common->staffSortbySorder($staff,$staffOrder);
        }else{
          $staffOrder[0]= $this->Auth->user('id');
          $staff = $this->Common->staffSortbySorder($staff,$staffOrder);
        }
        $services = $this->Common->getSalonServiceList($this->Auth->user('id'));
        $breadcrumb = array('Home'=>array('controller'=>'appointments','action'=>'index','admin'=>true),'Appointments'=>'javascript:void(0);');
        if($this->Session->read('Schedular.employee')){
            $checkedEmpList = $this->Session->read('Schedular.employee');
        }else{
            $checkedEmpList = array($this->Auth->user('id'));
        }
        $session_start_date=$this->Session->read('SessionCalenderStartDate');
	if(isset($session_start_date) && $session_start_date!=''){
           $startDate = $session_start_date;
        }
        else{
            $startDate = date('Y/m/d');
        }
        $cal_date="";
        if($this->request->is('post') || $this->request->is('put')){
            if(isset($this->request->data['date'])){
                $startDate =  gmdate('Y/m/d',$this->request->data['date']);
                $cal_date=$startDate;
            }
            if(isset($this->request->data['week'])){
                $week = $this->request->data['week']; 
                $newdate = strtotime ( $week.' week' , $this->request->data['date'] ) ;
                $startDate = gmdate( 'Y/m/d' , $newdate );
            }
            if(isset($this->request->data['user'])){
               $ids = array_filter($this->request->data['user']);
               $this->Session->write('Schedular.employee', $ids);
               $checkedEmpList = $ids;
            }
            if(isset($this->request->data['button'])){
               $startDate =  date('Y/m/d');
            }
        }
	if($this->Session->read('CustomView')){
            $customView = $this->Session->read('CustomView');
        }
        else{
          $customView='';  
        }
	// for getting appointment and employee JSON for Schedular;
        $this->loadModel('Color');
        $colors = $this->Color->find('first',array('fields'=>array('id','user_id','requested','accepted','awaiting_confirmation','confirmed','show','no_show','in_progress','complete','personal_task_block','personal_task_unblock','on_waiting_list'),'conditions'=>array('Color.user_id'=>$this->Auth->user('id'))));
        if(empty($colors)){
            $colors = $this->Color->find('first',array('fields'=>array('id','user_id','requested','accepted','awaiting_confirmation','confirmed','show','no_show','in_progress','complete','personal_task_block','personal_task_unblock','on_waiting_list'),'conditions'=>array('Color.user_id'=>1)));
        }
        $fulldata = $this->get_app_n_enp($checkedEmpList,$calsettings,$startDate,$colors,$cal_date,$staffOrder);
        $open_close_hours=$this->admin_get_calender_open_close_time($checkedEmpList);
        $this->set(compact('customView','breadcrumb','startDate','calsettings','fulldata','checkedEmpList','open_close_hours'));
        $this->set(compact('services','appointments','treatmentFilter'));
        $this->set(compact('staff','openHour'));
        $this->set('activeTMenu','calendar');
        $this->set('page_title','Appointments');
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Appointment";
            $this->render('schedular');
        }
    }
/**********************************************************************************    
  @Function Name : get_app_n_enp
  @Params	 : NULL
  @Description   : The Function to featch all appointments and employee JSON for Schedular
  @Author        : Aman Gupta
  @Date          : 27-Feb-2014
***********************************************************************************/    
    public function get_app_n_enp($employess = array(),$calsettings='NULL',$StartDate='NULL',$colors = array(),$cal_date='NULL',$staffOrder='NULL'){
        $fullData = array('employee'=>'','appointments'=>'','treatfilter'=>'','openHours'=>'');
        if(!empty($employess)){
            $resource = $this->User->find('all', array('fields' => array('id','CONCAT(User.first_name, " ",User.last_name) AS name' ),'conditions' => array('User.id' => $employess)));
            $staff = $this->Common->staffSortbySorder($resource,$staffOrder);
            $resource=$staff;
            if(is_array($resource) && count($resource) > 0){
                $employee = '';
                $openingHours = array();
                $start_date='';
                if(isset($cal_date) && $cal_date!='NULL' && $cal_date!=''){
                    $cal_date = str_replace('/', '-', $cal_date);
                    $this->Session->write('CalenderStartDate', $cal_date);
                    $end_date = date('Y-m-d', strtotime($cal_date . " +7 days"));
                    $this->Session->write('CalenderEndDate', $end_date);
                }else{
                    $viewdate=$this->Session->read('SessionCalenderStartDate'); 
                    $start_date = date('Y-m-d', strtotime($viewdate . " -7 days"));
                    $end_date = date('Y-m-d', strtotime($viewdate . " +7 days")); 
                }
                if($start_date=='' || $end_date=='1970-01-01'){
                    $start_date=date('Y-m-d',strtotime($StartDate . " -7 days")); 
                    $end_date = date('Y-m-d', strtotime($StartDate . " +7 days")); 
                }
                foreach($resource AS $keyRes => $valRes){
                    $openHoursDay = $this->admin_openHoursByDay($valRes['User']['id'],$start_date,$end_date);
                    $opeaningHours = $this->Common->openHoursSchedular($valRes['User']['id']);
                    $check_empty = array_filter($opeaningHours);
                    if (empty($check_empty)) {
                        $opeaningHours = $this->Common->openHoursSchedular(1);
                    }
                    if(!empty($opeaningHours) && !empty($openHoursDay)){
                        foreach($openHoursDay as $dateKey => $sevalue){
                            $key = date('N',$dateKey);
                            $opeaningHours[$key]['sTime'] = $sevalue['sTime'];
                            $opeaningHours[$key]['eTime'] = $sevalue['eTime'];
                        }
                    }
                    $openingHours['openHours'][] = $opeaningHours;
                    $employee_count[]=$valRes[0]['name'];
                    $count_employee=count($employee_count); 
                    if($count_employee<=$calsettings['SalonCalendarSetting']['provider_max_day_limit']){
                        $employee .= '{"text":"'.$valRes[0]['name'].'","value": '.$valRes['User']['id'].'}';
                    }
                    if($keyRes+1 != count($resource)){
                        $employee .= ',';
                    }
                }
                $employee =  '['.$employee.']';
                $fullData['employee'] = $employee;
                $nonWorkingDaysByDate = '';
                $nonWorkingDays_json='';
                $nonWorkingDays = array();
                $groupindex=0;
                $this->loadModel('SalonOpeningHourByDate');
                $nonWorkingDays_json=rtrim($nonWorkingDays_json, ",");
                $nonWorkingDays_json =  '['.$nonWorkingDays_json.']';
                $fullData['non_working_days'] = $nonWorkingDays_json;
                $start_date = str_replace('/', '-', $start_date);
                $this->Appointment->unbindModel(array('belongsTo' => array('User','SalonService')), true);
                $conditions = array('fields'=>array('id','appointment_title','by_vendor','salon_staff_id','salon_service_id','status','type','appointment_comment','appointment_repeat_type','appointment_repeat_end_date','appointment_repeat_day','appointment_repeat_weeks','appointment_repeat_month_date','appointment_yearly_repeat_month_date','appointment_repeat_month','appointment_return_request','appointment_start_date','waiting_appointments','appointment_duration','exclude_dates','changed_status'),
                                    'conditions' => array(
                                            'OR'=>array(
                                                array('Appointment.appointment_repeat_end_date >='=>strtotime($start_date.' '.'00:00')),
                                            'AND'=>array(
                                                    array('Appointment.appointment_start_date >='=>strtotime($start_date.' '.'00:00')),
                                                    array('Appointment.appointment_start_date <='=>strtotime($end_date.' '.'23:59'))
                                                    )
                                                ),
                                            'AND'=>array(
                                                    array('Appointment.is_deleted'=>0),
                                                    array('Appointment.status NOT IN(5,9)'))
                                                )
                                    );
                $appointments=$this->Appointment->find('all',$conditions);
                //pr($appointments); die;
                if(count($appointments)>0){
                    $appointments_json='[';
                    foreach($appointments as $appointment){
                        if($calsettings['SalonCalendarSetting']['retention']==1){
                            $return_request=$appointment['Appointment']['appointment_return_request'];  
                        }else{
                            $return_request='';
                        }
                        $start_date = 'new Date("'.date("Y/m/d H:i",$appointment['Appointment']['appointment_start_date']).'")';
                        $minutes_to_add = $appointment['Appointment']['appointment_duration'];
                        $time = new DateTime(date("Y/m/d H:i",$appointment['Appointment']['appointment_start_date']));
                        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                        $end_date_time = $time->format('Y/m/d H:i');
                        $end_date='new Date("'.$end_date_time.'")';
                        $color_value=$this->color_set($appointment['Appointment']['type'],$appointment['Appointment']['status'],$colors);
                        $event_type=$color_value['event_type'];
                        $color=$color_value['color'];
                        
                    /* Code for creating json of daily repeating Appointments */                    
                        if($appointment['Appointment']['appointment_repeat_type']==1){
                            $start = strtotime(date("Y-m-d",$appointment['Appointment']['appointment_start_date']));
                            $start_time=date("H:i",$appointment['Appointment']['appointment_start_date']);
                            $compare_start_date=strtotime(date("Y-m-d H:i",$appointment['Appointment']['appointment_start_date']));
                            $compare_end_date=$end_date_time;
                            $calender_start_date=$this->Session->read('CalenderStartDate');
                            $calender_start_date=date('Y-m-d',strtotime($calender_start_date . ' + 1 day'));
                            $calender_start_date_time=strtotime($calender_start_date.' '.$start_time);
                            $calender_end_date=$this->Session->read('CalenderEndDate'); 
                            $end_time = $time->format('h:i');
                            $calender_end_date=strtotime($calender_end_date.' '.$end_time);
                            $end = strtotime($appointment['Appointment']['appointment_repeat_end_date']);
                            $repeat_days = ($end - $start)  / (60 * 60 * 24); 
                            for($i=0;$i<=$repeat_days;$i++){
                                $color_value=$this->color_set($appointment['Appointment']['type'],$appointment['Appointment']['status'],$colors);
                                $color=$color_value['color'];
                                if($i==0){
                                    $start = date("Y/m/d H:i",$appointment['Appointment']['appointment_start_date']);
                                    $hoverTitleStart=date('D-H:m A',strtotime($start));
                                    $end = $end_date_time;
                                    $hoverTitleEnd=date('H:m A',strtotime($end));
                                }
                                else{
                                    $tomorrow = date('Y/m/d H:i',strtotime($start . "+1 days"));
                                    $tomorrow_end_date=date('Y/m/d H:i',strtotime($end . "+1 days"));
                                    $start=$tomorrow;
                                    $end=$tomorrow_end_date;
                                    $hoverTitleStart=date('D-H:i A',strtotime($tomorrow));
                                    $start_date = 'new Date("'.$tomorrow.'")';
                                    $hoverTitleEnd=date('H:i A',strtotime($tomorrow_end_date));
                                    $end_date='new Date("'.$tomorrow_end_date.'")';
                                }
                                if(!empty($appointment['Appointment']['exclude_dates'])){
                                    $app_dates=unserialize($appointment['Appointment']['exclude_dates']);
                                    if (in_array($appointment['Appointment']['appointment_start_date'], $app_dates) && !isset($tomorrow)){
                                        $in='in';
                                    }
                                    elseif(isset($tomorrow) && in_array(strtotime($tomorrow), $app_dates)){
                                        $in='in';
                                    }
                                    else{
                                        $in='';
                                    }
                                }
                                if(!empty($appointment['Appointment']['changed_status'])){
                                    $changed_status=unserialize(base64_decode($appointment['Appointment']['changed_status']));
                                    //echo $start_date; die;
                                    
                                   // pr($changed_status); die;
                                    foreach($changed_status as $changed_status){
                                        if(isset($tomorrow)){
                                           // echo $tomorrow; die;
                                            $tomorrow = str_replace('/', '-', $tomorrow);
                                        }
                                        //echo $tomorrow; echo "----";  echo strtotime($tomorrow); echo "===";
                                       // if($appointment['Appointment']['id']==557){
                                         //   echo strtotime($tomorrow); 
                                        //}
                                        if(isset($tomorrow) && strtotime($tomorrow)==$changed_status['date']){
                                           //echo $changed_status['status']; die;
                                            $color_value=$this->color_set($appointment['Appointment']['type'],$changed_status['status'],$colors);
                                            $color=$color_value['color'];
                                        }elseif($appointment['Appointment']['appointment_start_date']==$changed_status['date'] && !isset($tomorrow)){
                                            //echo $changed_status['status']; die;
                                            $color_value=$this->color_set($appointment['Appointment']['type'],$changed_status['status'],$colors);
                                            $color=$color_value['color'];
                                        }
                                    }
                                    //echo $color; die;
                                //die;
                                }
                                //die;
                                if(empty($in)){
                                    $toolTip=$this->admin_createToolTip($appointment['Appointment']['status'],$appointment['Appointment']['salon_staff_id']);
                                    $hoverTitle=$toolTip[1].' : '.$hoverTitleStart.'-'.$hoverTitleEnd.','.$toolTip[0];
                                    if($appointment['Appointment']['status']==3){
                                        $checkoutClass='checkout';
                                    }else{
                                        $checkoutClass='';
                                    }
                                    if($appointment['Appointment']['by_vendor']==0){
                                        $typeClass='front';
                                    }else{
                                        $typeClass='';
                                    }
                                    $appointments_json.='{
                                                id:'.$appointment['Appointment']['id'].',
                                                start: '.$start_date.',
                                                end:'.$end_date.',
                                                EndTimezone:null,
                                                title: "'.$appointment['Appointment']['appointment_title'].'",
                                                eventType: "'.$event_type.'",
                                                styleclass:"app-complete",
                                                checkoutclass:"'.$checkoutClass.'",
                                                typeclass:"'.$typeClass.'",
                                                description : "'.$appointment['Appointment']['appointment_comment'].'",
                                                employeeId: '.$appointment['Appointment']['salon_staff_id'].',
                                                treatmentId:'.$appointment['Appointment']['salon_service_id'].',
                                                hoverTitle:"'.$hoverTitle.'",
                                                RecurrenceRule:null,
                                                RecurrenceID:null,
                                                RecurrenceException:null,
                                                IsAllDay:false,
                                                colorVal: "'.$color.'",
                                                repeatclass:"fa fa-refresh",
                                                returnRequest:"'.$return_request.'",
                                                requestColor:"#000000",
                                                repeatImg:"/img/admin/CalendarImages.png"
                                            },';
                                }
                            }
                        }
                        
            /* Code for creating json of weekly repeating Appointments */                    
                        
                        elseif($appointment['Appointment']['appointment_repeat_type']==2){
                            $StartDate=date("Y-m-d",$appointment['Appointment']['appointment_start_date']);
                            $StartDate=strtotime($StartDate); 
                            $time=date("H:i", $appointment['Appointment']['appointment_start_date']);
                            $EndDate=date("Y-m-d",strtotime($end_date_time));
                            $end_time=date("H:i", strtotime($end_date_time));
                            $repeat_days_array=array('1'=>'sunday','2'=>'monday','3'=>'tuesday','4'=>'wednesday','5'=>'thrusday','6'=>'friday','7'=>'saturday');
                            for($i=1;$i<=count($repeat_days_array);$i++){
                                if($appointment['Appointment']['appointment_repeat_day']==$i){
                                    $week_day='next'.' '.$repeat_days_array[$i];
                                }
                            }
                            $str=strtotime($week_day .' '.$time, $appointment['Appointment']['appointment_start_date']);
                            $end=strtotime($week_day .' '.$end_time, $appointment['Appointment']['appointment_start_date']); 
                            $add_weeks=$appointment['Appointment']['appointment_repeat_weeks'];
                            $chk_day=date('N',$StartDate);
                            if($chk_day+1==$appointment['Appointment']['appointment_repeat_day']){
                                $str1= date("Y-m-d",$appointment['Appointment']['appointment_start_date']);
                                $str=strtotime($str1.' '.$time);
                                $end=strtotime($EndDate.' '.$end_time);
                            }
                            $j=0;
                            while(strtotime($appointment['Appointment']['appointment_repeat_end_date'])>=strtotime(date('Y-m-d',$StartDate))){
                                if($j==0){
                                    $d=date("d-m-y",$str);
                                    $e=date("d-m-y",$end);
                                    $hoverTitleStart=date('D-H:i A',$str);
                                    $start_date = 'new Date("'.date("Y/m/d H:i",$str).'")';
                                    $hoverTitleEnd=date('H:i A',$end);
                                    $week_end_date = 'new Date("'.date("Y/m/d H:i",$end).'")';
                                    $date=$str;
                                    $date_end=$end;
                                    $end_date=$week_end_date;
                                }
                                else{
                                    $d=date("d-m-Y",$str);
                                    $e=date("d-m-Y",$end);
                                    $date = strtotime(date("Y-m-d $time", strtotime($d)) . " +".$add_weeks." week");
                                    $date_in=$date;
                                    $dateEnd=strtotime(date("Y-m-d $end_time", strtotime($e)) . " +".$add_weeks." week");
                                    $hoverTitleStart=date('D-H:i A',$date);
                                    $start_date = 'new Date("'.date("Y/m/d H:i",$date).'")';
                                    $end_date = 'new Date("'.date("Y/m/d H:i",$dateEnd).'")';
                                    $hoverTitle=$start_date;
                                    $str=$date;
                                    $end=$dateEnd;
                                }
                                $StartDate=$date;
                                if(!empty($appointment['Appointment']['changed_status'])){
                                    $changed_status=unserialize(base64_decode($appointment['Appointment']['changed_status']));
                                    foreach($changed_status as $changed_status){
                                        if(isset($tomorrow)){
                                            $tomorrow = str_replace('/', '-', $tomorrow);
                                        }
                                        if(isset($tomorrow) && strtotime($tomorrow)==$changed_status['date']){
                                            $color_value=$this->color_set($appointment['Appointment']['type'],$changed_status['status'],$colors);
                                            $color=$color_value['color'];
                                        }
                                    }
                                }
                                if(!empty($appointment['Appointment']['exclude_dates'])){
                                    $app_dates=unserialize($appointment['Appointment']['exclude_dates']);
                                    if (in_array($date, $app_dates) || in_array($str, $app_dates)&& !isset($date_in)){
                                        $in='in';
                                    }
                                    elseif(isset($date_in) && in_array($date_in, $app_dates)){
                                        $in='in';
                                    }
                                    else{
                                        $in='';
                                    }
                                }
                                if(empty($in)){
                                   if(strtotime($appointment['Appointment']['appointment_repeat_end_date'])>=strtotime(date('Y-m-d',$StartDate))){
                                        $toolTip=$this->admin_createToolTip($appointment['Appointment']['status'],$appointment['Appointment']['salon_staff_id']);
                                    $hoverTitle=$toolTip[1].' : '.$hoverTitleStart.'-'.$hoverTitleEnd.','.$toolTip[0];
                                    if($appointment['Appointment']['status']==3){
                                        $checkoutClass='checkout';
                                    }else{
                                        $checkoutClass='';
                                    }
                                    if($appointment['Appointment']['by_vendor']==0){
                                        $typeClass='front';
                                    }else{
                                        $typeClass='';
                                    }
                                        $appointments_json.='{
                                            id:'.$appointment['Appointment']['id'].',
                                            start: '.$start_date.',
                                            end:'.$end_date.',
                                            title: "'.$appointment['Appointment']['appointment_title'].'",
                                            eventType: "'.$event_type.'",
                                            styleclass:"app-complete",
                                            checkoutclass:"'.$checkoutClass.'",
                                            typeclass:"'.$typeClass.'",
                                            description : "'.$appointment['Appointment']['appointment_comment'].'",
                                            employeeId: '.$appointment['Appointment']['salon_staff_id'].',
                                            treatmentId:'.$appointment['Appointment']['salon_service_id'].',
                                            hoverTitle:"'.$hoverTitle.'",
                                            RecurrenceRule:null,
                                            RecurrenceID:null,
                                            RecurrenceException:null,
                                            IsAllDay:false,
                                            colorVal: "'.$color.'",
                                            repeatclass:"fa fa-refresh",
                                            returnRequest:"'.$return_request.'",
                                            requestColor:"#000000",
                                            repeatImg:"/img/admin/CalendarImages.png"
                                        },';
                                    }
                                }
                                $j++;
                            } 
                        }
                
                /* Code for creating json of monthly repeating Appointments */               
                        
                        elseif($appointment['Appointment']['appointment_repeat_type']==3){
                            $StartDate=date("Y-m-d",$appointment['Appointment']['appointment_start_date']);
                            $StartDate= strtotime($StartDate);
                            $time=date("H:i", $appointment['Appointment']['appointment_start_date']);
                            $day=date("d", $appointment['Appointment']['appointment_start_date']);
                            $k=0;
                            while(strtotime($appointment['Appointment']['appointment_repeat_end_date'])>=strtotime(date('Y-m-d',$StartDate))){
                                if($k==0){
                                    if($appointment['Appointment']['appointment_repeat_month_date']>$day){
                                        $add_days= $appointment['Appointment']['appointment_repeat_month_date']-$day;
                                        $StartDate= date('Y-m-d',$appointment['Appointment']['appointment_start_date']);  
                                        $StartDate = date('Y-m-d',strtotime($StartDate . "+".$add_days."days")); 
                                        $StartDate=strtotime($StartDate.''.$time);
                                        $start_date= date("Y-m-d H:i", $StartDate);
                                    }elseif($appointment['Appointment']['appointment_repeat_month_date']==$day){
                                        $StartDate= date('Y-m-d',$appointment['Appointment']['appointment_start_date']); 
                                        $StartDate=strtotime($StartDate.''.$time);
                                        $start_date= date("Y-m-d H:i", $StartDate);
                                    }elseif($appointment['Appointment']['appointment_repeat_month_date']<$day){
                                        $add_days= $day-$appointment['Appointment']['appointment_repeat_month_date']; 
                                        $StartDate= date('Y-m-d',$appointment['Appointment']['appointment_start_date']); 
                                        $StartDate = date('Y-m-d',strtotime($StartDate . "-".$add_days."days"));
                                        $StartDate=strtotime($StartDate.''.$time);
                                        $start_date= date("Y-m-d H:i", $StartDate) . "+1 month";
                                    }
                                    $repeat_date=$start_date;
                                    $compare_date=$start_date;
                                    $start_day=strtotime($start_date);
                                    $hoverTitleStart=date('D-H:i A',strtotime($start_date));
                                    $start_date = 'new Date("'.date("Y/m/d H:i",strtotime($start_date)).'")';
                                }else{
                                    $start_day=date("Y-m-d", $start_day);
                                    $start_day=strtotime($start_day.' '.$time);
                                    $compare_date=$start_day;
                                    $start_day= strtotime(date("Y-m-d H:i", $start_day) . "+1 month");
                                    $start_day_in=$start_day;
                                    $hoverTitleStart=date('D-H:i A',$start_day);
                                    $start_date = 'new Date("'.date("Y/m/d H:i",$start_day).'")';
                                }
                                $endTime = date("H:i",strtotime("+".$minutes_to_add." minutes", strtotime($time)));
                                $end=date("Y/m/d",$start_day).' '.$endTime;
                                $hoverTitleEnd=date('H:m A',strtotime($start_day.' '.$endTime));
                                $end_date='new Date("'.date("Y/m/d",$start_day).' '.$endTime.'")';
                                $StartDate=$start_day;
                                if(!empty($appointment['Appointment']['changed_status'])){
                                    $changed_status=unserialize(base64_decode($appointment['Appointment']['changed_status']));
                                    foreach($changed_status as $changed_status){
                                        if(isset($tomorrow)){
                                            $tomorrow = str_replace('/', '-', $tomorrow);
                                        }
                                        if(isset($tomorrow) && strtotime($tomorrow)==$changed_status['date']){
                                            $color_value=$this->color_set($appointment['Appointment']['type'],$changed_status['status'],$colors);
                                            $color=$color_value['color'];
                                        }
                                    }
                                }
                                if(!empty($appointment['Appointment']['exclude_dates'])){
                                    $app_dates=unserialize($appointment['Appointment']['exclude_dates']);
                                    if (in_array($compare_date, $app_dates) && !isset($start_day_in)){
                                        $in='in';
                                    }
                                    elseif(isset($start_day_in) && in_array($start_day_in, $app_dates)){
                                        $in='in';
                                    }
                                    else{
                                        $in='';
                                    }
                                }
                                if(empty($in)){
                                    if(strtotime($appointment['Appointment']['appointment_repeat_end_date'])>=strtotime(date('Y-m-d',$StartDate))){
                                        $toolTip=$this->admin_createToolTip($appointment['Appointment']['status'],$appointment['Appointment']['salon_staff_id']);
                                        $hoverTitle=$toolTip[1].' : '.$hoverTitleStart.'-'.$hoverTitleEnd.','.$toolTip[0];
                                        if($appointment['Appointment']['status']==3){
                                           $checkoutClass='checkout';
                                        }else{
                                            $checkoutClass='';
                                        }
                                        if($appointment['Appointment']['by_vendor']==0){
                                            $typeClass='front';
                                        }else{
                                            $typeClass='';
                                        }
                                        $appointments_json.='{
                                            id:'.$appointment['Appointment']['id'].',
                                            start: '.$start_date.',
                                            end:'.$end_date.',
                                            EndTimezone:null,
                                            title: "'.$appointment['Appointment']['appointment_title'].'",  
                                            eventType: "'.$event_type.'",
                                            styleclass:"app-complete",
                                            checkoutclass:"'.$checkoutClass.'",
                                            typeclass:"'.$typeClass.'",
                                            description : "'.$appointment['Appointment']['appointment_comment'].'", 
                                            employeeId: '.$appointment['Appointment']['salon_staff_id'].',
                                            treatmentId:'.$appointment['Appointment']['salon_service_id'].',
                                            hoverTitle:"'.$hoverTitle.'",
                                            RecurrenceRule:null,
                                            RecurrenceID:null,
                                            RecurrenceException:null,
                                            IsAllDay:false,
                                            colorVal: "'.$color.'",
                                            repeatclass:"fa fa-refresh",
                                            returnRequest:"'.$return_request.'",
                                            requestColor:"#000000",
                                            repeatImg:"/img/admin/CalendarImages.png"
                                        },';
                                    }
                                }
                                $k++;
                            }
                        }
                    
                    /* Code for creating json of yearly repeating Appointments */            
                        elseif($appointment['Appointment']['appointment_repeat_type']==4){
                            $StartDate=date("Y-m-d",$appointment['Appointment']['appointment_start_date']);  
                            $StartDate=strtotime($StartDate);
                            $time=date("H:i", $appointment['Appointment']['appointment_start_date']);
                            $day=$appointment['Appointment']['appointment_yearly_repeat_month_date']; 
                            $month=date("m", $appointment['Appointment']['appointment_start_date']);
                            $year=date("Y", $appointment['Appointment']['appointment_start_date']);  
                            $h=0;
                            while(strtotime($appointment['Appointment']['appointment_repeat_end_date'])>=strtotime(date('Y-m-d',$StartDate))){ 
                                if($h==0){
                                    if( ($month<=$appointment['Appointment']['appointment_repeat_month'])){
                                        $repeat_date=$day.'-'.$appointment['Appointment']['appointment_repeat_month'].'-'.$year; 
                                    }
                                    else{
                                        $year=$year+1;
                                        $repeat_date=$day.'-'.$appointment['Appointment']['appointment_repeat_month'].'-'.$year; 
                                    }
                                    $start_date=$repeat_date.''.$time;
                                    $start_day=strtotime($repeat_date.''.$time);
                                    $hoverTitleStart=date('D-H:i A',strtotime($start_date));
                                    $start_date = 'new Date("'.date("Y/m/d H:i",strtotime($start_date)).'")';
                                }
                                else{
                                    $start_day=date("Y-m-d", $start_day);
                                    $start_day=strtotime($start_day.' '.$time);
                                    $start_day= strtotime(date("Y-m-d H:i", $start_day) . "+1 years");
                                    $start_day_year_in=$start_day;
                                    $hoverTitleStart=date('D-H:i A',$start_day);
                                    $start_date = 'new Date("'.date("Y/m/d H:i",$start_day).'")';
                                }
                                $endTime = date("H:i",strtotime("+".$minutes_to_add." minutes", strtotime($time)));
                                $end=date("Y/m/d",$start_day).' '.$endTime;
                                $hoverTitleEnd=date('H:m A',strtotime($end));
                                $hoverTitle=$hoverTitleStart.'-'.$hoverTitleEnd;
                                $end_date='new Date("'.date("Y/m/d",$start_day).' '.$endTime.'")';
                                $StartDate=$start_day;
                                if(!empty($appointment['Appointment']['changed_status'])){
                                    $changed_status=unserialize(base64_decode($appointment['Appointment']['changed_status']));
                                    foreach($changed_status as $changed_status){
                                        if(isset($tomorrow)){
                                            $tomorrow = str_replace('/', '-', $tomorrow);
                                        }
                                        if(isset($tomorrow) && strtotime($tomorrow)==$changed_status['date']){
                                            $color_value=$this->color_set($appointment['Appointment']['type'],$changed_status['status'],$colors);
                                            $color=$color_value['color'];
                                        }
                                    }
                                }
                                $app_dates=unserialize($appointment['Appointment']['exclude_dates']);
                                if(!empty($appointment['Appointment']['exclude_dates'])){
                                    $app_dates=unserialize($appointment['Appointment']['exclude_dates']);
                                    if (in_array($appointment['Appointment']['appointment_start_date'], $app_dates) && !isset($start_day_year_in)){
                                        $in='in';
                                    }
                                    elseif(isset($start_day_year_in) && in_array($start_day_year_in, $app_dates)){
                                        $in='in';
                                    }
                                    else{
                                        $in='';
                                    }
                                }
                                if(empty($in)){
                                    if(strtotime($appointment['Appointment']['appointment_repeat_end_date'])>=strtotime(date('Y-m-d',$StartDate))){
                                        $hoverTitleStart=date('D-H:i A',$appointment['Appointment']['appointment_start_date']);
                                        $hoverTitleEnd=date('H:m A',strtotime($end_date_time));
                                        $toolTip=$this->admin_createToolTip($appointment['Appointment']['status'],$appointment['Appointment']['salon_staff_id']);
                                        $hoverTitle=$toolTip[1].' : '.$hoverTitleStart.'-'.$hoverTitleEnd.','.$toolTip[0];
                                        if($appointment['Appointment']['status']==3){
                                            $checkoutClass='checkout';
                                        }else{
                                            $checkoutClass='';
                                        }
                                        if($appointment['Appointment']['by_vendor']==0){
                                        $typeClass='front';
                                    }else{
                                        $typeClass='';
                                    }
                                        $appointments_json.='{
                                            id:'.$appointment['Appointment']['id'].',
                                            start: '.$start_date.',
                                            end:'.$end_date.',
                                            EndTimezone:null,
                                            title: "'.$appointment['Appointment']['appointment_title'].'",  
                                            eventType: "'.$event_type.'",
                                            styleclass:"app-complete",
                                            checkoutclass:"'.$checkoutClass.'",
                                            typeclass:"'.$typeClass.'",
                                            description : "'.$appointment['Appointment']['appointment_comment'].'",
                                            employeeId: '.$appointment['Appointment']['salon_staff_id'].',      
                                            treatmentId:'.$appointment['Appointment']['salon_service_id'].',
                                            hoverTitle:"'.$hoverTitle.'",
                                            RecurrenceRule:null,
                                            RecurrenceID:null,
                                            RecurrenceException:null,
                                            IsAllDay:false,
                                            colorVal: "'.$color.'",
                                            repeatclass:"fa fa-refresh",
                                            returnRequest:"'.$return_request.'",
                                            requestColor:"#000000",
                                            repeatImg:"/img/admin/CalendarImages.png"
                                        },';
                                    }
                                }
                                $h++;
                            }
                        }
                        
                    /* Code for creating json of waiting Appointments */
                    
                        else if($appointment['Appointment']['type']=='W'){
                            $waiting_array=unserialize($appointment['Appointment']['waiting_appointments']);
                            for($i=0;$i<count($waiting_array);$i++){
                                $start_waiting_date=$waiting_array[$i];
                                $start_date = 'new Date("'.date("Y/m/d H:i",$start_waiting_date).'")';
                                $minutes_to_add = $appointment['Appointment']['appointment_duration'];
                                $time = new DateTime(date("Y/m/d H:i",$start_waiting_date));
                                $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                                $end_date_time = $time->format('Y/m/d H:i');
                                $end_date='new Date("'.$end_date_time.'")';
                                $startTitleString= $start_waiting_date;
                                $hoverTitleStart=date('D-H:i A',$appointment['Appointment']['appointment_start_date']);
                                $hoverTitleEnd=date('H:m A',strtotime($end_date_time));
                                $toolTip=$this->admin_createToolTip($appointment['Appointment']['status'],$appointment['Appointment']['salon_staff_id']);
                                $hoverTitle=$toolTip[1].' : '.$hoverTitleStart.'-'.$hoverTitleEnd.','.$toolTip[0];
                                if($appointment['Appointment']['status']==3){
                                        $checkoutClass='checkout';
                                }else{
                                        $checkoutClass='';
                                }
                                if($appointment['Appointment']['by_vendor']==0){
                                        $typeClass='front';
                                    }else{
                                        $typeClass='';
                                    }
                                $appointments_json.='{
                                    id:'.$appointment['Appointment']['id'].',
                                    start: '.$start_date.',
                                    end:'.$end_date.',
                                    EndTimezone:null,
                                    title: "'.$appointment['Appointment']['appointment_title'].'",
                                    eventType: "'.$event_type.'",
                                    styleclass:"the-waiting",
                                    checkoutclass:"'.$checkoutClass.'",
                                    typeclass:"'.$typeClass.'",
                                    description : "'.$appointment['Appointment']['appointment_comment'].'",
                                    employeeId: '.$appointment['Appointment']['salon_staff_id'].',
                                    treatmentId:'.$appointment['Appointment']['salon_service_id'].',
                                    hoverTitle:"'.$hoverTitle.'",
                                    RecurrenceRule:null,
                                    RecurrenceID:null,
                                    RecurrenceException:null,
                                    IsAllDay:false,
                                    colorVal: "'.$color.'",
                                    repeatclass:"fa fa-refresh",
                                    returnRequest:"'.$return_request.'",
                                    requestColor:"#000000",
                                    repeatImg:"/img/admin/CalendarImages.png"
                                },';
                            }
                        }
                        
                /* Code for creating json of Appointments */
                        else{
                            $startTitleString= $appointment['Appointment']['appointment_start_date'];
                            $endTitleString=strtotime($end_date_time);
                            $hoverTitleStart=date('D-H:i A',$appointment['Appointment']['appointment_start_date']);
                            $hoverTitleEnd=date('H:i A',strtotime($end_date_time));
                            $toolTip=$this->admin_createToolTip($appointment['Appointment']['status'],$appointment['Appointment']['salon_staff_id']);
                            $hoverTitle=$toolTip[1].' : '.$hoverTitleStart.'-'.$hoverTitleEnd.','.$toolTip[0];
                            if($appointment['Appointment']['status']==3){
                                        $checkoutClass='checkout';
                            }else{
                                $checkoutClass='';
                            }
                            if($appointment['Appointment']['by_vendor']==0){
                                        $typeClass='front';
                                    }else{
                                        $typeClass='';
                                    }
                            $appointments_json.='{
                                 id:'.$appointment['Appointment']['id'].',
                                 start: '.$start_date.',
                                 end:'.$end_date.',
                                 title: "'.$appointment['Appointment']['appointment_title'].'",
                                 eventType: "'.$event_type.'",
                                 styleclass:"app-complete",
                                 checkoutclass:"'.$checkoutClass.'",
                                 typeclass:"'.$typeClass.'",
                                 description : "'.$appointment['Appointment']['appointment_comment'].'",
                                 employeeId: '.$appointment['Appointment']['salon_staff_id'].',
                                 treatmentId:'.$appointment['Appointment']['salon_service_id'].',
                                 hoverTitle:"'.$hoverTitle.'",
                                 RecurrenceRule:null,
                                 RecurrenceID:null,
                                 RecurrenceException:null,
                                 IsAllDay:false,
                                 colorVal: "'.$color.'",
                                 repeatclass:"",
                                 returnRequest:"'.$return_request.'",
                                 requestColor:"#000000",
                                 repeatImg:"/img/admin/CalendarImages.png"
                             },'; 
                        }
                    } 
                }
                if(isset($appointments_json)){
                    $appointments_json = rtrim($appointments_json, ",");
                    $appointments_json .= ']';
                }
                else{
                    $appointments_json='[{
                        id: 1,
                        start: new Date("2015/3/24 09:00"),
                        end: new Date("2015/3/24 10:00"),
                        title: "Interview",
                        eventType: "the-appointment",
                        styleclass:"app-complete",
                        description : "Meeting",
                        employeeId: 2,
                        treatmentId:358,
                        hoverTitle:"test",
                        RecurrenceRule:null,
                        RecurrenceID:null,
                        RecurrenceException:null,
                        IsAllDay:false,
                        colorVal: "#f15f24",
                        repeatImg:"/img/admin/CalendarImages.png"
                    }]';
                }
            //  pr($appointments_json); die;
                $fullData['appointments'] = $appointments_json;
                $treatmentFilter = '[';
                if(!empty($services)){
                    foreach($services as $forTreatment){
                        if(!empty($forTreatment)){
                            foreach($forTreatment as $treatId =>$theTreatment){
                                $treatmentFilter .= '{ field: "treatmentId", operator: "eq", value: '.$treatId.'},';
                            }
                        }
                    }
                }
                $treatmentFilter = rtrim($treatmentFilter, ",");
                $treatmentFilter .= ']';
                $fullData['treatfilter'] = $treatmentFilter;
                $fullData['openHours'] = json_encode($openingHours);
            }
        }
        return $fullData;
    }
    
/**********************************************************************************    
  @Function Name : admin_addAppointment
  @Params	 : NULL
  @Description   : The Function to add appointment
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/

    public function admin_addAppointment($time=NULL,$employeeId = NULL,$eventId = NULL,$editType=NULL) {
        if($this->request->is('post') || $this->request->is('put')){
	    $salonUserId= $this->Auth->user('id');
	    $this->request->data['Appointment']['salon_id'] = $salonUserId;
            $field=array();
            $field=array('fieldList'=>array('salon_service_id','startdate','time','user_id','appointment_price','appointment_duration','appointment_return_request'));
            if(isset($this->data['Appointment']['appointment_repeat_type']) && $this->data['Appointment']['appointment_repeat_type']!=0){
                $field['fieldList'][]='appointment_repeat_end_date';
                if($this->data['Appointment']['appointment_repeat_type'] == 2){
                    $field['fieldList'][]='appointment_repeat_weeks';
                    $field['fieldList'][]='appointment_repeat_day';
                }
                if($this->data['Appointment']['appointment_repeat_type'] == 3){
                    $field['fieldList'][]='appointment_repeat_month_date';
                }
                if($this->data['Appointment']['appointment_repeat_type'] == 4){
                    $field['fieldList'][]='appointment_yearly_repeat_month_date';
                }
            }
            $errors=array();
            $this->request->data['Appointment']['appointment_price'] = $this->request->data['Appointment']['price_'.$this->data['Appointment']['check']];
            $this->request->data['Appointment']['appointment_duration'] = $this->request->data['Appointment']['duration_'.$this->data['Appointment']['check']];
            $this->Appointment->set($this->request->data);
            if($this->Appointment->validates($field)){   
                $this->loadModel('SalonService');
                $userId=base64_decode($this->request->data['Appointment']['user_id']);
                $this->loadmodel('User');
                $salon_service_id=$this->data['Appointment']['salon_service_id'];
                $service_name=$this->SalonService->find('first',array('fields'=>array('eng_display_name','eng_name','service_id'),'conditions'=>array('SalonService.id'=>$salon_service_id)));
                if($service_name['SalonService']['eng_name']!=''){
                    $salon_service_name=$service_name['SalonService']['eng_name'];
                }
                else{
                    $this->loadModel('Service');
                    $salon_service_name_by_service_id=$this->Service->find('first',array('fields'=>array('eng_display_name','eng_name'),'conditions'=>array('Service.id'=>$service_name['SalonService']['service_id'])));
                    $salon_service_name = $salon_service_name_by_service_id['Service']['eng_name'];
                }
                $customeName=$this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
                $theCustomerName = $customeName['User']['first_name'].' '.$customeName['User']['last_name'];
                $checked=$this->request->data['Appointment']['check'];
                $appointment_title = $theCustomerName.'-'.$salon_service_name;
                $this->request->data['Appointment']['appointment_title']=$appointment_title;
                $this->request->data['Appointment']['by_vendor']=1;
                $this->request->data['Appointment']['user_id']=$userId;
                $this->request->data['Appointment']['appointment_price']=$this->request->data['Appointment']['price_'.$checked];
                $this->request->data['Appointment']['appointment_duration']=$this->request->data['Appointment']['duration_'.$checked];
                
                if(isset($editType) && $editType!='series'){
                    $this->request->data['Appointment']['startdate'] = str_replace('/', '-', $this->request->data['Appointment']['startdate']);
                    $this->request->data['Appointment']['appointment_start_date']= strtotime($this->request->data['Appointment']['startdate'].' '.$this->request->data['Appointment']['time']);
                }
                if($eventId==''){
                    $this->request->data['Appointment']['startdate'] = str_replace('/', '-', $this->request->data['Appointment']['startdate']);
                    $this->request->data['Appointment']['appointment_start_date']= strtotime($this->request->data['Appointment']['startdate'].' '.$this->request->data['Appointment']['time']);
                    $startTime=$this->request->data['Appointment']['appointment_start_date'];
                    $this->request->data['Appointment']['points_redeem']=$this->request->data['Appointment']['points_redeem_'.$checked];
                $this->request->data['Appointment']['points_given']=$this->request->data['Appointment']['points_given_'.$checked];
                }
                base64_decode($this->request->data['Appointment']['user_id']);
                $this->request->data['Appointment']['created']=date('Y-m-d h:i:s');
                if(isset($this->request->data['Appointment']['appointment_repeat_type']) && $this->request->data['Appointment']['appointment_repeat_type']>0){
                    $this->request->data['Appointment']['appointment_repeat_end_date'] = str_replace('/', '-', $this->request->data['Appointment']['appointment_repeat_end_date']);
                    $this->request->data['Appointment']['appointment_repeat_end_date']=date('Y/m/d',strtotime($this->request->data['Appointment']['appointment_repeat_end_date']));
                }
                if(isset($eventId) && $eventId!=''){
		    
                    if($editType=='series'){
                        $fetch_start_date=$this->Appointment->find('first',array(
                                                            'fields'=>array('appointment_start_date'),
                                                            'conditions'=>array('Appointment.id'=>$eventId)));
                        $this->request->data['Appointment']['startdate']=date('d-m-Y', $fetch_start_date['Appointment']['appointment_start_date']);
                        $startTime=strtotime($this->request->data['Appointment']['startdate'].' '.$this->request->data['Appointment']['time']);
                    }else{
                        $this->request->data['Appointment']['startdate'] = str_replace('/', '-', $this->request->data['Appointment']['startdate']);
                    $startTime= strtotime($this->request->data['Appointment']['startdate'].' '.$this->request->data['Appointment']['time']);
                    }
                    $this->admin_editOneorMutipleAppointments($eventId,$editType,$employeeId,$startTime,$time);
                }
                $this->request->data['Appointment']['status']=1;
                $staff_id=$this->request->data['Appointment']['salon_staff_id'];
                if($this->Appointment->save($this->request->data['Appointment'],false)){
		    $record_id=$this->Appointment->id;
		    $appointment_history['AppointmentHistory']['appointment_id']=$record_id;
                    $appointment_history['AppointmentHistory']['appointment_date']=strtotime(date('Y-m-d h:i:s'));
                    $appointment_history['AppointmentHistory']['type']='admin';
                    $appointment_history['AppointmentHistory']['service_name']=$salon_service_name;
                    $appointment_history['AppointmentHistory']['staff_id']=$staff_id;
                    $appointment_history['AppointmentHistory']['duration']=$this->request->data['Appointment']['duration_'.$checked];
                    $appointment_history['AppointmentHistory']['modified_by']=$this->Auth->user('id');
                    $appointment_history['AppointmentHistory']['modified_date']=strtotime(date('Y-m-d h:i:s'));
                    $appointment_history['AppointmentHistory']['status']='Created';
                    $appointment_history['AppointmentHistory']['action']='Created';
                    $this->admin_saveAppointmentHistory($appointment_history);
                    $this->admin_notify_customer($appointment_title,$userId,$salon_service_name,$startTime,$this->request->data['Appointment']['duration_'.$checked],'add_appointment','customer');
                    
                   $this->admin_notify_customer($appointment_title,$staff_id,$salon_service_name,$startTime,$this->request->data['Appointment']['duration_'.$checked],'add_appointment','staff');
                    
                    $this->admin_notify_customer($appointment_title,$this->Auth->user('id'),$salon_service_name,$startTime,$this->request->data['Appointment']['duration_'.$checked],'add_appointment','provider');
                    /***** Mail to Booking Incharge*****/
                    
                    $staff = $this->Common->get_salon_staff($this->Auth->user('id'));
                    $this->loadModel('UserDetail');
                    for($st=0;$st<count($staff);$st++){
                        $booking_incharge=$this->UserDetail->find('first',array('fields'=>array('user_id','booking_incharge'),'conditions'=>array('UserDetail.user_id'=>$staff[$st]['User']['id'])));
                        if($booking_incharge['UserDetail']['booking_incharge']==1){
                            $this->admin_notify_customer($appointment_title,$staff[$st]['User']['id'],$salon_service_name,$startTime,$this->request->data['Appointment']['duration_'.$checked],'add_appointment','staff');   
                        }
                        
                    }
                    $this->admin_add_appointment_slots($record_id,$this->request->data['Appointment']['appointment_start_date'],$this->data['Appointment']['appointment_duration'],$this->data['Appointment']['salon_id'],$this->data['Appointment']['appointment_repeat_type'],$this->data['Appointment']['appointment_repeat_end_date'],$this->data['Appointment']['appointment_repeat_day'],$this->data['Appointment']['appointment_repeat_weeks'],$this->data['Appointment']['appointment_repeat_month_date'],$this->data['Appointment']['appointment_yearly_repeat_month_date'],$this->data['Appointment']['appointment_repeat_month']);
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('Appointment added successfully',true);
                    echo json_encode($edata);
                    die;    
                }else{
                    $message = __('Unable to add appointment, Please try again.', true);
                    $vError = $this->Appointment->validationErrors;
                    if(!empty($vError['appointment_price']) && isset($vError['appointment_price'])){
                        $vError['price_'.$this->data['Appointment']['check']] = $vError['appointment_price'];
                    }
                    if(!empty($vError['appointment_duration']) && isset($vError['appointment_duration'])){
                        $vError['duration_'.$this->data['Appointment']['check']] = $vError['appointment_duration'];
                    }
                    $edata['data'] =$vError;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
                }
            }
            else{
                $message = __('Unable to add appointment, Please try again.', true);
                $vError = $this->Appointment->validationErrors;
                if(!empty($vError['appointment_price']) && isset($vError['appointment_price'])){
                    $vError['price_'.$this->data['Appointment']['check']] = $vError['appointment_price'];
                }
                if(!empty($vError['appointment_duration']) && isset($vError['appointment_duration'])){
                    $vError['duration_'.$this->data['Appointment']['check']] = $vError['appointment_duration'];
                }
                $edata['data'] =$vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        $this->loadModel('User');
        App::import('Controller', 'Users');
        $this->Users = new UsersController;
        $this->layout = 'ajax';
        $staffServices = $this->Common->getStaffServiceList($employeeId, $this->Auth->user('id'));
        $userList = $this->Users->findallCustomerList();
        $this->loadModel('SalonCalendarSetting');
        $calendorsettings = $this->SalonCalendarSetting->find('first',array('conditions'=>array('SalonCalendarSetting.user_id'=>$this->Auth->user('id'))));
        if(empty($calendorsettings)){
            $calendorsettings = $this->SalonCalendarSetting->find('first',array('conditions'=>array('SalonCalendarSetting.user_id'=>1)));
        }
        if(isset($eventId) && $eventId!=''){
            $edit_appointment=$this->Appointment->find('first',array('conditions'=>array('Appointment.id'=>$eventId)));
            $price_duration=$this->admin_fetch_price_and_duration($edit_appointment['Appointment']['salon_service_id'],$edit_appointment['Appointment']['salon_staff_id'],'edit');
            $user=$this->Users->admin_manage(base64_encode($edit_appointment['Appointment']['user_id']),'','edit');
	    
	    $totalappcancellation = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$user['User']['id'],'Appointment.status'=>5)));
	    $totalpackagecancellation = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$userId,'Appointment.status'=>5,'Appointment.package_id !='=>0),'group' => array('Appointment.package_id')));
	    $totalcancellation=$totalappcancellation+$totalpackagecancellation;
	    $totalnoShow = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$user['User']['id'],'Appointment.status'=>8)));
         $this->set(compact('totalcancellation','totalnoShow'));
		    
		    
		    
	    
	    
            $edit_personal_appointment=$edit_appointment;
            $this->set(compact('edit_appointment','price_duration','user','edit_personal_appointment','editType'));
            if(!$this->request->data){
                $this->request->data = $edit_appointment;
            }
        }
        $employee[$employeeId]=$employeeId;
        $open_close_hours=$this->admin_get_calender_open_close_time($employee);
        $staff_name=$edit_appointment=$this->User->find('first',array('conditions'=>array('User.id'=>$employeeId),'fields'=>array('id','first_name','last_name')));
        $staffname = $staff_name['User']['first_name'].' '.$staff_name['User']['last_name'];
        $staffID = $staff_name['User']['id'];
        $this->set(compact('time','staffServices','userList','employeeId','calendorsettings','staffname','editType','open_close_hours','staffID'));
    }
    
/**********************************************************************************    
  @Function Name : admin_addPersonaltask
  @Params	 : NULL
  @Description   : The Function to add Personal Tasks
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_addPersonaltask($time=NULL,$open_hours=NULL,$close_hours=NULL,$employeeId = NULL,$eventId = NULL) {
        if($this->request->is('post') || $this->request->is('put')){
            $field=array();
            if($this->request->data['Appointment']['whole_day_off']!=1){
                $field=array('fieldList'=>array('time','endtime'));
            }
            $errorArray = array();
            if(isset($this->data['Appointment']['appointment_repeat_type']) && $this->data['Appointment']['appointment_repeat_type']>0){
                if(isset($eventId) && $eventId!='' && isset($this->request->data['Appointment']['occur']) && $this->request->data['Appointment']['occur']!='only'){
                    $field['fieldList'][]='appointment_repeat_end_date';
                    if($this->data['Appointment']['appointment_repeat_type'] == 2){
                        $field['fieldList'][]='appointment_repeat_weeks';
                        $field['fieldList'][]='appointment_repeat_day';
                    }
                    if($this->data['Appointment']['appointment_repeat_type'] == 3){
                        $field['fieldList'][]='appointment_repeat_month_date';
                    }
                    if($this->data['Appointment']['appointment_repeat_type'] == 4){
                        $field['fieldList'][]='appointment_yearly_repeat_month_date';
                    }
                }
            }else{
               unset($this->request->data['Appointment']['appointment_repeat_end_date']); 
            }
            $this->Appointment->set($this->request->data);
            if( $this->Appointment->validates($field)){
                $this->loadModel('SalonService');
                $this->request->data['Appointment']['date'] = str_replace('/', '-', $this->request->data['Appointment']['date']);
                $this->request->data['Appointment']['date'] =date('Y-m-d', strtotime($this->request->data['Appointment']['date']));
                $startTime=strtotime($this->request->data['Appointment']['date'].' '.$this->request->data['Appointment']['time']);
                $start=$this->data['Appointment']['time'];
                $end=$this->data['Appointment']['endtime'];
                $d1=  strtotime($this->request->data['Appointment']['date'].' '.$start);
                $d2=  strtotime($this->request->data['Appointment']['date'].' '.$end);
                $duration = abs($d1 - $d2) / 60; 
                $this->request->data['Appointment']['appointment_duration']=$duration;
                $this->request->data['Appointment']['appointment_start_date']=$startTime;
                $this->request->data['Appointment']['user_id']=$employeeId;
                $this->request->data['Appointment']['status']=1;
                $this->request->data['Appointment']['type']='P';
                if(isset($this->request->data['Appointment']['appointment_repeat_type']) && $this->request->data['Appointment']['appointment_repeat_type']>0){
                    $this->request->data['Appointment']['appointment_repeat_end_date'] = str_replace('/', '-', $this->request->data['Appointment']['appointment_repeat_end_date']);
                    $this->request->data['Appointment']['appointment_repeat_end_date']=date('Y/m/d',strtotime($this->request->data['Appointment']['appointment_repeat_end_date']));
                }
                $this->request->data['Appointment']['created']=date('Y-m-d h:m:s');
                if($this->request->data['Appointment']['whole_day_off']==1){
                    $date=$this->request->data['Appointment']['date'];
                    $date = str_replace('/', '-', $date);
                    $date =date('Y-m-d', strtotime($date));
                    $openTime=date('H:i',$open_hours);
                    $closeTime=date('H:i',$close_hours);
                    $open_time=strtotime($date.' '.$openTime); 
                    $close_time=strtotime($date.' '.$closeTime);
                    $diff=round(abs($close_time - $open_time) / 60,2);
                    $this->request->data['Appointment']['appointment_start_date']=$open_time;
                    $this->request->data['Appointment']['appointment_duration']=$diff;
                }
                if(isset($eventId) && $eventId!=''){
                    if(isset($this->request->data['Appointment']['occur']) && $this->request->data['Appointment']['occur']=='only'){
                        $fetch_exclude_dates=$this->Appointment->find('first',array(
                                                            'fields'=>array('exclude_dates'),
                                                            'conditions'=>array('Appointment.id'=>$eventId)));
                        if(count($fetch_exclude_dates)>0 && !empty($fetch_exclude_dates['Appointment']['exclude_dates'])){
                            $unserial=unserialize ($fetch_exclude_dates['Appointment']['exclude_dates']);
                            $unserial[]=strtotime($this->request->data['Appointment']['date'].' '.$this->request->data['Appointment']['time'] );
                            $ser_array['Appointment']['exclude_dates']=serialize($unserial);
                            $ser_array['Appointment']['user_id']=$employeeId;
                            $ser_array['Appointment']['id']=$eventId;
                            $this->Appointment->save($ser_array);
                        }else{
                            $exclude_dates[]=$startTime;
                            $ser_array['Appointment']['exclude_dates'] = serialize($exclude_dates);
                            $ser_array['Appointment']['user_id']=$employeeId;
                            $ser_array['Appointment']['id']=$eventId;
                            $this->Appointment->save($ser_array);
                        }
                        $addNoRepeatAppointment=$this->request->data;
                        $addNoRepeatAppointment['Appointment']['appointment_repeat_type']=0;
                        $this->Appointment->save($addNoRepeatAppointment);
                        unset($this->request->data['Appointment']['appointment_title']);
                        unset($this->request->data['Appointment']['appointment_start_date']);
                        unset($this->request->data['Appointment']['appointment_comment']);
                        unset($this->request->data['Appointment']['appointment_duration']);
                        unset($this->request->data['Appointment']['appointment_repeat_end_date']);
                        $this->request->data['Appointment']['id']=$eventId;
                        if($this->Appointment->save($this->request->data['Appointment'])){
                            $edata['data'] = 'success' ;
                            $edata['message'] = __('Appointment updated successfully',true);
                            echo json_encode($edata);
                            die;    
                        }
                    }
                    else{
                        $this->request->data['Appointment']['id']=$eventId;
                        if($this->Appointment->save($this->request->data['Appointment'])){
                            $edata['data'] = 'success' ;
                            $edata['message'] = __('Personal Task has been updated successfully',true);
                            echo json_encode($edata);
                            die;    
                        }   
                    }   
                }
                else{
                    if($this->Appointment->save($this->request->data['Appointment'],false)){
                        $edata['data'] = 'success' ;
                        $edata['message'] = __('Personal Task has been added successfully',true);
                        echo json_encode($edata);
                        die;    
                    }
                }
            }
            else{
                $message = __('Unable to add personal task, Please try again.', true);
                $vError = $this->Appointment->validationErrors;
                $edata['data'] =$vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        $this->loadModel('User');
        App::import('Controller', 'Users');
        $this->Users = new UsersController;
        $this->layout = 'ajax';
        if(isset($eventId) && $eventId!=''){
           $edit_personal_appointment=$this->Appointment->find('first',array('conditions'=>array('Appointment.id'=>$eventId)));
           $this->set(compact('edit_personal_appointment'));
        }
        $employee[$employeeId]=$employeeId;
        $open_close_hours=$this->admin_get_calender_open_close_time($employee);
        $staff_name=$edit_appointment=$this->User->find('first',array('conditions'=>array('User.id'=>$employeeId),'fields'=>array('first_name','last_name')));
        $staffname = $staff_name['User']['first_name'].' '.$staff_name['User']['last_name']; 
        $staffServices = $this->Common->getStaffServiceList($employeeId, $this->Auth->user('id'));
        $userList = $this->Users->findallCustomerList();
        $this->set(compact('time','staffServices','userList','employeeId','staffname','open_close_hours'));
    }

/**********************************************************************************    
  @Function Name : admin_addWaitingtask
  @Params	 : NULL
  @Description   : The Function to add Waiting Tasks
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_addWaitingtask($time=NULL,$employeeId = NULL,$eventId=NULL) {
        if($this->request->is('post') || $this->request->is('put')){
            $errorArray = array();
            if($this->data['Appointment']['salon_service_id']==''){
                    $errorArray['salon_service_id'][] = "Provider Must be Selected";
            }
            for($i=1;$i<=4;$i++){
                if(isset($this->data['Appointment']['startdate'.$i]) && isset($this->data['Appointment']['time'.$i]) && $this->data['Appointment']['startdate'.$i]!='' && $this->data['Appointment']['time'.$i]==''){
                    $errorArray['time'.$i][] = "Please Select Time";
                }
                if(isset($this->data['Appointment']['startdate'.$i]) && isset($this->data['Appointment']['time'.$i]) && $this->data['Appointment']['startdate'.$i]=='' && $this->data['Appointment']['time'.$i]!=''){
                $errorArray['time'.$i][] = "Please Select Date";
                }
            }
            if($this->data['Appointment']['user_id']==''){
                $errorArray['user_id'][] = "Please Select Customer";
            }
            if(count($errorArray)>0){
                $edata['data'] = $errorArray;
                $edata['message'] = __('Error',true);
                echo json_encode($edata);       
                die;
            }
            $StrtoTimeArray=array();
             if(isset($this->data['Appointment']['startdate']) && $this->data['Appointment']['time'] && $this->data['Appointment']['startdate']!='' && $this->data['Appointment']['time']!=''){
                $this->request->data['Appointment']['startdate'] = str_replace('/', '-', $this->request->data['Appointment']['startdate']);
                    $StrtoTimeArray[]=strtotime($this->request->data['Appointment']['startdate'].$this->request->data['Appointment']['time']);
             }
            for($i=1;$i<=4;$i++){
                if(isset($this->data['Appointment']['startdate'.$i]) && $this->data['Appointment']['time'.$i]){
                    $this->request->data['Appointment']['startdate'.$i] = str_replace('/', '-', $this->request->data['Appointment']['startdate'.$i]);
                    $StrtoTimeArray[]=strtotime($this->data['Appointment']['startdate'.$i].$this->data['Appointment']['time'.$i]);  
                }
            }
            $StrtoTime = serialize($StrtoTimeArray);
            $checked=$this->request->data['Appointment']['check'];
            $this->request->data['Appointment']['appointment_price']=$this->request->data['Appointment']['price_'.$checked];
            $this->request->data['Appointment']['appointment_duration']=$this->request->data['Appointment']['duration_'.$checked];
            $this->loadModel('SalonService');
            $service_name = $this->SalonService->find('threaded', array('conditions' => array('SalonService.is_deleted' => 0, 'SalonService.salon_id' => $this->Auth->user('id')), 'order' => array('SalonService.service_order')));
            $salon_staff_id=base64_decode($this->request->data['Appointment']['user_id']);
            $this->loadmodel('User');
            $salon_service_id=$this->data['Appointment']['salon_service_id'];
            $service_name=$this->SalonService->find('first',array(
                                                    'fields'=>array('eng_display_name','eng_name','service_id'),
                                                    'conditions'=>array('SalonService.id'=>$salon_service_id)));
            if($service_name['SalonService']['eng_display_name']!=''){
                    $salon_service_name=$service_name['SalonService']['eng_display_name'];
                }
            elseif($service_name['SalonService']['eng_name']!=''){
                $salon_service_name=$service_name['SalonService']['eng_name'];
                }
            else{
                $this->loadModel('Service');
                $salon_service_name_by_service_id=$this->Service->find('first',array(
                                'fields'=>array('eng_display_name','eng_name'),
                                'conditions'=>array('Service.id'=>$service_name['SalonService']['service_id'])));
                    if($salon_service_name_by_service_id['Service']['eng_display_name']!=''){
                        $salon_service_name=$salon_service_name_by_service_id['Service']['eng_display_name'];
                    }
                    else{
                        $salon_service_name=$salon_service_name_by_service_id['Service']['eng_name'];
                    }
                }
            $employee_name=$this->User->find('first',array('conditions'=>array('User.id'=>$salon_staff_id)));
            $customer_name=$employee_name['User']['first_name'].' '.$employee_name['User']['last_name'];
            $appointment_title=$customer_name.'-'.$salon_service_name;
            $this->request->data['Appointment']['appointment_title']=$appointment_title;
            $this->request->data['Appointment']['salon_staff_id']=$employeeId;
            $this->request->data['Appointment']['user_id']=base64_decode($this->request->data['Appointment']['user_id']);;
            $this->request->data['Appointment']['appointment_start_date']=strtotime($this->request->data['Appointment']['startdate'].' '.$this->request->data['Appointment']['time']);
            $this->request->data['Appointment']['waiting_appointments']=$StrtoTime;
             $this->request->data['Appointment']['type']='W';
            $this->request->data['Appointment']['created']=date('Y-m-d h:m:s');
            
            if(isset($eventId) && $eventId!='')
            {
              $this->request->data['Appointment']['id']=$eventId;
                    if($this->Appointment->save($this->request->data['Appointment'])){
                        $edata['data'] = 'success' ;
                        $edata['message'] = __('Waiting List has been updated successfully',true);
                        echo json_encode($edata);
                        die;    
                    } 
            }else{
                if($this->Appointment->save($this->request->data['Appointment'])){
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('Appointment added successfully',true);
                    echo json_encode($edata);
                    die;    
                }
                else{
                    $message = __('Unable to add personal task, Please try again.', true);
                    $vError = $this->Appointment->validationErrors;
                    $edata['data'] =$vError;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
                }
            }
        }else{
        $this->loadModel('User');
        App::import('Controller', 'Users');
        $this->Users = new UsersController;
        $this->layout = 'ajax';
        if(isset($eventId) && $eventId!=''){
           $edit_appointment=$this->Appointment->find('first',array('conditions'=>array('Appointment.id'=>$eventId)));
           $user=$this->User->find('first',array('conditions'=>array('User.id'=>$edit_appointment['Appointment']['user_id'])));
           $price_duration=$this->admin_fetch_price_and_duration($edit_appointment['Appointment']['salon_service_id'],$edit_appointment['Appointment']['salon_staff_id'],'edit');
           $this->set(compact('edit_appointment','user','price_duration'));
        }
        $employee[$employeeId]=$employeeId;
        $open_close_hours=$this->admin_get_calender_open_close_time($employee);
        $staffServices = $this->Common->getStaffServiceList($employeeId, $this->Auth->user('id'));
        $userList = $this->Users->findallCustomerList();
        $this->User->unbindModel(array('hasMany' => array('PricingLevelAssigntoStaff')), true);
        $username=$this->User->find('first',array('fields'=>array('first_name','last_name'),'conditions'=>array('User.id'=>$employeeId)));
        $username=$username['User']['first_name'].' '.$username['User']['last_name'];
        $this->set(compact('time','staffServices','userList','employeeId','username','open_close_hours'));
        }
    }
    
/**********************************************************************************    
  @Function Name : admin_addMultipleappointments
  @Params	 : NULL
  @Description   : The Function to add Multiple Appointments
  @Author        : Shiv
  @Date          : 16-Jun-2015
***********************************************************************************/
 
    public function admin_addMultipleappointments($time=NULL,$employeeId = NULL) {
        $this->loadModel('User');
        App::import('Controller', 'Users');
        $this->Users = new UsersController;
        $this->layout = 'ajax';
        $staffServices = $this->Common->getStaffServiceList($employeeId, $this->Auth->user('id'));
        $staff = $this->Common->get_salon_staff($this->Auth->user('id'));
        $staffCount = count($staff);
        $staff[$staffCount]['User']['id']=$this->Auth->user('id');
        $staff[$staffCount]['User']['first_name']=$this->Auth->user('first_name');
        $staff[$staffCount]['User']['last_name']=$this->Auth->user('last_name');
        if(isset($calsettings['SalonCalendarSetting']['service_provider_order']) && !empty($calsettings['SalonCalendarSetting']['service_provider_order'])){
            $staffOrder = explode(',',$calsettings['SalonCalendarSetting']['service_provider_order']);
            $staff = $this->Common->staffSortbySorder($staff,$staffOrder);
        }
        $staff_list=array();
        foreach($staff as $staff){
            $staff_list[$staff['User']['id']]=$staff['User']['first_name'].' '.$staff['User']['last_name'];
        }
        $userList = $this->Users->findallCustomerList();
        $this->set(compact('time','staffServices','userList','employeeId','staff','staff_list'));
    }
    
/**********************************************************************************    
  @Function Name : admin_saveMultipleAppointment
  @Params	 : NULL
  @Description   : The Function to save Multiple Appointments
  @Author        : Shiv
  @Date          : 16-Jun-2015
***********************************************************************************/
 
    public function admin_saveMultipleAppointment($ser_data='NULL',$editType='NULL') {
        parse_str($ser_data, $serarray);
	//pr($serarray); die;
        $total_price=0;
        $total_duration=0;
        $package_id=0;
        $time=$serarray['data']['Appointment']['starttime'];
        $employeeId=$serarray['data']['Appointment']['salon_staff_id'];
        for($i=1;$i<=5;$i++){
            if(isset($serarray['data']['Appointment']['check_'.$i])){
                $total_price=$total_price+$serarray['data']['Appointment']['price'.$i.'_'.$serarray['data']['Appointment']['check_'.$i]];
                $total_duration=$total_duration+$serarray['data']['Appointment']['duration'.$i.'_'.$serarray['data']['Appointment']['check_'.$i]];
                
            }
        }
        if($this->request->is('post') || $this->request->is('put')){
            $field=array();
            $field=array('fieldList'=>array('salon_service_id','startdate','time','user_id','appointment_price','appointment_duration','appointment_return_request'));
            if(isset($this->data['Appointment']['appointment_repeat_type']) && $this->data['Appointment']['appointment_repeat_type']!=0){
                $field['fieldList'][]='appointment_repeat_end_date';
                if($this->data['Appointment']['appointment_repeat_type'] == 2){
                    $field['fieldList'][]='appointment_repeat_weeks';
                    $field['fieldList'][]='appointment_repeat_day';
                }
                if($this->data['Appointment']['appointment_repeat_type'] == 3){
                    $field['fieldList'][]='appointment_repeat_month_date';
                }
                if($this->data['Appointment']['appointment_repeat_type'] == 4){
                    $field['fieldList'][]='appointment_yearly_repeat_month_date';
                }
            }
            $errors=array();
            $this->Appointment->set($this->request->data);
            if($this->Appointment->validates($field)){
		$salonUserId= $this->Auth->user('id');
		
                $appointment=array();
                if(isset($this->data['Appointment']['appointment_repeat_type']) && $this->data['Appointment']['appointment_repeat_type']>0){
                        $this->request->data['Appointment']['appointment_repeat_end_date'] = str_replace('/', '-', $this->request->data['Appointment']['appointment_repeat_end_date']); 
                        $appointment['Appointment']['appointment_repeat_end_date']=$this->request->data['Appointment']['appointment_repeat_end_date'];
                        $appointment['Appointment']['appointment_repeat_type']=$this->request->data['Appointment']['appointment_repeat_type'];
                        $appointment['Appointment']['appointment_repeat_weeks']=$this->request->data['Appointment']['appointment_repeat_weeks'];
                        $appointment['Appointment']['appointment_repeat_day']=$this->request->data['Appointment']['appointment_repeat_day'];
                        $appointment['Appointment']['appointment_repeat_month_date']=$this->request->data['Appointment']['appointment_repeat_month_date'];
                        $appointment['Appointment']['appointment_yearly_repeat_month_date']=$this->request->data['Appointment']['appointment_yearly_repeat_month_date'];
                        $appointment['Appointment']['appointment_repeat_month']=$this->request->data['Appointment']['appointment_repeat_month'];
                }
                for($i=1;$i<=5;$i++){
                    if(isset($serarray['data']['Appointment']['salon_service_id_'.$i]) && $serarray['data']['Appointment']['salon_service_id_'.$i]!=''){
                        $j=$i-1;
                        if(isset($appointment['Appointment']['appointment_start_date']) && $appointment['Appointment']['appointment_start_date']!=''){ 
                            $selectedTime= date('H:i',$appointment['Appointment']['appointment_start_date']);
                            $endTime = strtotime("+".$serarray['data']['Appointment']['duration'.$j.'_'.$serarray['data']['Appointment']['check_'.$j]]."minutes", strtotime($selectedTime));
                            $start_date=date('d-m-Y',$appointment['Appointment']['appointment_start_date']);
                            $endTime= date('H:i',$endTime);
                            $appointment['Appointment']['appointment_start_date']= strtotime($start_date.'  '.$endTime);
                        }else{
                            $this->request->data['Appointment']['startdate'] = str_replace('/', '-', $this->request->data['Appointment']['startdate']);
                            $appointment['Appointment']['appointment_start_date']= strtotime($this->request->data['Appointment']['startdate'].' '.$this->request->data['Appointment']['time']);
                        }
                        $userId=$this->data['Appointment']['user_id']; 
                        $salon_service_id=$serarray['data']['Appointment']['salon_service_id_'.$i];
                        $this->loadModel('SalonService');
                        $this->loadModel('User');
                        $service_name=$this->SalonService->find('first',array('fields'=>array('eng_display_name','eng_name','service_id'),'conditions'=>array('SalonService.id'=>$salon_service_id)));
                        if($service_name['SalonService']['eng_name']!=''){
                            $salon_service_name=$service_name['SalonService']['eng_name'];
                        }
                        else{
                            $this->loadModel('Service');
                            $salon_service_name_by_service_id=$this->Service->find('first',array('fields'=>array('eng_display_name','eng_name'),'conditions'=>array('Service.id'=>$service_name['SalonService']['service_id'])));
                            $salon_service_name = $salon_service_name_by_service_id['Service']['eng_name'];
                        }
                        $customeName=$this->User->find('first',array('conditions'=>array('User.id'=>base64_decode($this->data['Appointment']['user_id']))));
                        $theCustomerName = $customeName['User']['first_name'].' '.$customeName['User']['last_name'];
                        $appointment['Appointment']['appointment_title'] = $theCustomerName.'-'.$salon_service_name;
                        $appointment['Appointment']['salon_staff_id']=$serarray['data']['Appointment']['salon_staff_id_'.$i];
                        $appointment['Appointment']['user_id']=base64_decode($this->data['Appointment']['user_id']);
                        $appointment['Appointment']['salon_service_id']=$serarray['data']['Appointment']['salon_service_id_'.$i];
                        $appointment['Appointment']['appointment_price']=$serarray['data']['Appointment']['price'.$i.'_'.$serarray['data']['Appointment']['check_'.$i]];
                        $appointment['Appointment']['appointment_duration']=$serarray['data']['Appointment']['duration'.$i.'_'.$serarray['data']['Appointment']['check_'.$i]];
                        if(isset($this->request->data['Appointment']['appointment_return_request'])){
                            $appointment['Appointment']['appointment_return_request']=$this->request->data['Appointment']['appointment_return_request'];
                        }
                        $appointment['Appointment']['status']=1;
                        $appointment['Appointment']['type']='M';
                        $appointment['Appointment']['created']=date('Y-m-d h:m:s');
                        $appointment['Appointment']['is_deleted']=0;
			$appointment['Appointment']['salon_id'] = $salonUserId;
                        if(isset($package_id) && $package_id==0){
                            $package_id_array = $this->Appointment->find('first', array('fields' =>             'Appointment.package_id','order' => 'Appointment.package_id DESC'));
                            if(!empty($package_id_array)){
                                $package_id=$package_id_array['Appointment']['package_id']+1;
                            }
                        }
                        $appointment['Appointment']['package_id']=$package_id;
                        if(isset($appointment)){
                            $this->Appointment->create();
                            $appointment_saved= $this->Appointment->save($appointment['Appointment'],false);
                        }
                    }
                }
                if(isset($appointment_saved)){
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('Multiple Appointment added successfully',true);
                    echo json_encode($edata);
                    die;    
                }else{
                    $message = __('Unable to add appointment, Please try again.', true);
                    $vError = $this->Appointment->validationErrors;
                }
            }else{
                $message = __('Unable to add appointment, Please try again.', true);
                $vError = $this->Appointment->validationErrors;
                $edata['data'] =$vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }    
        }
        $this->loadModel('User');
        App::import('Controller', 'Users');
        $this->Users = new UsersController;
        $this->layout = 'ajax';
        $employee[$employeeId]=$employeeId;
        $open_close_hours=$this->admin_get_calender_open_close_time($employee);
        $userList = $this->Users->findallCustomerList();
        $this->loadModel('SalonCalendarSetting');
        $calendorsettings = $this->SalonCalendarSetting->find('first',array('conditions'=>array('SalonCalendarSetting.user_id'=>$this->Auth->user('id'))));
        if(empty($calendorsettings)){
            $calendorsettings = $this->SalonCalendarSetting->find('first',array('conditions'=>array('SalonCalendarSetting.user_id'=>1)));
        }
        $this->set(compact('time','staffServices','userList','employeeId','calendorsettings','staffname','editType','open_close_hours','total_duration','total_price'));
    }
    
/**********************************************************************************    
  @Function Name : admin_editWorkinghours
  @Params	 : NULL
  @Description   : The Function to editing working hours of staff
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_editWorkinghours($time=NULL,$employeeId = NULL,$from=NULL,$to=NULL) {
        if($this->request->is('post') || $this->request->is('put')){
            $errorArray = array();
            if($this->data['SalonOpeningHour']['days_type']==''){
                    $errorArray['days_type'][] = "Days Type Must be Selected";
            }
            if($this->data['SalonOpeningHour']['from']==''){
                $errorArray['from'][] = "Start Date Must be selected";
            }
            if($this->data['SalonOpeningHour']['to']==''){
                $errorArray['to'][] = "To Date Must be selected";
            }
            if(strtotime($this->data['SalonOpeningHour']['from'])>strtotime($this->data['SalonOpeningHour']['to'])){
              $errorArray['from'][] = " Start time must be smaller than End time";   
            }
            if(count($errorArray)>0){
                $edata['data'] = $errorArray;
                if($this->data['SalonOpeningHour']['days_type']==''){
                    $edata['message'] = __('Days Type Must be Selected',true);
                    }else{
                   $edata['message'] = __('Error in edit working hours',true); 
                }
                
                echo json_encode($edata);       
                die;
            }
            if($this->data['SalonOpeningHour']['days_type']=='all'){
                $this->request->data['SalonOpeningHour']['user_id']=$this->request->data['SalonOpeningHour']['salon_staff_id'];
                $day=strtolower($this->data['SalonOpeningHour']['day']); 
                $this->request->data['SalonOpeningHour'][$day.'_from']=$this->request->data['SalonOpeningHour']['from'];
                $this->request->data['SalonOpeningHour'][$day.'_to']=$this->request->data['SalonOpeningHour']['to'];
                $this->request->data['SalonOpeningHour']['type']='staff';
                $this->request->data['SalonOpeningHour']['status']=1;
                $this->request->data['SalonOpeningHour']['created']=date('Y-m-d h:m:s');
                $this->loadModel('SalonOpeningHour');
                $user_id=$this->SalonOpeningHour->find('all',array('conditions'=>array('user_id'=>$this->request->data['SalonOpeningHour']['salon_staff_id']),'fields'=>array('user_id','id')));
            if(isset($user_id[0]['SalonOpeningHour']['user_id']) && !empty($user_id[0]['SalonOpeningHour']['user_id'])){
                $this->request->data['SalonOpeningHour']['id']=$user_id[0]['SalonOpeningHour']['id'];
                    if($this->SalonOpeningHour->save($this->request->data['SalonOpeningHour'])){
                        $edata['data'] = 'success' ;
                        $edata['message'] = __('Salon Opening Hours added successfully',true);
                        echo json_encode($edata);
                        die;    
                    }
                }
                else{
                    if($this->SalonOpeningHour->save($this->request->data['SalonOpeningHour'])){
                        $edata['data'] = 'success' ;
                        $edata['message'] = __('Salon Opening Hours added successfully',true);
                        echo json_encode($edata);
                        die;    
                    }
                }
            }
            else{
                $this->loadModel('SalonOpeningHourByDate');
                $this->request->data['SalonOpeningHourByDate']['user_id']=$this->request->data['SalonOpeningHour']['salon_staff_id'];
                $this->request->data['SalonOpeningHourByDate']['date']=strtotime($this->request->data['SalonOpeningHour']['date']);
                $this->request->data['SalonOpeningHourByDate']['salon_start_time']=date('h:i A',strtotime($this->request->data['SalonOpeningHour']['from']));
                $this->request->data['SalonOpeningHourByDate']['salon_end_time']=date('h:i A',strtotime($this->request->data['SalonOpeningHour']['to']));
                $this->request->data['SalonOpeningHourByDate']['status']=1;
                $this->request->data['SalonOpeningHourByDate']['created']=date('Y-m-d h:m:s');
                if($this->SalonOpeningHourByDate->save($this->request->data['SalonOpeningHourByDate'])){
                        $edata['data'] = 'success' ;
                        $edata['message'] = __('Salon Opening Hours added successfully',true);
                        echo json_encode($edata);
                        die;    
                    }
                }
            }
        $this->loadModel('User');
        App::import('Controller', 'Users');
        $this->Users = new UsersController;
        $this->layout = 'ajax';
        $staffServices = $this->Common->getStaffServiceList($employeeId, $this->Auth->user('id'));
        $staff = $this->Common->get_salon_staff($this->Auth->user('id'));
        $userList = $this->Users->findallCustomerList();
        $username=$this->User->find('first',array('fields'=>array('first_name','last_name'),'conditions'=>array('User.id'=>$employeeId)));
        $username=$username['User']['first_name'].' '.$username['User']['last_name'];
        $this->set(compact('time','staffServices','userList','employeeId','staff','username','from','to'));
    }

/**********************************************************************************    
  @Function Name : admin_fetch_price_and_duration
  @Params	 : NULL
  @Description   : The Function to fetching price and duration of any service
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_fetch_price_and_duration($service_id='NULL',$staff_id='NULL',$edit_app='NULL'){
        $this->Components->load('Auth');
        $this->loadModel('PricingLevelAssigntoStaff');
        $this->loadModel('ServicePricingOption');
        $user_id=$this->Auth->user('id');
        $PricingLevels=$this->PricingLevelAssigntoStaff->find('all',array(
                                                            'fields'=>array('pricing_level_id'),
                                                            'conditions'=>array('user_id'=>$staff_id)));
        $PricingLevelsIds=array();
        foreach($PricingLevels as $PricingLevels)
            {
               $PricingLevelsIds[]= $PricingLevels['PricingLevelAssigntoStaff']['pricing_level_id'];
            }
        $PricingLevelsIds[]='0';
        $ServicePricingOptions=$this->ServicePricingOption->find('all', array(
                        'fields'=>array('full_price','sell_price','duration','salon_service_id','points_redeem','points_given'),
                        'conditions' => array('ServicePricingOption.pricing_level_id' => $PricingLevelsIds,                            'ServicePricingOption.salon_service_id' => $service_id,                                              'ServicePricingOption.is_deleted' => 0)
                                    ));
        //pr($ServicePricingOptions); die;
        $this->layout='ajax';
        if($edit_app!='NULL' && $edit_app=='edit'){
            return $ServicePricingOptions;
        }
        $this->set(compact('ServicePricingOptions'));
        $this->viewPath = "Elements/admin/Appointment";
        $this->render('appointment_pricingoptions');
    }

/**********************************************************************************    
  @Function Name : admin_fetch_multiprice_and_multiduration
  @Params	 : NULL
  @Description   : The Function to fetching multiple appointmrnt price and duration of any service
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_fetch_multiprice_and_multiduration($service_id='NULL',$id='NULL',$Staffid='NULL',$edit_app='NULL'){
        $this->Components->load('Auth');
        $this->loadModel('PricingLevelAssigntoStaff');
        $this->loadModel('ServicePricingOption');
        $user_id=$this->Auth->user('id');
        $PricingLevels=$this->PricingLevelAssigntoStaff->find('all',array(
                                                            'fields'=>array('pricing_level_id'),
                                                            'conditions'=>array('user_id'=>$Staffid)));
        $PricingLevelsIds=array();
        foreach($PricingLevels as $PricingLevels)
            {
               $PricingLevelsIds[]= $PricingLevels['PricingLevelAssigntoStaff']['pricing_level_id'];
            }
        $PricingLevelsIds[]='0';
        $ServicePricingOptions=$this->ServicePricingOption->find('all', array(
                        'fields'=>array('full_price','sell_price','duration','salon_service_id'),
                        'conditions' => array('ServicePricingOption.pricing_level_id' => $PricingLevelsIds,                            'ServicePricingOption.salon_service_id' => $service_id,                                              'ServicePricingOption.is_deleted' => 0)
                                    ));
        $this->layout='ajax';
        if($edit_app!='NULL' && $edit_app=='edit'){
            return $ServicePricingOptions;
        }
        $this->set(compact('ServicePricingOptions','id'));
        $this->viewPath = "Elements/admin/Appointment";
        $this->render('appointment_multipricingoptions');
    }
    
/**********************************************************************************    
  @Function Name : admin_checkRepeatAppointment
  @Params	 : NULL
  @Description   : The Function to check repeating appointments
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_checkRepeatAppointment(){
        $repeated_appointment=$this->Appointment->find('all', array(
                        'fields'=>array('appointment_repeat_type'),
                        'conditions' => array('Appointment.id' => $_REQUEST['id'])
                    ));
        echo $repeated_appointment[0]['Appointment']['appointment_repeat_type']; die;
    }
    
/**********************************************************************************    
  @Function Name : admin_get_calender_open_close_time
  @Params	 : NULL
  @Description   : The Function to get the opening and closing hours of calender
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_get_calender_open_close_time($staff_id_array='NULL'){
        $this->loadModel('SalonOpeningHour');
        $week_days=array('0'=>'monday','1'=>'tuesday','2'=>'wednesday','3'=>'thursday','4'=>'friday','5'=>'saturday','6'=>'sunday');
        $check_disable=array('0'=>'mon','1'=>'tue','2'=>'wed','3'=>'thu','4'=>'fri','5'=>'sat','6'=>'sun');
        $i=0;
        foreach($staff_id_array as $staff_user_id){
            $opening_hour=$this->SalonOpeningHour->find('first',array('conditions'=>array('user_id'=>$staff_user_id)));
            $opening_hour = array_filter($opening_hour);
            if (empty($opening_hour)) {
                $opening_hour=$this->SalonOpeningHour->find('first',array('conditions'=>array('user_id'=>1)));
            }
            $start='';
            $end='';
            for($j=0;$j<6;$j++){
                if($start=='' && $opening_hour['SalonOpeningHour']['is_checked_disable_'.$check_disable[$j]]!=0){
                    $start=strtotime($opening_hour['SalonOpeningHour'][$week_days[$j].'_from']); 
                }
                if($end=='' && $opening_hour['SalonOpeningHour']['is_checked_disable_'.$check_disable[$j]]!=0){
                    $end=strtotime($opening_hour['SalonOpeningHour'][$week_days[$j].'_to']);  
                }
                if($start>strtotime($opening_hour['SalonOpeningHour'][$week_days[$j].'_from']) && $opening_hour['SalonOpeningHour']['is_checked_disable_'.$check_disable[$j]]!=0){
                    $start=strtotime($opening_hour['SalonOpeningHour'][$week_days[$j].'_from']);
                }
                if($end<strtotime($opening_hour['SalonOpeningHour'][$week_days[$j].'_to']) && $opening_hour['SalonOpeningHour']['is_checked_disable_'.$check_disable[$j]]!=0){
                $end=strtotime($opening_hour['SalonOpeningHour'][$week_days[$j].'_to']); 
                }
            }
            if($i==0){
                $open_hours[0]=$start; 
                $open_hours[1]=$end;
            }
            if($i>0){
                if($open_hours[0]>$start){
                    $open_hours[0]=$start; 
                }
                if($open_hours[1]<$end){
                    $open_hours[1]=$end;
                }
            }
            $i++;
        }
        return $open_hours; 
    }

/**********************************************************************************    
  @Function Name : admin_editOneorMutipleAppointments
  @Params	 : NULL
  @Description   : The Function to edit single or multiple appointments or 
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_editOneorMutipleAppointments($eventId='NULL',$editType='NULL',$employeeId='NULL',        $startTime='NULL',$time='NULL'){
        if($editType=='only'){
            $fetch_exclude_dates=$this->Appointment->find('first',array(
                                                          'fields'=>array('exclude_dates'),
                                                          'conditions'=>array('Appointment.id'=>$eventId)));
            if(count($fetch_exclude_dates)>0 && !empty($fetch_exclude_dates['Appointment']['exclude_dates'])){
                $unserial=unserialize ($fetch_exclude_dates['Appointment']['exclude_dates']);
                $unserial[]=$time;
                $ser_array = array(
                                'Appointment' => array(
                                                'id'=>$eventId,
                                                'exclude_dates'=>serialize($unserial),
                                                'salon_staff_id'=>$employeeId
                                            )
                                        );
                $this->Appointment->save( $ser_array, false, array('exclude_dates','user_id') );
            }else{
                $exclude_dates[]=$time;
                $ser_array = array(
                                'Appointment' => array(
                                                'exclude_dates'=>serialize($exclude_dates),
                                            )
                                        );
                $this->Appointment->save($ser_array, false, array('exclude_dates') );
            }
            $checked=$this->request->data['Appointment']['check'];
            $this->request->data['Appointment']['appointment_price']=$this->request->data['Appointment']['price_'.$checked];
            $this->request->data['Appointment']['appointment_duration']=$this->request->data['Appointment']['duration_'.$checked];
            $addNoRepeatAppointment=$this->request->data;
            $addNoRepeatAppointment['Appointment']['id']='';
            $addNoRepeatAppointment['Appointment']['appointment_repeat_type']=0;
            $addNoRepeatAppointment['Appointment']['status']=1;
            
            if($this->Appointment->save($addNoRepeatAppointment)){
                $this->loadModel('AppointmentHistory');
                $appointment_history['AppointmentHistory']['appointment_id']=$eventId;
                $appointment_history['AppointmentHistory']['modified_by']=$employeeId;
                $appointment_history['AppointmentHistory']['modified_date']=strtotime(date('Y-m-d h:m:s'));
                $appointment_history['AppointmentHistory']['action']='Modified';
                $this->AppointmentHistory->save($appointment_history['AppointmentHistory'],false);
                
                
               /* $appointment_history['AppointmentHistory']['appointment_id']=$eventId;
                $appointment_history['AppointmentHistory']['appointment_date']=strtotime(date('Y-m-d h:i:s'));
                $appointment_history['AppointmentHistory']['type']='admin';
                $appointment_history['AppointmentHistory']['service_name']=$salon_service_name;
                    $appointment_history['AppointmentHistory']['staff_id']=$staff_id;
                    $appointment_history['AppointmentHistory']['duration']=$this->request->data['Appointment']['duration_'.$checked];
                    $appointment_history['AppointmentHistory']['modified_by']=$this->Auth->user('id');
                    $appointment_history['AppointmentHistory']['modified_date']=strtotime(date('Y-m-d h:i:s'));
                    $appointment_history['AppointmentHistory']['status']='Created';
                    $appointment_history['AppointmentHistory']['action']='Created';
                    
                    $this->admin_saveAppointmentHistory($appointment_history);
                
                */
                
                $edata['data'] = 'success' ;
                $edata['message'] = __('Appointment updated successfully',true);
                echo json_encode($edata);
                die;    
            }
        }
        elseif($editType=='series'){
            $this->request->data['Appointment']['appointment_start_date']=$startTime;
            $this->request->data['Appointment']['id']=$eventId;
            if($this->Appointment->save($this->request->data['Appointment'])){
                $edata['data'] = 'success' ;
                $edata['message'] = __('Appointment has been updated successfully',true);
                echo json_encode($edata);
                die;    
            }
            else{
                $message = __('Unable to add appointment, Please try again.', true);
                $vError = $this->Appointment->validationErrors;
                if(!empty($vError['appointment_price']) && isset($vError['appointment_price'])){
                    $vError['price_'.$this->data['Appointment']['check']] = $vError['appointment_price'];
                    }
                    if(!empty($vError['appointment_duration']) && isset($vError['appointment_duration'])){
                        $vError['duration_'.$this->data['Appointment']['check']] = $vError['appointment_duration'];
                    }
                    $edata['data'] =$vError;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
            }
        }
        else{
            $this->request->data['Appointment']['id']=$eventId;
            $this->request->data['Appointment']['appointment_start_date']=$startTime;
            if($this->Appointment->save($this->request->data['Appointment'])){
                $this->loadModel('AppointmentHistory');
                $appointment_history['AppointmentHistory']['appointment_id']=$eventId;
                $appointment_history['AppointmentHistory']['modified_by']=$employeeId;
                $appointment_history['AppointmentHistory']['modified_date']=strtotime(date('Y-m-d h:m:s'));
                $appointment_history['AppointmentHistory']['action']='Modified';
                $this->AppointmentHistory->save($appointment_history['AppointmentHistory'],false);
                $edata['data'] = 'success' ;
                $edata['message'] = __('Appointment has been updated successfully',true);
                echo json_encode($edata);
                die;    
            }
            else{
                $message = __('Unable to add appointment, Please try again.', true);
                $vError = $this->Appointment->validationErrors;
                if(!empty($vError['appointment_price']) && isset($vError['appointment_price'])){
                    $vError['price_'.$this->data['Appointment']['check']] = $vError['appointment_price'];
                    }
                    if(!empty($vError['appointment_duration']) && isset($vError['appointment_duration'])){
                        $vError['duration_'.$this->data['Appointment']['check']] = $vError['appointment_duration'];
                    }
                    $edata['data'] =$vError;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
            }
        }
    }
    
/**********************************************************************************    
  @Function Name : admin_saveMovedEvent
  @Params	 : NULL
  @Description   : The Ajax Function for saving dragged events in appointments
  @Author        : Shiv Kumar
  @Date          : 06-Apr-2014
***********************************************************************************/
 
    public function admin_saveMovedEvent(){
        $this->autoRender = false;
        if($this->request->is('ajax')){
            $check_repeat=$this->Appointment->find('all', array(
                        'conditions' => array('Appointment.id' => $this->request->data['id'])
                    ));
            $salon_staff_id=$check_repeat[0]['Appointment']['salon_staff_id'];
            $serviceName=$this->Common->get_salon_service_name($check_repeat[0]['Appointment']['salon_service_id']);
            $appointment_title=$check_repeat[0]['Appointment']['appointment_title'];
            $userId=$check_repeat[0]['Appointment']['user_id'];
            $appointment_start_date=$check_repeat[0]['Appointment']['appointment_start_date'];
            $appointment_duration=$check_repeat[0]['Appointment']['appointment_duration'];
            if($check_repeat[0]['Appointment']['appointment_repeat_type']>0){
                $fetch_exclude_dates=$this->Appointment->find('first',array(
                                    'fields'=>array('exclude_dates'),
                                    'conditions'=>array('Appointment.id'=>$this->request->data['id'])));
                if(count($fetch_exclude_dates)>0 && !empty($fetch_exclude_dates['Appointment']['exclude_dates'])){
                    $unserial=unserialize ($fetch_exclude_dates['Appointment']['exclude_dates']);
                    $unserial[]=$this->request->data['fromMoveDate'];
                    $moved_ser_array = array(
                                'Appointment' => array(
                                                'id'=>$this->request->data['id'],
                                                'exclude_dates'=>serialize($unserial)
                                            ));
                    $this->Appointment->save( $moved_ser_array, false, array('exclude_dates') );
                }else{
                    $exclude_dates[]=$this->request->data['fromMoveDate'];
                    $this->Appointment->id = $this->request->data['id'];
                    $this->Appointment->saveField('exclude_dates', serialize($exclude_dates));
                }
                $check_repeat[0]['Appointment']['appointment_start_date']=$this->request->data['movedate'];
                $check_repeat[0]['Appointment']['appointment_repeat_type']=0;
                $check_repeat[0]['Appointment']['exclude_dates']='';
                $check_repeat[0]['Appointment']['salon_staff_id']=$this->request->data['moveToResource'];
                $check_repeat[0]['Appointment']['id']='';
                $this->Appointment->save($check_repeat[0]['Appointment'],false);
                /***** Mail to Booking Incharge*****/
                $staff = $this->Common->get_salon_staff($this->Auth->user('id'));
                $this->loadModel('UserDetail');
                for($st=0;$st<=count($staff);$st++){
                    $booking_incharge=$this->UserDetail->find('first',array('fields'=>array('user_id','booking_incharge'),'conditions'=>array('UserDetail.user_id'=>$staff[$st]['User']['id'])));
                    if($booking_incharge['UserDetail']['booking_incharge']==1){
                        $this->admin_notify_customer($appointment_title,$staff[$st]['User']['id'],'',$startTime,$this->request->data['Appointment']['duration_'.$checked],'reschedule_backend_appointment','reschedule');   
                    }
                }
                $this->admin_notify_customer($appointment_title,$salon_staff_id,$serviceName,$this->request->data['movedate'],$appointment_duration,'reschedule_backend_appointment');
                if($this->request->data['notify']==1){
                    $this->admin_notify_customer($appointment_title,$userId,$serviceName,$this->request->data['movedate'],$appointment_duration,'reschedule_backend_appointment');
                }
                die;
            }else{
                $move_array = array(
                            'Appointment' => array(
                                'id'=>$this->request->data['id'],
                                'appointment_start_date'=>$this->request->data['movedate'],
                                'salon_staff_id'=>$this->request->data['moveToResource'],
                            )
                        );
                $this->Appointment->save($move_array, false, array('appointment_start_date','salon_staff_id'));
                /***** Mail to Booking Incharge*****/
                $staff = $this->Common->get_salon_staff($this->Auth->user('id'));
                $this->loadModel('UserDetail');
                for($st=0;$st<=count($staff);$st++){
                    $booking_incharge=$this->UserDetail->find('first',array('fields'=>array('user_id','booking_incharge'),'conditions'=>array('UserDetail.user_id'=>$staff[$st]['User']['id'])));
                    if($booking_incharge['UserDetail']['booking_incharge']==1){
                        $this->admin_notify_customer($appointment_title,$staff[$st]['User']['id'],'',$startTime,$this->request->data['Appointment']['duration_'.$checked],'reschedule_backend_appointment');   
                    }
                }
                $this->admin_notify_customer($appointment_title,$salon_staff_id,$serviceName,$this->request->data['movedate'],$appointment_duration,'reschedule_backend_appointment','staff');
                if($this->request->data['notify']=='1'){
                    $this->admin_notify_customer($appointment_title,$userId,$serviceName,$this->request->data['movedate'],$appointment_duration,'reschedule_backend_appointment','customer');
                }
            }
            $this->loadModel('AppointmentHistory');
            $appointment_history['AppointmentHistory']['appointment_id']=$this->request->data['id'];
            $appointment_history['AppointmentHistory']['modified_by']=$this->Auth->user('id');
            $appointment_history['AppointmentHistory']['modified_date']=strtotime(date('Y-m-d h:m:s'));
            $appointment_history['AppointmentHistory']['action']='Moved';
            $this->AppointmentHistory->save($appointment_history['AppointmentHistory'],false);
        die;
        }
    }
    
/**********************************************************************************    
  @Function Name : admin_setCalederEventDate
  @Params	 : NULL
  @Description   : The Function to set the calender date session on navigate of scheduler 
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_setCalederEventDate(){
	$this->autoRender = false;
        if($this->request->is('ajax')){
            $sess_view=$this->Session->read('CustomView');
            if(isset($sess_view) && $sess_view!=''){
                $view=$this->Session->read('CustomView');
            }elseif(!empty($this->request->data['CalView'])){
		$view=$this->request->data['CalView'];
	    }
            if($view=='week'){
		$dates=explode('-',$this->request->data['calenderdate']);
		$test_date = $dates[0];
		$dates[0]=str_replace(',','',$dates[0]); 
		$dates[1]=str_replace(',','',$dates[1]);
		$this->Session->write('SessionCalenderStartDate',date('Y/m/d', strtotime($dates[0])));
                $dates[0]=date('Y-m-d', strtotime($dates[0]));
                $dates[1]=date('Y-m-d',strtotime($dates[1]));
                $this->Session->write('CalenderStartDate', $dates[0]);
                $this->Session->write('CalenderEndDate', $dates[1]);
            }elseif($view=='month'){
	       echo $this->request->data['calenderdate']=str_replace(',','-',$this->request->data['calenderdate']); 
		$fromMonth = date("Y-m-d", strtotime($this->request->data['calenderdate']));  
                $toMonth= strtotime(date("Y-m-d", strtotime($fromMonth)) . "+1 month"); 
                $toMonth=date("Y-m-d",$toMonth);
		$this->Session->write('SessionCalenderStartDate',date('Y/m/d', strtotime($fromMonth)));
                $dateFrom = strtotime(date("Y-m-d", strtotime($fromMonth)) . " -1 week"); 
                $dateFrom=date("Y-m-d",$dateFrom); 
                $dateTo = strtotime(date("Y-m-d", strtotime($toMonth)) . " +1 week");
                $dateTo=date("Y-m-d",$dateTo);
                $this->Session->write('CalenderStartDate', $dateFrom);
                $this->Session->write('CalenderEndDate', $dateTo);
            }elseif($view=='day'){
                $dates=explode(',',$this->request->data['calenderdate']);
                $date=$dates[1];
                $dateEnd=$dates[2];
                $this->Session->write('SessionCalenderStartDate',date('Y/m/d', strtotime($date.$dateEnd)));
                $dates[0]=date('Y-m-d', strtotime('-1 day', strtotime($date.$dateEnd)));
                $dates[1]=date('Y-m-d',strtotime($date.$dateEnd . ' + 1 day'));
                $this->Session->write('CalenderStartDate', $dates[0]);
                $this->Session->write('CalenderEndDate', $dates[1]);
            }
        }
        echo $this->Session->read('CalenderStartDate'); echo "---";
        echo $this->Session->read('CalenderEndDate');
        die;
    }
     
/**********************************************************************************    
  @Function Name : admin_saveResizedEvent
  @Params	 : NULL
  @Description   : The Function to save appointment when we resize it 
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_saveResizedEvent(){
        $duration = abs($this->request->data['resizeenddate'] - $this->request->data['resizestartdate'])/(60*60)*60;
        $this->autoRender = false;
        if($this->request->is('ajax')){
            $check_repeat=$this->Appointment->find('all', array(
                        'conditions' => array('Appointment.id' => $this->request->data['id'])
                    ));
            if($check_repeat[0]['Appointment']['appointment_repeat_type']>0){
                $fetch_exclude_dates=$this->Appointment->find('first',array(
                                                'fields'=>array('exclude_dates'),
                                                'conditions'=>array('Appointment.id'=>$this->request->data['id'])));
                if(count($fetch_exclude_dates)>0 && !empty($fetch_exclude_dates['Appointment']['exclude_dates'])){
                    $unserial=unserialize ($fetch_exclude_dates['Appointment']['exclude_dates']);
                    $unserial[]=$this->request->data['resizestartdate'];
                    $moved_ser_array = array(
                                'Appointment' => array(
                                                'id'=>$this->request->data['id'],
                                                'exclude_dates'=>serialize($unserial)
                                            ));
                    $this->Appointment->save( $moved_ser_array, false, array('exclude_dates') );
                }else{
                    $exclude_dates[]=$this->request->data['resizestartdate'];
                    $this->Appointment->id = $this->request->data['id'];
                    $this->Appointment->saveField('exclude_dates', serialize($exclude_dates));
                }
                $check_repeat[0]['Appointment']['appointment_start_date']=$this->request->data['resizestartdate'];
                $check_repeat[0]['Appointment']['appointment_repeat_type']=0;
                $check_repeat[0]['Appointment']['exclude_dates']='';
                $check_repeat[0]['Appointment']['appointment_duration']=$duration;
                $check_repeat[0]['Appointment']['id']='';
                $this->Appointment->save($check_repeat[0]['Appointment'],false);
                die;
            }
            else{
                $resize_array = array(
                            'Appointment' => array(
                                'id'=>$this->request->data['id'],
                                'appointment_start_date'=>$this->request->data['resizestartdate'],
                                'appointment_duration'=>$duration,
                            )
                        );
        $this->Appointment->save($resize_array, false, array('appointment_start_date','appointment_duration'));
            }
            $this->loadModel('AppointmentHistory');
            $appointment_history['AppointmentHistory']['appointment_id']=$this->request->data['id'];
            $appointment_history['AppointmentHistory']['modified_by']=$this->Auth->user('id');
            $appointment_history['AppointmentHistory']['modified_date']=strtotime(date('Y-m-d h:m:s'));
            $appointment_history['AppointmentHistory']['action']='Resized';
            $this->AppointmentHistory->save($appointment_history['AppointmentHistory'],false);
            die;
        }
    }
    
/**********************************************************************************    
  @Function Name : admin_change_appointment_status
  @Params	 : NULL
  @Description   : The Function to change the appointment status 
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_change_appointment_status(){
        $this->autoRender = false;
        if($this->request->is('ajax')){
            $this->Appointment->unbindModel(array('belongsTo' => array('User','Service')), true);
            if($this->request->data['key']=='serviceInprogress'){
                $current_date=strtotime(Date('Y-m-d'));
                $startdate=strtotime(date('Y-m-d',$this->request->data['startDate']));
                if($current_date<$startdate){
                    die('repeat');
                }
            }
            $check_repeat=$this->Appointment->find('all', array('fields'=>array('appointment_start_date'),
                        'conditions' => array('Appointment.id' => $this->request->data['id'],'Appointment.appointment_repeat_type >' => 0)
                    ));
            $check_repeat = array_filter($check_repeat);
            if(!empty($check_repeat)){
                if($this->request->data['key']=='show'){
                    $stat=7;    
                }
                if($this->request->data['key']=='noShow'){
                    $stat=8;
                }
                if($this->request->data['key']=='serviceInprogress'){
                   $stat=6; 
                }
                $repeat=1;
                $status=$this->Appointment->find('all', array('fields'=>array('changed_status'),
                        'conditions' => array('Appointment.id' => $this->request->data['id'])
                    ));
                if($status[0]['Appointment']['changed_status']!=''){
                    $status_array=unserialize(base64_decode($status[0]['Appointment']['changed_status']));
                    $status_array1=$status_array;
                    $count= count($status_array1);
                    if($status_array[$count-1]['date']==strtotime(date('Y-m-d h:i',$this->request->data['startDate']))){
                        $status_array1[$count-1]['date']=strtotime(date('Y-m-d h:i',$this->request->data['startDate']));
                            $status_array1[$count-1]['status']=$stat;
                        
                    }else{
                        $status_array1[$count]['date']=strtotime(date('Y-m-d h:i',$this->request->data['startDate']));
                        $status_array1[$count]['status']=$stat;
                    }
                }else{
                    $status_array1[0]['date']=strtotime(date('Y-m-d h:i',$this->request->data['startDate']));
                    $status_array1[0]['status']=$stat; 
                }
            }else{
                $repeat=0;
            }
            if($this->request->data['key']=='delete'){
                $delete_array = array(
                            'Appointment' => array(
                                'id'=>$this->request->data['id'],
                                'is_deleted'=>1,
                            )
                        );
                $this->Appointment->save($delete_array, false, array('is_deleted'));
            }elseif($this->request->data['key']=='serviceInprogress'){
                    if($repeat==0){
                    $show_array = array(
                            'Appointment' => array(
                                'id'=>$this->request->data['id'],
                                'status'=>6
                            )
                        );
                    $this->Appointment->save($show_array, false, array('status'));
                }else{
                    $repeat_date=strtotime(date('Y-m-d',$this->request->data['startDate']));
                    $status1[]=array('date'=>$repeat_date,'status'=>$stat);
                    $show_array = array(
                            'Appointment' => array(
                                'id'=>$this->request->data['id'],
                                'changed_status'=>base64_encode(serialize($status_array1))
                            )
                        );
                    $this->Appointment->save($show_array, false, array('changed_status'));
                }
                    
            }
            elseif($this->request->data['key']=='show'){
                if($repeat==0){
                    $show_array = array(
                            'Appointment' => array(
                                'id'=>$this->request->data['id'],
                                'status'=>7
                            )
                        );
                    $this->Appointment->save($show_array, false, array('status'));
                }else{
                    $repeat_date=strtotime(date('Y-m-d',$this->request->data['startDate']));
                    $status1[]=array('date'=>$repeat_date,'status'=>7);
                    $show_array = array(
                            'Appointment' => array(
                                'id'=>$this->request->data['id'],
                                'changed_status'=>base64_encode(serialize($status_array1))
                            )
                        );
                    $this->Appointment->save($show_array, false, array('changed_status'));
                }
            }
            elseif($this->request->data['key']=='noShow'){
                if($repeat==0){
                    $show_array = array(
                            'Appointment' => array(
                                'id'=>$this->request->data['id'],
                                'status'=>8
                            )
                        );
                    $this->Appointment->save($show_array, false, array('status'));
                }else{
                    $repeat_date=strtotime(date('Y-m-d',$this->request->data['startDate']));
                    $status1[]=array('date'=>$repeat_date,'status'=>8);
                    $show_array = array(
                            'Appointment' => array(
                                'id'=>$this->request->data['id'],
                                'changed_status'=>base64_encode(serialize($status_array1))
                            )
                        );
                    $this->Appointment->save($show_array, false, array('changed_status'));
                }
            }
            elseif($this->request->data['key']=='cancel'){
                    $show_array = array(
                            'Appointment' => array(
                                'id'=>$this->request->data['id'],
                                'status'=>5
                            )
                        );
            
                    if($this->Appointment->save($show_array, false, array('status'))){
                        
                        $detail=$this->Appointment->find('all', array('fields'=>array('id','appointment_title','user_id','salon_service_id','appointment_start_date','appointment_duration','salon_staff_id'),
                        'conditions' => array('Appointment.id' => $this->request->data['id'])
                    ));
                       $appointment_title=$detail[0]['Appointment']['appointment_title'];
                        $userId=$detail[0]['Appointment']['user_id'];
                        $this->loadModel('Service');
                    $salon_service_name_by_service_id=$this->Service->find('first',array('fields'=>array('eng_display_name','eng_name'),'conditions'=>array('Service.id'=>$detail[0]['Appointment']['salon_service_id'])));
                    $salon_service_name = $salon_service_name_by_service_id['Service']['eng_name'];
                        
                        
                        $startTime=date('Y-m-d h:i A',$detail[0]['Appointment']['appointment_start_date']);
                        $duration=$detail[0]['Appointment']['appointment_duration'];
                        $staff_id=$detail[0]['Appointment']['salon_staff_id'];
                       // pr($detail);
                        $this->admin_notify_customer($appointment_title,$userId,$salon_service_name,$startTime,$duration,'cancel_backend_appointment','customer');
                    
                   $this->admin_notify_customer($appointment_title,$staff_id,$salon_service_name,$startTime,$duration,'cancel_backend_appointment','staff');
                    
                    $this->admin_notify_customer($appointment_title,$this->Auth->user('id'),$salon_service_name,$startTime,$duration,'cancel_backend_appointment');
                    /***** Mail to Booking Incharge*****/
                    
                    $staff = $this->Common->get_salon_staff($this->Auth->user('id'));
                    $this->loadModel('UserDetail');
                    for($st=0;$st<=count($staff);$st++){
                        $booking_incharge=$this->UserDetail->find('first',array('fields'=>array('user_id','booking_incharge'),'conditions'=>array('UserDetail.user_id'=>$staff[$st]['User']['id'])));
                        if($booking_incharge['UserDetail']['booking_incharge']==1){
                            $this->admin_notify_customer($appointment_title,$staff[$st]['User']['id'],$salon_service_name,$startTime,$duration,'cancel_backend_appointment');   
                        }
                        
                    }
                        
                        
                    }
            }
            elseif($this->request->data['key']=='deny'){
                    $show_array = array(
                            'Appointment' => array(
                                'id'=>$this->request->data['id'],
                                'status'=>9
                            )
                        );
            
                    $this->Appointment->save($show_array, false, array('status'));
            }
            $this->loadModel('AppointmentHistory');
            $appointment_history['AppointmentHistory']['appointment_id']=$this->request->data['id'];
            $appointment_history['AppointmentHistory']['modified_by']=$this->Auth->user('id');
            $appointment_history['AppointmentHistory']['modified_date']=strtotime(date('Y-m-d h:m:s'));
            $appointment_history['AppointmentHistory']['action']='changed Status to '.$this->request->data['key'];
            $this->AppointmentHistory->save($appointment_history['AppointmentHistory'],false);
        
        }
        die;
    }
        
/**********************************************************************************    
  @Function Name : color_set
  @Params	 : NULL
  @Description   : The Function to set the appointment color array 
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    
    function color_set($type,$status,$colors){
        if($type=='A'){
            $event_type="the-appointment";
        }
        if($type=='M'){
            $event_type="the-multiple-appointment";
        }
        if($type=='P'){
            $event_type="the-personal";
        }
        if($type=='V'){
            $event_type="E-Voucher";
        }
        if($type=='A' && $status==1){
            $event_type="the-appointment";
            $color=$colors['Color']['confirmed'];
        }
        if($type=='M' && $status==1){
            $event_type="the-multiple-appointment";
            $color=$colors['Color']['confirmed'];
        }
        if($type=='W' && $status==0){
            $event_type="the-waiting";
            $color=$colors['Color']['on_waiting_list'];
        }
	if($type=='PAC' && $status==4){
            $event_type="the-appointment";
            //$color=$colors['Color']['personal_task_block'];
        }
	if($type=='A' && $status==4){
            $event_type="the-appointment";
            $color=$colors['Color']['accepted'];
        }
	if($type=='P' && $status==1){
            $event_type="the-personal";
            $color=$colors['Color']['personal_task_block'];
        }
        elseif($status==3){
            $color=$colors['Color']['complete'];
            $event_type="the-appointment checkout";
        }elseif($status==6){
            $color=$colors['Color']['in_progress'];
        }elseif($status==7){
            $color=$colors['Color']['show'];
        }elseif($status==8){
            $color=$colors['Color']['no_show'];
        }elseif($status==9){
            $color="";
        }elseif($status==5){
            $event_type="cancel";
        }
        if(!isset($event_type)){
            $event_type="";
        }
        if(!isset($color)){
            $color="";
        }
        $status_color=array('event_type'=>$event_type,'color'=>$color);
        return $status_color; 
    }
    
/**********************************************************************************    
  @Function Name : admin_show_appointment
  @Params	 : NULL
  @Description   : The Function to set the show appointment single or multiple for that day 
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
  
    public function admin_show_appointment(){
        $from_date=date('Y-m-d',$this->request->data['date']);
        $conditions = array('conditions' => array(
                                                'AND'=>array(
                                                    array('Appointment.appointment_start_date >='=>strtotime($from_date.' '.'00:00:00')),
                                                    array('Appointment.appointment_start_date <='=>strtotime($from_date.' '.'23:59:59')),array('Appointment.is_deleted'=>0),array('Appointment.status NOT IN(5,9)')
                                                )
                                            )
                                        );
        $appointments=$this->Appointment->find('all', $conditions);
        //pr($appointments); die;
        echo count($appointments); die;
    }
     
/**********************************************************************************    
  @Function Name : admin_show_appointment_list
  @Params	 : NULL
  @Description   : The Function to set the show appointment list
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_show_appointment_list($id,$date,$key){
        if($this->request->data){
            $this->loadmodel('AppointmentSlot');
            if($key=='show'){
                $stat=7;
            }elseif($key=='noShow'){
                $stat=8;
            }elseif($key=='deny'){
                $stat=9;
            }elseif($key=='cancel'){
                $stat=5;
            }
            for($i=1;$i<count($this->request->data['Appointment']);$i++){
                if($this->request->data['Appointment']['id'.$i]!=0){
                    $check_repeat=$this->Appointment->find('all', array('fields'=>array('id'),
                        'conditions' => array('Appointment.id' => $this->request->data['Appointment']['id'.$i],'Appointment.appointment_repeat_type >' => 0)
                    ));
                    if(!empty($check_repeat)){
                        $repeat=1;
                        $find_date=$this->AppointmentSlot->find('all', array('fields'=>array('startdate'),
                        'conditions' => array('AppointmentSlot.appointment_id' => $this->request->data['Appointment']['id'.$i])
                        ));
                        foreach($find_date as $find_date){
                            if(strtotime(date('Y-m-d',$date))==strtotime(date('Y-m-d',$find_date['AppointmentSlot']['startdate']))){
                                $startDate=$find_date['AppointmentSlot']['startdate'];
                            }
                        }
                        $status=$this->Appointment->find('all', array('fields'=>array('changed_status'),
                        'conditions' => array('Appointment.id' => $this->request->data['Appointment']['id'.$i])
                        ));
                        if(!empty($status[0]['Appointment']['changed_status'])){
                            $status_array=unserialize(base64_decode($status[0]['Appointment']['changed_status']));
                            $status_array1=$status_array;
                            $count= count($status_array1);
                            if($status_array[$count-1]['date']==strtotime(date('Y-m-d h:i',$startDate))){
                                    $status_array1[$count-1]['date']=strtotime(date('Y-m-d h:i',$startDate));
                                    $status_array1[$count-1]['status']=$stat;
                            }else{
                                $status_array1[$count]['date']=strtotime(date('Y-m-d h:i',$startDate));
                                $status_array1[$count]['status']=$stat;
                            }
                        }else{
                            $status_array1[0]['date']=strtotime(date('Y-m-d h:i',$startDate));
                            $status_array1[0]['status']=$stat;
                        }
                    }else{
                        $repeat=0;
                    }
                }
                if($repeat==0){
                    $show_array = array(
                            'Appointment' => array(
                                'id'=>$this->request->data['Appointment']['id'.$i],
                                'status'=>$stat
                            )
                        );
                    $this->Appointment->save($show_array, false, array('status'));
                }else{
                    $show_array = array(
                        'Appointment' => array(
                        'id'=>$this->request->data['Appointment']['id'.$i],
                        'changed_status'=>base64_encode(serialize($status_array1))
                        )
                    );
                    $this->Appointment->save($show_array, false, array('changed_status'));
                }
            }
            $edata['data'] = 'success' ;
            $edata['message'] = __('Status changed successfully',true);
            echo json_encode($edata);
            die;
        }
        $from_date=date('Y-m-d',$date);
        $conditions = array('conditions' => array(
                                        'OR'=>array(
                                        array('AND'=>array(
                                                    array('Appointment.appointment_start_date >='=>strtotime($from_date.' '.'00:00:00')),
                                                    array('Appointment.appointment_start_date <='=>strtotime($from_date.' '.'23:59:59')),
                                                    )),
                                        array('AND'=>array(
                                                    array('Appointment.appointment_start_date <='=>strtotime($from_date.' '.'23:59:59')),
                                                    array('Appointment.appointment_repeat_end_date >='=>strtotime($from_date.' '.'23:59:59')),    
                                        )),
                                                ), array('Appointment.status NOT IN(5,9)'))
                                            );
        $appointments=$this->Appointment->find('all', $conditions);
        $this->set('appointments',$appointments);
        $this->set('date',$date);
    }
    
/**********************************************************************************    
  @Function Name : admin_move_forward_appointment
  @Params	 : NULL
  @Description   : The Function to move forward an appointment
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_move_forward_appointment($time=NULL,$employeeId = NULL,$appointmentId = NULL,$editType=NULL){
        App::import('Controller', 'Bookings');
        $Bookings = new BookingsController;
        if($this->request->is('post') || $this->request->is('put')){
            $this->loadModel('User');
            $this->loadModel('SalonService');
            $appointmentId=$this->request->data['Appointment']['id'];
            $getAppointmentSlots=$Bookings->getAdminTimeslots($appointmentId,$this->Auth->user('id'),$this->request->data['Appointment']['salon_staff_id'],$this->request->data['Appointment']['startdate'],$this->request->data['Appointment']['salon_service_id'],'true');
            $staffDetail=$this->User->find('first',array('conditions'=>array('User.id'=>$this->request->data['Appointment']['salon_staff_id'])));
            $ServiceName=$this->SalonService->find('first',array('conditions'=>array('SalonService.id'=>$this->request->data['Appointment']['salon_service_id']),'fields'=>array('eng_name')));
            $Price=$this->Appointment->find('first',array('conditions'=>array('Appointment.id'=>$appointmentId),'fields'=>array('appointment_price')));
            $this->set(compact('getAppointmentSlots','time','staffDetail','ServiceName','Price'));
            $this->viewPath = "Elements/admin/Appointment";
            $this->render('forward_appointment_timeslots');
        }
        $this->loadModel('User');
        App::import('Controller', 'Users');
        $this->Users = new UsersController;
        $getAppointmentSlots=$Bookings->getAdminTimeslots($appointmentId,$this->Auth->user('id'));
        $appointment = $this->Appointment->find('first',array('conditions'=>array('Appointment.id'=>$appointmentId)));
        $user_id=base64_encode($appointment['Appointment']['user_id']);
        $service_id=$appointment['Appointment']['salon_service_id'];
        $staffServices = $this->Common->getStaffServiceList($employeeId, $this->Auth->user('id'));
        $userList = $this->Users->findallCustomerList();
        $staff = $this->Common->get_salon_staff($this->Auth->user('id'));
        $staffCount = count($staff);
        $staff[$staffCount]['User']['id']=$this->Auth->user('id');
        $staff[$staffCount]['User']['first_name']=$this->Auth->user('first_name');
        $staff[$staffCount]['User']['last_name']=$this->Auth->user('last_name');
        $staff_list=array();
        foreach($staff as $staff){
            $staff_list[$staff['User']['id']]=$staff['User']['first_name'].' '.$staff['User']['last_name'];
        }
        $this->set(compact('userList','staffServices','staff_list','employeeId','time','user_id','service_id','appointmentId','editType'));
    }
    
/**********************************************************************************    
  @Function Name : admin_add_forward_appointment
  @Params	 : NULL
  @Description   : The Function to add forward an appointment
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    function admin_add_forward_appointment($appId,$ser=NULL,$time=NULL,$fromTime=NULL){
        $this->loadModel('User');
        parse_str($ser, $serarray);
        if(isset($this->request->data) && !empty($this->request->data)){
            $startdate=$this->request->data['Appointment']['appointment_start_date'];
            $check_repeat=$this->Appointment->find('all', array(
                        'conditions' => array('Appointment.id' => $appId)
                    ));
            if($check_repeat[0]['Appointment']['appointment_repeat_type']>0){
                $fetch_exclude_dates=$this->Appointment->find('first',array(
                                                'fields'=>array('exclude_dates'),
                                                'conditions'=>array('Appointment.id'=>$appId)));
                if(count($fetch_exclude_dates)>0 && !empty($fetch_exclude_dates['Appointment']['exclude_dates'])){
                    $unserial=unserialize ($fetch_exclude_dates['Appointment']['exclude_dates']);
                    $unserial[]=$fromTime;
                    $moved_ser_array = array(
                                'Appointment' => array(
                                                'id'=>$appId,
                                                'exclude_dates'=>serialize($unserial)
                                            ));
                    $this->Appointment->save( $moved_ser_array, false, array('exclude_dates') );
                }else{
                    $exclude_dates[]=$fromTime;
                    $this->Appointment->id = $appId;
                    $this->Appointment->saveField('exclude_dates', serialize($exclude_dates));
                }
                $check_repeat[0]['Appointment']['appointment_start_date']=$startdate;
                $check_repeat[0]['Appointment']['appointment_repeat_type']=0;
                $check_repeat[0]['Appointment']['exclude_dates']='';
                $check_repeat[0]['Appointment']['salon_staff_id']=$serarray['data']['Appointment']['salon_staff_id'];
                $check_repeat[0]['Appointment']['id']='';
                if($this->Appointment->save($check_repeat[0]['Appointment'],false)){
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('Appointment forward successfully',true);
                    echo json_encode($edata);
                    die;
                }
                
            }else{
                $forward_array = array(
                            'Appointment' => array(
                                'id'=>$this->request->data['Appointment']['id'],
                                'appointment_start_date'=>$this->request->data['Appointment']['appointment_start_date'],
                                'salon_service_id'=>$this->request->data['Appointment']['salon_service_id'],
                                'salon_staff_id'=>$this->request->data['Appointment']['salon_staff_id'],
                                'appointment_comment'=>$this->request->data['Appointment']['appointment_comment'],
                            )
                        );
                if( $this->Appointment->save($forward_array, false, array('appointment_start_date','salon_service_id','salon_staff_id','appointment_comment'))){
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('Appointment forward successfully',true);
                    echo json_encode($edata);
                    die;
                }
            }
        }
        $time=str_replace("-",":",$time);
        $startdate=strtotime($serarray['data']['Appointment']['startdate'].' '.$time);
        $serviceName=$this->Common->get_salon_service_name($serarray['data']['Appointment']['salon_service_id']);
        $service_provider_array = $this->User->find('first',array('fields'=>array('first_name','last_name'),'conditions'=>array('User.id'=>$serarray['data']['Appointment']['salon_staff_id'])));
        $price = $this->Appointment->find('first',array('fields'=>array('appointment_price'),'conditions'=>array('Appointment.id'=>$appId)));
        $serviceProviderName=$service_provider_array['User']['first_name'].' '.$service_provider_array['User']['last_name'];
        $this->set(compact('serarray','appId','time','serviceName','serviceProviderName','price','startdate'));
    }

/**********************************************************************************    
  @Function Name : admin_notify_customer
  @Params	 : NULL
  @Description   : The Function to notify customer after creating appointment
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_notify_customer($appointment_title=NULL,$user_id=NULL,$service_name=NULL,$start_date=NULL,$duration=NULL,$tempate=NULL,$smsTo=NULL){
	//echo $tempate; die;
        $this->loadModel('User');
       $userData = $this->User->findById($user_id);
       $toEmail =   $userData['User']['email'];
       $fromEmail  =   Configure::read('fromEmail');
        $dynamicVariables = array('{FirstName}'=>ucfirst($userData['User']['first_name']),'{LastName}'=>ucfirst($userData['User']['last_name']), '{service_name}' => ucfirst($service_name),'{start_date}' => date('Y-m-d',$start_date),'{time}' => date('h:i A',$start_date),'{duration}' => $duration);
        $userName = $userData['User']['first_name'];
        $userEmail = $userData['User']['email'];
        $mbNumber =  $userData['Contact']['cell_phone']; 
        $country_code  = $userData['Contact']['country_code'];
	
        if(!empty($mbNumber) && $tempate=='add_appointment' && $smsTo=='customer'){
	    $welcomeMessage = 'Hi '.$userName.', Your Appointment '.$service_name.' has been successfully created on '.date('Y-m-d h:i A',$start_date);
            
            if($country_code){
                $mbNumber = str_replace("+","",$country_code).$mbNumber;    
            }
            elseif($country_code==''){
                $country_code="971";
                $mbNumber = str_replace("+","",$country_code).$mbNumber;
            }
            $this->Common->sendVerificationCode($welcomeMessage,$mbNumber);
        }
	if(!empty($mbNumber) && $tempate=='add_appointment' && $smsTo=='staff'){
            $welcomeMessage = 'Hi '.$userName.', Your Appointment '.$service_name.' has been successfully created on '.date('Y-m-d h:i A',$start_date);
            if(empty($country_code)){
              $country_code="971";   
            }
            $mbNumber = str_replace("+","",$country_code).$mbNumber;   
            $this->Common->sendVerificationCode($welcomeMessage,$mbNumber);
        }
        
        if(!empty($mbNumber) && $tempate=='reschedule_backend_appointment' && $smsTo=='customer'){
            $welcomeMessage = 'Hi '.$userName.', Your Appointment '.$service_name.' has been successfully rescheduled on '.date('Y-m-d h:i A',$start_date);
            if(empty($country_code)){
              $country_code="971";   
            }
            if($country_code){
                $mbNumber = str_replace("+","",$country_code).$mbNumber;    
            }
            $this->Common->sendVerificationCode($welcomeMessage,$mbNumber);
        }
	
        if(!empty($mbNumber) && $tempate=='reschedule_backend_appointment' && $smsTo=='staff'){
            $welcomeMessage = 'Hi '.$userName.', Your Appointment '.$service_name.' has been successfully rescheduled on '.date('Y-m-d h:i A',$start_date);
            if(empty($country_code)){
              $country_code="971";   
            }
            if($country_code){
                $mbNumber = str_replace("+","",$country_code).$mbNumber;    
            }
            $this->Common->sendVerificationCode($welcomeMessage,$mbNumber);
        }
        
	if(!empty($mbNumber) && $tempate=='cancel_backend_appointment' && $smsTo=='customer'){
            $welcomeMessage = 'Hi '.$userName.', Your Appointment '.$service_name.' has been successfully cancled on '.date('Y-m-d h:i A',$start_date);
            if(empty($country_code)){
              $country_code="971";   
            }
            if($country_code){
                $mbNumber = str_replace("+","",$country_code).$mbNumber;    
            }
            $this->Common->sendVerificationCode($welcomeMessage,$mbNumber);
        }
        
	if(!empty($mbNumber) && $tempate=='cancel_backend_appointment' && $smsTo=='staff'){
            $welcomeMessage = 'Hi '.$userName.', Your Appointment '.$service_name.' has been successfully canceld on '.date('Y-m-d h:i A',$start_date);
            if(empty($country_code)){
              $country_code="971";   
            }
            if($country_code){
                $mbNumber = str_replace("+","",$country_code).$mbNumber;    
            }
            $this->Common->sendVerificationCode($welcomeMessage,$mbNumber);
        }
	
	if(!empty($mbNumber) && $tempate=='add_review' && $smsTo=='customer'){
	    //die("test");
            $welcomeMessage = 'Hi '.$userName.', Your Appointment '.$service_name.' has been successfully canceld on '.date('Y-m-d h:i A',$start_date);
            if(empty($country_code)){
              $country_code="971";   
            }
            if($country_code){
                $mbNumber = str_replace("+","",$country_code).$mbNumber;    
            }
            $this->Common->sendVerificationCode($welcomeMessage,$mbNumber);
        }
	//$toEmail='sieasta98@gmail.com';
        $this->Common->sendEmail($toEmail,$fromEmail,$tempate,$dynamicVariables);
    }
    
/**********************************************************************************    
  @Function Name : admin_setCalenderView
  @Params	 : NULL
  @Description   : The Function to set the calender view after navigating scheduler
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_setCalenderView(){
        $this->autoRender = false;
        if($this->request->is('ajax')){
	   // date_default_timezone_set('Asia/Kolkata');
            $this->Session->write('CustomView', $this->request->data['view']);
	    echo $this->request->data['cal_start_date']; echo "==";
            $this->Session->write('SessionCalenderStartDate', date('Y/m/d',$this->request->data['cal_start_date']));
            if($this->request->data['action']=="changeView"){
	        $this->Session->write('SessionCalenderStartDate', date('Y/m/d'));
            }
            echo $this->Session->read('SessionCalenderStartDate');
            die;
        }
    }
    
/**********************************************************************************    
  @Function Name : admin_openHoursByDay
  @Params	 : NULL
  @Description   : The Function to set the opening hours of scheduler by day
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    function admin_openHoursByDay($user_id,$start_date,$end_date){
        $end_date=date('Y-m-d',strtotime($end_date . " -2 days"));
        $this->loadmodel('SalonOpeningHourByDate');
        $openHoursByDay = $this->SalonOpeningHourByDate->find('all',array('fields'=>array('date','salon_start_time','salon_end_time'),'conditions'=>array('SalonOpeningHourByDate.date BETWEEN ? AND ?' => array(strtotime($start_date),strtotime($end_date)),'SalonOpeningHourByDate.user_id'=>$user_id)));
        $scheOpenHours = array();
        for($i=0;$i<count($openHoursByDay);$i++){
            if(!empty($openHoursByDay)){
                $scheOpenHours[$openHoursByDay[$i]['SalonOpeningHourByDate']['date']]['sTime'] = $openHoursByDay[$i]['SalonOpeningHourByDate']['salon_start_time'];
                $scheOpenHours[$openHoursByDay[$i]['SalonOpeningHourByDate']['date']]['eTime'] = $openHoursByDay[$i]['SalonOpeningHourByDate']['salon_end_time'];
            }
        }
        return $scheOpenHours;
    }

/**********************************************************************************    
  @Function Name : admin_createToolTip
  @Params	 : NULL
  @Description   : The Function to set the tooltip status of scheduler
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_createToolTip($status,$staffId){
        $tool=array();
        $this->loadModel('User');
        $provider_name = $this->User->find('first',array('fields'=>array('first_name','last_name'),'conditions'=>   array('User.id'=>$staffId)));
        //pr($provider_name['User']); die;
        $tool[]=$provider_name['User']['first_name'].' '.$provider_name['User']['last_name'];
        if($status==0){
            $tool[]='waiting';
        }
        if($status==1){
            $tool[]='confirmed';
        }
        if($status==2){
            $tool[]='checking';
        }
        if($status==3){
            $tool[]='checkout';
        }
        if($status==4){
            $tool[]='paid';
        }
        if($status==6){
            $tool[]='InProgress';
        }
        if($status==7){
            $tool[]='Show';
        }
        if($status==8){
            $tool[]='NoShow';
        }
        return $tool;
    }

/**********************************************************************************    
  @Function Name : admin_checkMultipleAppointment
  @Params	 : NULL
  @Description   : The Function to check the multiple appointments in a day
  @Author        : Shiv
  @Date          : 16-Jun-2015
***********************************************************************************/
    public function admin_checkMultipleAppointment(){
        $this->loadModel('User');
        $this->loadModel('SalonService');
        $eventId=$_REQUEST['id'];
        $start_date_array=$this->Appointment->find('all',array('fields'=>array('id','appointment_start_date','package_id','user_id','salon_service_id'),'conditions'=>array('Appointment.id'=>$eventId)));
        $start_date=$start_date_array[0]['Appointment']['appointment_start_date'];
        $package_id=$start_date_array[0]['Appointment']['package_id'];
        $user_id=$start_date_array[0]['Appointment']['user_id'];
        $user_name = $this->User->find('first',array('fields'=>array('first_name','last_name'),'conditions'=>array('User.id'=>$user_id)));
        $from_date=date('Y-m-d',$start_date);
        $conditions = array('conditions' => array(
                                                'AND'=>array(
                                                        array('Appointment.appointment_start_date >='=>strtotime($from_date.' '.'00:00:00')),
                                                        array('Appointment.appointment_start_date <='=>strtotime($from_date.' '.'23:59:59')),
                                                        array('Appointment.is_deleted'=>0),array('Appointment.package_id'=>$package_id),
                                                        array('Appointment.status NOT IN(5,9)')
                                                )
                                            )
                                        );
        $appointments=$this->Appointment->find('all', $conditions);
        if(count($appointments)>0){
            $message='<div class="col-sm-12"><b>Moving or changing the duration of this appointment will affect this appointment only<b>.<br/>'.$user_name['User']['first_name'].' '.$user_name['User']['last_name'].' also has these other appointments on : '.date('M-d-Y',$start_date);
            foreach($appointments as $appointment){
                $salon_service_id=$start_date_array[0]['Appointment']['salon_service_id'];
                $service_name=$this->SalonService->find('first',array('fields'=>array('eng_display_name','eng_name','service_id'),'conditions'=>array('SalonService.id'=>$salon_service_id)));
                $message.= '<br/>'.date('h:m A',$appointment['Appointment']['appointment_start_date']).' - '.$service_name['SalonService']['eng_name'].' - with '.$user_name['User']['first_name'].' '.$user_name['User']['last_name'];
                
                if($appointment['Appointment']['appointment_repeat_type']>0){
                    $message1='<div class="col-sm-12"><input id="AppointmentOccurOnly" class="radio-inline cancelPeriodRadioPolicy" type="radio" value="only" checked name="data[Appointment][occur]"><label class="new-chk" for="AppointmentOccurOnly">Edit only this occurrence</label></div><div class="col-sm-12"><input id="AppointmentSeries" class="radio-inline cancelPeriodRadioPolicy" type="radio" value="series" name="data[Appointment][occur]"><label class="new-chk" for="AppointmentSeries">Edit Series</label></div>';
            
                }
                else{
                    $message1='';
                }
            }
            
            echo $message1.$message; die;
        }else{
             $message='';
        }
    }

/**********************************************************************************    
  @Function Name : admin_getAppointmentHistory
  @Params	 : NULL
  @Description   : The Function to get the appointment history
  @Author        : Shiv
  @Date          : 16-Jun-2015
***********************************************************************************/
 
    public function admin_getAppointmentHistory($id){
       // echo $eventId; die;
        //$this->loadModel('AppointmentHistory');
        //$history=$this->AppointmentHistory->find('all',array('fields'=>array('id','modified_by','modified_date','action','Appointment.appointment_start_date','Appointment.appointment_duration','Appointment.salon_service_id','Appointment.appointment_comment','Appointment.user_id','Appointment.status','Appointment.salon_staff_id'),'conditions'=>array('AppointmentHistory.appointment_id'=>$eventId)));
        //$this->set(compact('history'));
        
        
        $this->layout = 'ajax';
        $this->loadModel('AppointmentHistory');
        $history = '';
        if(!empty($id)){
             //$id = base64_decode($id);
         
           // if($type == 'Order'){
             //   $conditions = array('AppointmentHistory.order_id' => $id);
            //}else{
                $conditions = array('AppointmentHistory.appointment_id' => $id);
            //}
            //pr($conditions);
            //exit;
            $group = 'AppointmentHistory.modified_date , AppointmentHistory.order_id';
            
            $this->AppointmentHistory->bindModel(array('belongsTo'=>array('User'=>array('foreignKey'=>'modified_by'))));
             $this->Paginator->settings = array(
		    'AppointmentHistory' => array(
			 //'recursive'=>2,
			'limit' => 5,
			'conditions' => $conditions,
			'fields' => array('AppointmentHistory.*','GROUP_CONCAT(service_name) as package_services','GROUP_CONCAT(staff_id) as package_staffs','SUM(duration) as duration','MAX(appointment_date) as appointment_time','User.first_name','User.last_name'),
			'order' => array('AppointmentHistory.appointment_id1' => 'desc'),
			'group'=> $group
		    )
	    );
            $history = $this->Paginator->paginate('AppointmentHistory');
        //pr($history);
        //exit;
        }
        $this->set(compact('history'));
    }
	
/**********************************************************************************    
  @Function Name : admin_getCustomerHistory
  @Params	 : NULL
  @Description   : The Function to get the appointment history of customers
  @Author        : Vivek Kumar
  @Date          : 03-July-2015
***********************************************************************************/
	
    public function admin_getCustomerHistory($userId = null, $note_tab_active = null){
	$userId = base64_decode($userId);
	$this->Appointment->bindModel(array(
                                       'belongsTo' => array(
                                        'User' => 
                                            array('foreignKey' => 'salon_staff_id')
                                    ) )
                                );
        $appointment_history_array = $this->Appointment->find('all',array(
			'joins' => array(
				array(
					'table' => 'appointment_histories',
					'alias' => 'AppointmentHistory',
					'type' => 'LEFT',
					'conditions' => array(
						'AppointmentHistory.appointment_id = Appointment.id'
					)
				)
			),
			
			'fields' => array(
				'AppointmentHistory.id','AppointmentHistory.modified_by','AppointmentHistory.modified_date','AppointmentHistory.action','Appointment.appointment_start_date','Appointment.appointment_duration','Appointment.salon_service_id','Appointment.appointment_comment','Appointment.user_id','Appointment.status','Appointment.salon_staff_id','Appointment.created','Appointment.appointment_price','User.first_name','User.last_name'
			),
			'conditions'=>array('Appointment.user_id' => $userId),
			'order'=>array('Appointment.created DESC')
			)
		);
		
        $this->set(compact('appointment_history_array','note_tab_active'));
	
        
        
        
        
        #Find all the products history of selected users.
	/*$this->loadModel('Product');
	$product_history_array = $this->Product->find('all', array(
			'fields' => array(
				'Product.user_id','Product.eng_product_name','Product.ara_product_name','Product.selling_price','Product.selling_price','Product.quantity','Product.created','Product.barcode'
			),
			'conditions' => array('Product.user_id' => $userId,'Product.business_use' =>0)
	));
	$this->set(compact('product_history_array','userId'));*/
        $this->loadModel('Product');
        
        $product_history_array = $this->Product->find('all',array(
			'joins' => array(
				array(
					'table' => 'product_histories',
					'alias' => 'ProductHistory',
					'type' => 'LEFT',
					'conditions' => array(
						'ProductHistory.product_id = Product.id'
					)
				)
			),
			'fields' => array(
				'ProductHistory.id','ProductHistory.created','ProductHistory.qty','Product.barcode','Product.eng_product_name','Product.selling_price'
			),
			'conditions'=>array('Product.user_id' => $userId)
			)
		);
        $this->set(compact('product_history_array'));
	
        
        
        
        
        
        
        #Find all the IOU history of selected users.
	$this->loadModel('Iou');
	$iou_history_array = $this->Iou->find('all', array(
			'fields' => array(
				'Iou.user_id','Iou.created','iou_comment','status','total_iou_price'
			),
			'conditions' => array('Iou.user_id' => $userId)
	));
        //pr($iou_history_array); die;
	$this->set(compact('iou_history_array','userId'));
	
        //pr($iou_history_array); die;
        
        #Find all the notes history of selected users.
	$this->loadModel('Note');
	$note_history_array = $this->Note->find('all', array(
			'fields' => array(
				'Note.id','Note.user_id','Note.category','Note.description','Note.created'
			),
			'conditions' => array('Note.user_id' => $userId,'Note.is_deleted'=>0),
                        'order' => array('Note.id ASC')
	));
        
        
      // pr($note_history_array); die;
        
        
        
        
        //pr($note_history_array); die;
	$this->set(compact('note_history_array'));
        
        
        $this->loadModel('GiftCertificate');
	$gc_history_array = $this->GiftCertificate->find('all', array(
			'fields' => array(
				'GiftCertificate.gift_certificate_no','GiftCertificate.total_amount','GiftCertificate.expire_on'
			),
			'conditions' => array('GiftCertificate.user_id' => $userId,'GiftCertificate.is_used' => '1')
	));
        //pr($iou_history_array); die;
	$this->set(compact('gc_history_array','userId'));
        
        
        
    }
	
/**********************************************************************************    
  @Function Name : admin_get_service_name
  @Params	 : NULL
  @Description   : The Function to fetch the history detail
  @Author        : Shiv
  @Date          : 16-Jun-2015
***********************************************************************************/
    
    public function admin_get_service_name($ser_id=NULL,$user_id=NULL,$staff_id=NULL,$modified_by=NULL,$status=NULL){
        $this->loadModel('SalonService');
        $this->loadModel('User');
        $detail_array=array();
        $service_name=$this->SalonService->find('first',array('fields'=>array('eng_display_name','eng_name','service_id'),'conditions'=>array('SalonService.id'=>$ser_id)));
        $user_name_array = $this->User->find('all', array(
                'fields' => array('id','CONCAT(User.first_name, " ",User.last_name) AS name' ),
                'conditions' => array('User.id' => $user_id)));
        $staff_array = $this->User->find('all', array(
                'fields' => array('id','CONCAT(User.first_name, " ",User.last_name) AS name' ),
                'conditions' => array('User.id' => $staff_id)));
        $modified_by_array = $this->User->find('all', array(
                'fields' => array('id','CONCAT(User.first_name, " ",User.last_name) AS name' ),
                'conditions' => array('User.id' => $modified_by)));
        if($status==1){
            $detail_array['status']='confirmed';
        }
        if($status==6){
            $detail_array['status']='InProgress';
        }
        if($status==7){
            $detail_array['status']='Show';
        }
        if($status==8){
            $detail_array['status']='NoShow';
        }
        $detail_array['serviceName']=$service_name['SalonService']['eng_name'];
        $detail_array['userName']=$user_name_array[0][0]['name'];
        $detail_array['staffName']=$staff_array[0][0]['name'];
        $detail_array['modifiedBy']=$modified_by_array[0][0]['name'];
        if(count($detail_array)){
            return $detail_array;   
        }else{
            return;  
        }
    }
/**********************************************************************************    
  @Function Name : admin_printticket
  @Params	 : NULL
  @Description   : The Function to print the appointment ticket
  @Author        : Shiv
  @Date          : 16-Jun-2015
***********************************************************************************/
  
    function admin_printticket($eventId){
        $this->loadModel('User');
        $this->loadModel('Product');
        $this->layout = false;
        $this->Appointment->unbindModel(array('belongsTo' => array('User')), true);
        $this->Appointment->bindModel(array(
                                       'belongsTo' => array(
                                        'User' => 
                                            array('foreignKey' => 'salon_staff_id')
                                    ) )
                                );
        $appointments=$this->Appointment->find('first',array('fields'=>array('id','salon_staff_id','user_id','appointment_start_date','type','status','appointment_price','appointment_comment','User.id','User.first_name','User.last_name','SalonService.eng_name'),'conditions'=>array('Appointment.id'=>$eventId)));
        $customer_details=$this->User->find('first',array('fields'=>array('id','first_name','last_name','email','created','UserDetail.dob','Contact.day_phone','Contact.night_phone','Contact.cell_phone'),'conditions'=>array('User.id'=>$appointments['Appointment']['user_id'])));
        $total_bookings=$this->Appointment->find('count',array('conditions'=>array('Appointment.user_id'=>$appointments['Appointment']['user_id'])));
       $total_price=$this->Appointment->find('all',array('fields'=>array('SUM(Appointment.appointment_price) as total_price'),'conditions'=>array('Appointment.user_id'=>$appointments['Appointment']['user_id'])));
        $this->Appointment->unbindModel(array('belongsTo' => array('User')), true);
        $this->Appointment->bindModel(array(
                                       'belongsTo' => array(
                                        'User' => 
                                            array('foreignKey' => 'salon_staff_id')
                                    ) )
                                );
        $prevoius_appointments=$this->Appointment->find('all',array('fields'=>array('id','salon_staff_id','user_id','appointment_start_date','type','status','appointment_price','appointment_comment','User.id','User.first_name','User.last_name','SalonService.eng_name'),'conditions'=>array('Appointment.user_id'=>$appointments['Appointment']['user_id']),'limit'=>5));
        $this->Product->bindModel(array(
                                       'belongsTo' => array(
                                        'Brand' => 
                                            array('foreignKey' => 'brand_id'),
                                        'ProductType' => 
                                            array('foreignKey' => 'product_type_id')
                                        )
                                    )
                                );
       $prevoius_products=$this->Product->find('all',array('fields'=>array('id','purchase_date','barcode','eng_product_name','quantity','selling_price','Brand.eng_name','ProductType.eng_name'),'conditions'=>array('Product.user_id'=>$appointments['Appointment']['user_id']),'limit'=>5));
       $this->set(compact('appointments','customer_details','total_bookings','total_price','prevoius_appointments','prevoius_products'));
    }

/**********************************************************************************    
  @Function Name : admin_send_appointment_notification
  @Params	 : NULL
  @Description   : The Function to mail user 6 hours before start of appointment
  @Author        : Shiv
  @Date          : 30-Jun-2015
***********************************************************************************/
 
    public function admin_send_appointment_notification(){
        $this->loadModel('SalonEmailSms');
        $date=date('Y-m-d H:i');
        $cur_date= strtotime($date);  
        $new_date = strtotime(date("Y-m-d H:i", strtotime('+6 hours')));
        $appointment_notifications=$this->Appointment->find('all',array('fields'=>array('id','salon_staff_id','user_id','appointment_start_date','type','status','appointment_price','appointment_comment','appointment_title','User.id','User.first_name','User.last_name','SalonService.eng_name'),'conditions'=>array('Appointment.appointment_notification_send'=>0)));
        $log=$this->Appointment->getDataSource()->getLog(false, false);
debug($log); die;  
       print_r($appointment_notifications); die;
       foreach($appointment_notifications as $appointment_notification){
            $this->admin_notify_customer($appointment_notifications['Appointment']['appointment_title'],$appointment_notifications['User']['id'],$appointment_notification['SalonService']['eng_name'],$appointment_notification['Appointment']['appointment_start_date'],$appointment_notification['Appointment']['appointment_duration'],'appointment_notification'); 
        }
    }
/**********************************************************************************    
  @Function Name : admin_check_working_hours
  @Params	 : NULL
  @Description   : The Function to check the working hours of staff
  @Author        : Shiv
  @Date          : 30-Jun-2015
***********************************************************************************/
 
    public function admin_check_working_hours(){
        $this->loadModel('SalonOpeningHour');
        $this->request->data['selectedDay']=$this->request->data['selectedDay'];
        $days=array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
        $getfieldFrom=$days[$this->request->data['selectedDay']].'_'.'from';
        $getfieldTo=$days[$this->request->data['selectedDay']].'_'.'to';
        $Working_hours_array=$this->SalonOpeningHour->find('all',array('fields'=>array('id',$getfieldFrom,$getfieldTo),'conditions'=>array('SalonOpeningHour.user_id'=>$this->request->data['EmpId'])));
        $Working_hours['from']=strtotime($Working_hours_array[0]['SalonOpeningHour'][$getfieldFrom]);
        $Working_hours['to']=strtotime($Working_hours_array[0]['SalonOpeningHour'][$getfieldTo]);
        echo json_encode($Working_hours);
        die;
    }
/**********************************************************************************    
  @Function Name : admin_add_notes
  @Params	 : NULL
  @Description   : The Function to add notes from add appointment popup
  @Author        : Shiv
  @Date          : 24-Sep-2015
***********************************************************************************/
 
    public function admin_add_notes($userId=NULL,$Id=NULL,$editNote=NULL){
        $userId = base64_decode($userId);
        $this->set(compact('userId'));
        $this->loadModel('Note');
        if(isset($this->request->data) && !empty($this->request->data)){
            $this->layout = 'ajax';
            $this->loadModel('Note');
            if(isset($this->request->data['Note']['edit']) && $this->request->data['Note']['edit']=='edit'){
                $update_note = array(
                        'Note' => array(
                            'id'=>$this->request->data['Note']['id'],
                            'category'=>$this->request->data['Note']['category'],
                            'description'=>$this->request->data['Note']['description']
                    )      
                );
                if($this->Note->save($update_note, false, array('category','description'))){
                    $note_history_array = $this->Note->find('all', array(
			'fields' => array(
			    'Note.id','Note.user_id','Note.category','Note.description','Note.created'
			),
                        'conditions' => array('Note.user_id' => $userId,'Note.is_deleted'=>0),
                        'order' => array('Note.id DESC')
                        )
                    );
                    $this->set(compact('note_history_array','userId'));
                    $this->viewPath = "Elements/admin/Appointment";
                    $this->render('note_element');
                }
            }else{
            $note['Note']['user_id'] = $userId;
            $note['Note']['category'] = $this->request->data['Note']['category'];
            $note['Note']['description'] = $this->request->data['Note']['description'];;
            if($this->Note->save($note,false)){
                $note_history_array = $this->Note->find('all', array(
			'fields' => array(
				'Note.id','Note.user_id','Note.category','Note.description','Note.created'
			),
			'conditions' => array('Note.user_id' => $userId,'Note.is_deleted'=>0),
                        'order' => array('Note.id DESC')
                ));
                $this->set(compact('note_history_array','userId'));
                $this->viewPath = "Elements/admin/Appointment";
                $this->render('note_element');
            }
            else{
                $result['data'] = 'fail' ;
                $result['message'] = __('Something went wrong',true);
                echo json_encode($result);
                die;    
            }
        }
    }
    if($editNote=='edit'){
        $edit_note = $this->Note->find('all', array(
		'fields' => array(
			'Note.id','Note.user_id','Note.category','Note.description','Note.created'
		    ),
		'conditions' => array('Note.id' => $Id)
	));
	$this->set(compact('edit_note','userId'));
    }
}
    
/**********************************************************************************    
  @Function Name : admin_search_appointment
  @Params	 : NULL
  @Description   : The Function to search an appointment
  @Author        : Shiv
  @Date          : 15-JUL-2015
***********************************************************************************/
    public function admin_search_appointment(){
        App::import('Controller', 'Bookings');
        $Bookings = new BookingsController;
        if($this->request->is('post') || $this->request->is('put')){
            if($this->request->data['Appointment']['startdate']==''){
                $this->request->data['Appointment']['startdate']=date('Y-m-d');
            }
            $this->loadModel('User');
            $this->loadModel('SalonService');
	    //pr($this->request->data); die;
            for($i=1;$i<=3;$i++){
                if(isset($this->request->data['Appointment']['salon_service_id_'.$i]) && $this->request->data['Appointment']['salon_service_id_'.$i]!='' && isset($this->request->data['Appointment']['salon_staff_id_'.$i]) && $this->request->data['Appointment']['salon_staff_id_'.$i]==''){
                    $staff = $this->Common->get_salon_staff($this->Auth->user('id'));
                    $staff_list=array();
                    foreach($staff as $staff){
                        $staff_list[$staff['User']['id']]=$staff['User']['first_name'].' '.$staff['User']['last_name'];
                        $chars[]=$staff['User']['id'];
                    }
                }elseif(isset($this->request->data['Appointment']['salon_service_id_'.$i]) && $this->request->data['Appointment']['salon_service_id_'.$i]!='' && $this->request->data['Appointment']['salon_staff_id_'.$i]!='' && isset($this->request->data['Appointment']['salon_staff_id_'.$i])){
                    $chars[]=$this->request->data['Appointment']['salon_staff_id_'.$i];
                }
            }
            $chars=array_unique($chars);
            //pr($chars); die;
	    for($t=1;$t<=3;$t++){
                if(isset($this->request->data['Appointment']['salon_service_id_'.$t]) && $this->request->data['Appointment']['salon_service_id_'.$t]!=''){
                    $services=$t;
                   
                    $ServiceName=$this->SalonService->find('first',array('conditions'=>array('SalonService.id'=>$this->request->data['Appointment']['salon_service_id_'.$t]),'fields'=>array('eng_name')));
                    $ser_name[]=$ServiceName['SalonService']['eng_name'];
                    $ser_id[]=$ServiceName['SalonService']['id'];
                }
            }
            $output = $this->admin_sampling($chars, $services);
	    //pr($output); die;
	    //echo $services; die;
            if($services==1){
                for($j=0;$j<count($output);$j++){
                $out=explode('-',$output[$j]);
                for($k=0;$k<count($out);$k++){
                    if($k==0){
                        $m=$k+1;
                        if(isset($this->request->data['Appointment']['salon_service_id_'.$m]) && $this->request->data['Appointment']['salon_service_id_'.$m]!=''){
                            $getAppointmentSlots[$out[0]]=$Bookings->getSearchTimeslots($out[0],$this->Auth->user('id'),$out[0],$this->request->data['Appointment']['startdate'],$this->request->data['Appointment']['salon_service_id_'.$m]);
                            $getAdminSlots=$Bookings->getSearchTimeslots('1','1','1',$this->request->data['Appointment']['startdate'],$this->request->data['Appointment']['salon_service_id_'.$m]);
                        }
                    }
                    $staffDetail[]=$this->User->find('first',array('conditions'=>array('User.id'=>$out[$k])));
                   $count=   count($staffDetail)-1; 
                   $staffDetail[$count]['ser_name']=$ser_name[$k];
                   $staffDetail[$count]['ser_id']=$ser_id[$k];
		    $m++;
                }
                
            }
        }
        
        if($services>1){
            $this->loadModel('SalonCalendarSetting');
            $calsettings = $this->SalonCalendarSetting->find('first',array('fields'=>array('id','calendar_resolution'),'conditions'=>array('SalonCalendarSetting.user_id'=>$this->Auth->user('id'))));
            $resolution=$calsettings['SalonCalendarSetting']['calendar_resolution']*2;
            //pr($output); echo "=====";
	    for($j=0;$j<count($output);$j++){
                $all=array();
                $out=explode('-',$output[$j]);
		//pr($out); die;
                for($k=0;$k<count($out);$k++){
                    $m=$k+1;
                    if(isset($this->request->data['Appointment']['salon_service_id_'.$m]) && $this->request->data['Appointment']['salon_service_id_'.$m]!=''){
                        $getAppointmentSlots[$out[$k]]=$Bookings->getSearchTimeslots($out[0],$this->Auth->user('id'),$out[$k],$this->request->data['Appointment']['startdate'],$this->request->data['Appointment']['salon_service_id_'.$m]);
			//pr($getAppointmentSlots);
                        $getAdminSlots=$Bookings->getSearchTimeslots('1','1','1',$this->request->data['Appointment']['startdate'],$this->request->data['Appointment']['salon_service_id_'.$m]);
                    }
                    if($services==1 && count($getAppointmentSlots[$out[$k]]['timeSlots'])<1){
                        unset($getAppointmentSlots[$out[$k]]['timeSlots']);
                    }
		    //echo $out[$k];
		    $all[]=$getAppointmentSlots[$out[$k]];
                    $staffDetail[]=$this->User->find('first',array('conditions'=>array('User.id'=>$out[$k])));
                    $count=count($staffDetail)-1; 
                    $staffDetail[$count]['ser_name']=$ser_name[$k];
                    $staffDetail[$count]['ser_id']=$ser_id[$k];
                    $m++;
                }
		//pr($all);
		//pr($out);
		//echo $out[0];
		//pr($getAppointmentSlots); die; 
                    
                if(isset($getAppointmentSlots[$out[0]]['timeSlots']) && count($getAppointmentSlots[$out[0]]['timeSlots'])>0){
		   //die("test");
                    if($services>1){
			//pr($all); die;
                        for($t=0;$t<count($all);$t++){
                            if(isset($all[$t]['timeSlots']['morning'][0])){
                                $mrng[$t]=$all[$t]['timeSlots']['morning'][0];
                            }elseif(isset($all[$t]['timeSlots']['afternoon'][0])){
                                $mrng[$t]=$all[$t]['timeSlots']['afternoon'][0];
                            }elseif(isset($all[$t]['timeSlots']['evening'][0])){
                                $mrng[$t]=$all[$t]['timeSlots']['evening'][0];
                            }
                            if(isset($all[$t]['timeSlots']['evening']) && !empty($all[$t]['timeSlots']['evening'])){
                                $errors = array_filter($all[$t]['timeSlots']['evening']);
                                if(!empty($errors)){
                                    $evng[$t]=$all[$t]['timeSlots']['evening'][count($all[$t]['timeSlots']['evening'])-1];
                                }else{
                                    $evng[$t]=$all[$t]['timeSlots']['evening'][0];
                                }
                            }elseif(isset($all[$t]['timeSlots']['afternoon'])){
                                if(count($all[$t]['timeSlots']['afternoon'])>0){
                                    $evng[$t]=$all[$t]['timeSlots']['afternoon'][count($all[0]['timeSlots']['afternoon'])-1];
                                }else{
                                    $evng[$t]=$all[$t]['timeSlots']['afternoon'][0];
                                }
                            }elseif(isset($all[$t]['timeSlots']['morning'])){
                                if(count($all[$t]['timeSlots']['morning'])>0){
                                    $evng[$t]=$all[$t]['timeSlots']['morning'][count($all[0]['timeSlots']['morning'])-1];
                                }else{
                                    $evng[$t]=$all[$t]['timeSlots']['morning'][0];
                                }
                            }
                        }
			//echo 'mrng>>>>>>>>'; pr($mrng);
			//echo 'evng>>>>>>>>'; pr($evng); 
                        for($m=0;$m<count($mrng)-1;$m++){
                            if(strtotime($mrng[$m])>strtotime($mrng[$m+1])){  
                                $start_time_slot=$mrng[$m];
                            }else{
                                $start_time_slot=$mrng[$m+1];
                            }
                            if(strtotime($evng[$m])>strtotime($evng[$m+1])){  
                                $end_time_slot=$evng[$m+1];
                            }else{
                                $end_time_slot=$evng[$m];
                            }
                        }
			//die;
			//pr($start_time_slot); die;
                        if(isset($start_time_slot)){
			while(strtotime($start_time_slot)<strtotime($end_time_slot)){
                            if(strtotime($start_time_slot)<strtotime('12:00 PM') && strtotime($start_time_slot)>strtotime('12:00 AM')){
                                $timeSlots[$j]['timeSlots']['morning'][]=$start_time_slot;
                                $start_time_slot=strtotime(date('H:i',strtotime($start_time_slot)));
                                $start_time_slot = date("h:i A", strtotime('+'.$resolution.' minutes', $start_time_slot));
                            }
                            if(strtotime($start_time_slot)<strtotime('04:00 PM') && strtotime($start_time_slot)>=strtotime('12:00 PM')){
                                $timeSlots[$j]['timeSlots']['afternoon'][]=$start_time_slot;
                                $start_time_slot=strtotime(date('H:i',strtotime($start_time_slot)));
                                $start_time_slot = date("h:i A", strtotime('+'.$resolution.' minutes', $start_time_slot));
                            }
                            if(strtotime($start_time_slot)>=strtotime('04:00 PM') && strtotime($start_time_slot)<=strtotime('11:59 PM')){
                                $timeSlots[$j]['timeSlots']['evening'][]=$start_time_slot;
                                $start_time_slot=strtotime(date('H:i',strtotime($start_time_slot)));
                                $start_time_slot = date("h:i A", strtotime('+'.$resolution.' minutes', $start_time_slot));
                            }
                        }}
                    }
                }
            }
            
        }
        if($services>1){
            $getAppointmentSlots=$timeSlots;
        }
        $ServiceName=$this->SalonService->find('first',array('conditions'=>array('SalonService.id'=>$this->request->data['Appointment']['salon_service_id_1']),'fields'=>array('eng_name')));
            if($services==1){
                $this->set(compact('getAppointmentSlots','time','staffDetail','ServiceName','Price','services'));
                $this->viewPath = "Elements/admin/Appointment";
                $this->render('appointment_search_single_timeslots');
            }else{
                $this->set(compact('output','getAppointmentSlots','time','staffDetail','ServiceName','Price','services'));
                $this->viewPath = "Elements/admin/Appointment";
                $this->render('appointment_search_timeslots');
            }
        }
        $this->loadModel('User');
        App::import('Controller', 'Users');
        $this->Users = new UsersController;
        $staffServices = $this->Common->getStaffServiceList($this->Auth->user('id'), $this->Auth->user('id'));
        $userList = $this->Users->findallCustomerList();
        $staff = $this->Common->get_salon_staff($this->Auth->user('id'));
        $staff_list=array();
        foreach($staff as $staff){
            $staff_list[$staff['User']['id']]=$staff['User']['first_name'].' '.$staff['User']['last_name'];
        }
        $this->set(compact('userList','staffServices','staff_list','employeeId','time','user_id','service_id','appointmentId','editType'));
    }
    
    
/**********************************************************************************    
  @Function Name : admin_add_appointment_slots
  @Params	 : NULL
  @Description   : The Function to add slots in slot table
  @Author        : Shiv
  @Date          : 16-JUL-2015
***********************************************************************************/
    public function admin_add_appointment_slots($app_id=NULL,$startDate=NULL,$duration=NULL,$salon_id=NULL,$repeat_type=NULL,$repeat_end_date=NULL,$repeat_day=NULL,$repeat_weeks=NULL,$repeat_month_date=NULL,$yearly_repeat_month_date=NULL,$repeat_month=NULL){
        $this->loadModel('AppointmentSlot');
        $slots['AppointmentSlot']['appointment_id']=$app_id;
        $slots['AppointmentSlot']['startdate']=$startDate;
        $slots['AppointmentSlot']['salon_id']=$salon_id;
        if($repeat_type==1){
            $end_time = strtotime("+".$duration ."minutes",strtotime($startDate));
            $start_date=date('Y-m-d H:i',$startDate);
            $start = strtotime(date("Y-m-d",$startDate));
            $start_time=date("H:i",$startDate);
            $end = strtotime($repeat_end_date);
            $repeat_days = ($end - $start)  / (60 * 60 * 24);
            for($i=0;$i<=$repeat_days;$i++){
                if($i==0){
                    $slots['AppointmentSlot']['startdate']=$startDate;
                }else{
                    $start_date = strtotime(date('Y-m-d H:i', strtotime($start_date . ' +1 day')));    
                     $slots['AppointmentSlot']['startdate']=$start_date;
                     $start_date=date('Y-m-d H:i',$start_date);
                }
                $this->AppointmentSlot->create();
                $this->AppointmentSlot->save($slots);
            }
        }
        if($repeat_type==2){
            $start_date=date("Y-m-d",$startDate);
            $start_date=strtotime($start_date); 
            $time=date("H:i", $startDate); 
            $repeat_days_array=array('1'=>'sunday','2'=>'monday','3'=>'tuesday','4'=>'wednesday','5'=>'thrusday','6'=>'friday','7'=>'saturday');
            for($i=1;$i<=count($repeat_days_array);$i++){
                if($repeat_day==$i){
                    $week_day='next'.' '.$repeat_days_array[$i];
                }
            }
            $str=strtotime($week_day .' '.$time, $startDate);
            $chk_day=date('N',$startDate);
            if($chk_day+1==$repeat_day){
                $str1= date("Y-m-d",$startDate);
                $str=strtotime($str1.' '.$time);
            }
            $slots['AppointmentSlot']['startdate']=$str;
            $this->AppointmentSlot->save($slots);
            $repeat_end_date = str_replace('/', '-', $repeat_end_date);
            $date=$repeat_end_date.' '.$time;
            $end_date=strtotime($date);
            while($str<$end_date){
                $str = strtotime(date("Y-m-d $time", $str) . " +".$repeat_weeks." week");
                $slots['AppointmentSlot']['startdate']=$str;
                $this->AppointmentSlot->create();
                $this->AppointmentSlot->save($slots);
            }
        }
    if($repeat_type==3){
        $StartDate=date("Y-m-d",$startDate);
        $start_date= strtotime($StartDate);
        $time=date("H:i", $startDate);
        $day=date("d", $startDate);
        $k=0;
        $repeat_end_date = str_replace('/', '-', $repeat_end_date);
        $start_day=$startDate;
        while(strtotime($repeat_end_date)>=$start_day){
            if($k==0){
                if($repeat_month_date>$day){
                    $add_days= $repeat_month_date-$day;
                    $StartDate= date('Y-m-d',$startDate);  
                    $StartDate = date('Y-m-d',strtotime($StartDate . "+".$add_days."days")); 
                    $StartDate=strtotime($StartDate.''.$time);
                    $start_date= date("Y-m-d H:i", $StartDate);
                }elseif($repeat_month_date==$day){
                    $StartDate= date('Y-m-d',$startDate); 
                    $StartDate=strtotime($StartDate.''.$time);
                    $start_date= date("Y-m-d H:i", $StartDate);
                }elseif($repeat_month_date<$day){
                    $add_days= $day-$repeat_month_date; 
                    $StartDate= date('Y-m-d',$startDate); 
                    $StartDate = date('Y-m-d',strtotime($StartDate . "-".$add_days."days"));
                    $StartDate=strtotime($StartDate.''.$time);
                    $start_date= date("Y-m-d H:i", $StartDate) . "+1 month";
                }
                $repeat_date=$start_date;
                $compare_date=$start_date;
                $start_day=strtotime($start_date);
                }else{
                    $start_day=date("Y-m-d", $start_day);
                    $start_day=strtotime($start_day.' '.$time);
                    $compare_date=$start_day;
                    $start_day= strtotime(date("Y-m-d H:i", $start_day) . "+1 month");
                    $start_day_in=$start_day;
                }
                $startDate=$start_day;
                $slots['AppointmentSlot']['startdate']=$start_day;
                $k++;
                $this->AppointmentSlot->create();
                $this->AppointmentSlot->save($slots);
            }
        }
        if($repeat_type==4){
            $StartDate=date("Y-m-d",$startDate);  
            $StartDate=strtotime($StartDate);
            $time=date("H:i", $startDate);
            $day=$yearly_repeat_month_date; 
            $month=date("m", $startDate); 
            $year=date("Y", $startDate);  
            $h=0;
            $repeat_end_date = str_replace('/', '-', $repeat_end_date);
            while(strtotime($repeat_end_date)>=strtotime(date('Y-m-d',$StartDate))){ 
                if($h==0){
                    if($month<=$repeat_month){
                        $repeat_date=$day.'-'.$repeat_month.'-'.$year; 
                    }else{
                        $year=$year+1;
                        $repeat_date=$day.'-'.$repeat_month.'-'.$year; 
                    }
                    $start_date=$repeat_date.''.$time;
                    $start_day=strtotime($repeat_date.''.$time); 
                }else{
                    $start_day=date("Y-m-d", $start_day);
                    $start_day=strtotime($start_day.' '.$time);
                    $start_day= strtotime(date("Y-m-d H:i", $start_day) . "+1 years");
                    $start_day_year_in=$start_day;
                }
                $StartDate=$start_day;
                $slots['AppointmentSlot']['startdate']=$start_day;
                $h++;
                $this->AppointmentSlot->create();
                $this->AppointmentSlot->save($slots);
            }
        }
    }
/**********************************************************************************    
  @Function Name : admin_sampling
  @Params	 : NULL
  @Description   : The Function to make group of providers in search
  @Author        : Shiv
  @Date          : 21-JUL-2015
***********************************************************************************/
    public function admin_sampling($chars, $size, $combinations = array()) {
        if (empty($combinations)) {
            $combinations = $chars;
        }
        if ($size == 1) {
            return $combinations;
        }
        $new_combinations = array();
        foreach ($combinations as $combination) {
            foreach ($chars as $char) {
                $new_combinations[] = $combination .'-' .$char;
            }
        }
        return $this->admin_sampling($chars, $size - 1, $new_combinations);
    }
/**********************************************************************************    
  @Function Name : admin_add_search_appointment
  @Params	 : NULL
  @Description   : The Function to add forward an appointment
  @Author        : Shiv
  @Date          : 16-Mar-2015
***********************************************************************************/
    public function admin_add_search_appointment($user_id=NULL,$ser=NULL,$time=NULL,$fromTime=NULL){
        $this->loadModel('User');
        parse_str($ser, $serarray);
        if($serarray['data']['Appointment']['startdate']==''){
            $serarray['data']['Appointment']['startdate']=date("Y-m-d");
        }
        if(isset($this->request->data) && !empty($this->request->data)){
            $employee_name = $this->User->find('first',array('fields'=>array('first_name','last_name'),'conditions'=>array('User.id'=>$user_id)));
            $customer_name=$employee_name['User']['first_name'].' '.$employee_name['User']['last_name'];
            $salon_service_name=$this->Common->get_salon_service_name($serarray['data']['Appointment']['salon_service_id_1']);
            $appointment_title=$customer_name.'-'.$salon_service_name;
            for($i=1;$i<=3;$i++){
                if(isset($this->request->data['Appointment']['salon_service_id_'.$i])){
                    $add_search_appointment['Appointment']['appointment_title']=$appointment_title;
                    $add_search_appointment['Appointment']['salon_staff_id']=$this->request->data['Appointment']['salon_staff_id_'.$i];
                    $add_search_appointment['Appointment']['user_id']=$this->request->data['Appointment']['user_id'];
                    $add_search_appointment['Appointment']['salon_service_id']=$this->request->data['Appointment']['salon_service_id_'.$i];
                    $add_search_appointment['Appointment']['status']=1;
                    $add_search_appointment['Appointment']['type']='A';
                    $add_search_appointment['Appointment']['appointment_start_date']=$this->request->data['Appointment']['appointment_start_date'];
                    $add_search_appointment['Appointment']['created']=date('Y-m-d h:m:s');
                    $this->Appointment->create();
                    $added=$this->Appointment->save($add_search_appointment);
                }
            }
            if( $added){
                $edata['data'] = 'success' ;
                $edata['message'] = __('Appointment forward successfully',true);
                echo json_encode($edata);
                die;
            }
        }
        $time=str_replace("-",":",$time);
        $startdate=strtotime($serarray['data']['Appointment']['startdate'].' '.$time);
        for($i=1;$i<=3;$i++){
            if(!empty($serarray['data']['Appointment']['salon_service_id_'.$i])){
                $serviceName['name'][]=$this->Common->get_salon_service_name($serarray['data']['Appointment']['salon_service_id_'.$i]);
                $serviceName['id'][]=$serarray['data']['Appointment']['salon_service_id_'.$i];
                
            }
        }
        $service_provider = $this->User->find('first',array('fields'=>array('first_name','last_name'),'conditions'=>array('User.id'=>$user_id)));
        if($service_provider['User']['first_name']!=''){
            $serviceProviderName=$service_provider['User']['first_name'].' '.$service_provider['User']['last_name'];
        }else{
            echo $user_id; die;
        }
        echo $service_provider['User']['first_name'];
        $this->set(compact('serarray','user_id','appId','time','serviceName','serviceProviderName','price','startdate'));
    }
/**********************************************************************************    
  @Function Name : admin_chnge_front_book_status
  @Params	 : NULL
  @Description   : The Function to change status of frontend booked appointment
  @Author        : Shiv
  @Date          : 16-Sep-2015
***********************************************************************************/
 
    function admin_chnge_front_book_status(){
        if($this->request->is('ajax')){
            $this->loadModel('Order');
            $this->layout = 'ajax';
            $order_id_array = $this->Appointment->find('first',array('fields'=>array('order_id','appointment_title','user_id','salon_service_id','appointment_start_date','appointment_duration'),'conditions'=>array('Appointment.id'=>$this->request->data['id'])));
	    //pr($order_id_array); die;
	    $appointment_title=$order_id_array['Appointment']['appointment_title'];
	    $user_id=$order_id_array['Appointment']['user_id'];
            $order_id=$order_id_array['Appointment']['order_id'];
	    $salon_service_name=$this->Common->get_salon_service_name($order_id_array['Appointment']['salon_service_id']);
	    $startTime=$order_id_array['Appointment']['appointment_start_date'];
	     $duration=$order_id_array['Appointment']['appointment_duration'];
           
	    
	    
	    
            if(isset($order_id) && !empty($order_id)){
                $orders = $this->Appointment->find('all',array('fields'=>array('id','order_id'),'conditions'=>array('Appointment.order_id'=>$order_id)));
            }
            if(count($orders)>0){
                foreach($orders as $order){
                    $change_status_array = array(
                        'Appointment' => array(
                        'id'=>$order['Appointment']['id'],
                        'status'=>3,
                        )
                    );
                    
                    $update_order = array(
                        'Order' => array(
                            'id'=>$order['Appointment']['order_id'],
                            'order_avail_status'=>1,
                        )
                    );
                    
                    $this->Appointment->save($change_status_array, false, array('status'));
                    $this->Order->save($update_order, false, array('order_avail_status'));
                }
		$this->admin_notify_customer($appointment_title,$user_id,$salon_service_name,$startTime,$duration,'add_review','customer');
		//$this->admin_notify_customer($appointment_title,$staff[$st]['User']['id'],$salon_service_name,$startTime,$duration,'cancel_backend_appointment'); 
            }else{
                $change_status_array = array(
                    'Appointment' => array(
                    'id'=>$this->request->data['id'],
                    'status'=>3,
                    )
                );
                $update_order = array(
                        'Order' => array(
                            'id'=>$order_id,
                            'order_avail_status'=>1,
                        )
                    );
                if($this->Appointment->save($change_status_array, false, array('status'))){
                    $this->Order->save($update_order, false, array('order_avail_status'));
		    
		    $this->admin_notify_customer($appointment_title,$user_id,$salon_service_name,$startTime,$duration,'add_review','customer');
		    
		    
                    echo "1"; die;
                }else{
                    echo "0"; die;
                }
            }
            echo "1"; die;
        }
    }
/**********************************************************************************    
  @Function Name : admin_saveAppointmentHistory
  @Params	 : NULL
  @Description   : The Function to save appointment history
  @Author        : Shiv
  @Date          : 16-Sep-2015
***********************************************************************************/
 
    function admin_saveAppointmentHistory($data){
        $this->loadModel('AppointmentHistory');
        $this->AppointmentHistory->save($data,false);
    }
/**********************************************************************************    
  @Function Name : admin_delete_notes
  @Params	 : NULL
  @Description   : The Function to delete notes
  @Author        : Shiv
  @Date          : 16-Sep-2015
***********************************************************************************/

    function admin_delete_notes(){
        $this->loadModel('Note');
        $delete_array = array(
                'Note' => array(
                    'id'=>$this->request->data['note_id'],
                    'is_deleted'=>1,
                )
            );
        if($this->Note->save($delete_array, false, array('is_deleted'))){
            $note_history_array = $this->Note->find('all', array(
		    'fields' => array(
			'Note.id','Note.user_id','Note.category','Note.description','Note.created'
		    ),
                    'conditions' => array('Note.user_id' => base64_decode($this->request->data['user_id']),'Note.is_deleted'=>0),
                    'order' => array('Note.id DESC')
                )
            );
            $this->set('userId',$this->request->data['user_id']);
            $this->set(compact('note_history_array'));
            $this->viewPath = "Elements/admin/Appointment";
            $this->render('note_element');
        }
    }
}