<?php
class ImageComponent extends Component {

    public $helpers = array('Session', 'Html', 'Form');	//An array containing the names of helpers this controller uses. 
    public $components = array('Session','Email','Cookie');	//An array containing the names of components this controller uses.


/**************************************************************************************************************
    @Function Name  : upload_image
    @Params	    : 
    @Author         : Aman Gupta
    @date           : 13-Nov-2014
****************************************************************************************************************/
    function upload_image($file,$model,$user_id,$fullpath=TRUE){
        if($file && $model && $user_id){
            $check_error = $this->check_error($file);
            if($check_error){
                list($width, $height, $type, $attr) = getimagesize($file["tmp_name"]);
                $parts = pathinfo($file['name']);
                $ext = strtolower($parts['extension']);
                if($fullpath){
                    $destination_path = WWW_ROOT . "images/$user_id/";    
                }
                else{
                    $destination_path = WWW_ROOT . "images/";
                }
                
                $dirReturn = $this->makedir($destination_path);
                
                if($dirReturn){
                    $destination_path = $destination_path.$model."/";
                    
                    $dirReturn = $this->makedir($destination_path);
                    
                    if($dirReturn){
                        $rand = rand();
                        $time_stamp = strtotime(date('Y-m-d H:i:s'));
                        $its_name = $rand.'_'.$time_stamp.'_'.$user_id. '.' . $ext;
                        //$imageName = $this->uploadResizeImage($file,$its_name);
                        $imageName = $this->upImage($file,$destination_path,$its_name,$model);
                                              //  pr($imageName);exit;

                        if($imageName){
                            //echo 'dsf';die;
                            return $imageName;
                        }
                        else{
                            return 0;
                        }    
                    }else{
                        return 0;
                    }
                }else{
                        return 0;
                }
            }else{
                return 0;
            }
        }else{
            return 0 ;
        }
    }
    
    /**************************************************************************************************************
    @Function Name  : upload_image
    @Params	    : 
    @Author         : Aman Gupta
    @date           : 13-Nov-2014
****************************************************************************************************************/
    function upload_service_image($file,$model,$user_id,$fullpath=TRUE){
        if($file && $model && $user_id){
            $check_error = $this->check_error($file);
            if($check_error){
                list($width, $height, $type, $attr) = getimagesize($file["tmp_name"]);
                $parts = pathinfo($file['name']);
                $ext = strtolower($parts['extension']);
                if($fullpath){
                    $destination_path = WWW_ROOT . "images/$user_id/";    
                }
                else{
                    $destination_path = WWW_ROOT . "images/";
                }
                
                $dirReturn = $this->makedir($destination_path);
                
                if($dirReturn){
                    $destination_path = $destination_path.$model."/";
                    
                    $dirReturn = $this->makedir($destination_path);
                    
                    if($dirReturn){
                        $rand = rand();
                        $time_stamp = strtotime(date('Y-m-d H:i:s'));
                        $its_name = $rand.'_'.$time_stamp.'_'.$user_id. '.' . $ext;
                        //$imageName = $this->uploadResizeImage($file,$its_name);
                        $imageName = $this->up_service_image($file,$destination_path,$its_name,$model);
                        if($imageName){
                            //echo $imageName;
                            return $imageName;
                        }
                        else{
                            return 0;
                        }    
                    }else{
                        return 0;
                    }
                }else{
                        return 0;
                }
            }else{
                return 0;
            }
        }else{
            return 0 ;
        }
    }
    
     /**************************************************************************************************************
    @Function Name  : check_custom_image
    @Params	    : 
    @Author         : Aman Gupta
    @date           : 13-Nov-2014
****************************************************************************************************************/
    function check_custom_image($file,$model,$user_id,$fullpath=TRUE , $name=null){
          list($width, $height, $type, $attr) = getimagesize($file["tmp_name"]);
                if($name === 'salon_cover_image'){
                    $minimum_width = 1600;
                    $minimum_height = 800;
                    $minimum_size = 400;
                    $size = $file['size'];
                    $limit_size = round($size / 1024);
                    //echo $limit_size;exit;
                    if($limit_size <= $minimum_size){
                        if($width > 1600 && $height >800){
                            $ratio = $width / $height;
                            if($ratio == 2){
                              return  $this->upload_custom_image($file,$model,$user_id,$fullpath=TRUE);
                            }else{
                                return 'ratio';
                            }
                        }if($width == 1600 && $height == 800){
                            //echo 'here';exit;
                                return $this->upload_image($file,$model,$user_id,$fullpath=TRUE);

                        }else if($width < 1600 || $height < 800){
                            return 'limit';
                        }    
                        
                    }else{
                        return 'size';
                    }
                }if($name === 'logo'){
                    $minimum_width = 400;
                    $minimum_height = 200;
                    $minimum_size = 100;
                    $size = $file['size'];
                    $limit_size = round($size / 1024);
                    //echo $limit_size;exit;
                    if($limit_size <= $minimum_size){
                        if($width > 400 && $height > 200){
                            $ratio = $width / $height;
                            if($ratio == 2){
                              return  $this->upload_custom_image($file,$model,$user_id,$fullpath=TRUE);
                            }else{
                                return 'ratio';
                            }
                        }if($width == 400 && $height == 200){
                            //echo 'here';exit;
                                return $this->upload_image($file,$model,$user_id,$fullpath=TRUE);

                        }else if($width < 400 || $height < 200){
                            return 'limit';
                        }    
                        
                    }else{
                        return 'size';
                    }
                }
    }
    
    /**************************************************************************************************************
    @Function Name  : upload_custom_image
    @Params	    : 
    @Author         : Aman Gupta
    @date           : 13-Nov-2014
****************************************************************************************************************/
    function upload_custom_image($file,$model,$user_id,$fullpath=TRUE){
        if($file && $model && $user_id){
            $minimum_width = $minimum_height = $minimum_size = $ratio = '';
            $check_error = $this->check_error($file);
            if($check_error){
                $parts = pathinfo($file['name']);
                $ext = strtolower($parts['extension']);
                if($fullpath){
                    $destination_path = WWW_ROOT . "images/$user_id/";    
                }
                else{
                    $destination_path = WWW_ROOT . "images/";
                }
                
                $dirReturn = $this->makedir($destination_path);
                
                if($dirReturn){
                    $destination_path = $destination_path.$model."/";
                    
                    $dirReturn = $this->makedir($destination_path);
                    
                    if($dirReturn){
                        $rand = rand();
                        $time_stamp = strtotime(date('Y-m-d H:i:s'));
                        $its_name = $rand.'_'.$time_stamp.'_'.$user_id. '.' . $ext;
                        //$imageName = $this->uploadResizeImage($file,$its_name);
                        $imageName = $this->up_image($file,$destination_path,$its_name,$model,'');
                        if($imageName){
                            return $imageName;
                        }
                        else{
                            return 0;
                        }    
                    }else{
                        return 0;
                    }
                }else{
                        return 0;
                }
            }else{
                return 0;
            }
        }else{
            return 0 ;
        }
    }
    
    
    /**************************************************************************************************************
    @Function Name  : up_image
    @Params	    : $file array , $destination_path , $its_name(imnage Name)
    @Author         : Aman Gupta
    @date           : 14-Nov-2014
****************************************************************************************************************/        
    function up_image($file,$destination_path,$its_name,$modelName ,$name=null){
            list($width, $height, $type, $attr) = getimagesize($file["tmp_name"]);
            $org_destination_path = $destination_path.'original/';
            $dirReturn = $this->makedir($org_destination_path);
            if($dirReturn){
                $org_image = $org_destination_path . $its_name;
                if(move_uploaded_file($file["tmp_name"], $org_image))
                {
                //resized image
                        
                        $e_destination_path = $destination_path.'resized/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
			    //chmod($e_destination_path,0777);
                            $this->navResize($org_image, $e_destination_path.$its_name, "554", "310");
                        }
                        if($modelName == 'Salon')
                        {
                            //for 1600/800
                            //echo 'sdfs';exit;
                            $e_destination_path = $destination_path.'1600/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                $this->getResize($height, $width, "1600", $org_image, $e_destination_path.$its_name);
                            }
                            
                             //for 800/400
                            
                            $e_destination_path = $destination_path.'400/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                $this->getResize($height, $width, "400", $org_image, $e_destination_path.$its_name);
                            }
                            
                          
                            //for 350/175
                            
                            $e_destination_path = $destination_path.'175/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                $this->getResize($height, $width, "175", $org_image, $e_destination_path.$its_name);
                            }
                            
                            //for 1423/476
                            $e_destination_path = $destination_path.'1423/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                //$this->navResize($org_image, $e_destination_path.$its_name, "1423", "476");
                                $this->getResize($height, $width, "1423", $org_image, $e_destination_path.$its_name);
                            }
                            //for 353/118
                            $e_destination_path = $destination_path.'353/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                //chmod($e_destination_path,0777);
								$this->navResize($org_image, $e_destination_path.$its_name, "353", "118");
                            }
                            //for 499/167
                            $e_destination_path = $destination_path.'499/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
								//chmod($e_destination_path,0777);
                                $this->navResize($org_image, $e_destination_path.$its_name, "499", "167");
                            }
                        }
                        //end
                        $e_destination_path = $destination_path.'800/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
                            $this->getResize($height, $width, "800", $org_image, $e_destination_path.$its_name);
                        }
                        $e_destination_path = $destination_path.'400/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
                            $this->getResize($height, $width, "400", $org_image, $e_destination_path.$its_name);
                        }
                        
                        $e_destination_path = $destination_path.'200/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
                            $this->getResize($height, $width, "200", $org_image, $e_destination_path.$its_name);
                        }
                        
                        
                        $e_destination_path = $destination_path.'500/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
                            $this->getResize($height, $width, "500", $org_image, $e_destination_path.$its_name);
                        }
                        $e_destination_path = $destination_path.'350/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
                            $this->getResize($height, $width, "350", $org_image, $e_destination_path.$its_name);
                        }
                        $e_destination_path = $destination_path.'150/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
                            $this->getResize($height, $width, "200", $org_image, $e_destination_path.$its_name);
                        }
                        $e_destination_path = $destination_path.'50/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
                            $this->getResize($height, $width, "50", $org_image, $e_destination_path.$its_name);
                        }
                        return $its_name;    
                }
                else{
                    return 0;
                }
            }else{
                return 0;
            }
          
    }
    
     /**************************************************************************************************************
    @Function Name  : up_image
    @Params	    : $file array , $destination_path , $its_name(imnage Name)
    @Author         : Aman Gupta
    @date           : 14-Nov-2014
****************************************************************************************************************/        
    function up_service_image($file,$destination_path,$its_name,$modelName ,$name=null){
            list($width, $height, $type, $attr) = getimagesize($file["tmp_name"]);
            $org_destination_path = $destination_path.'original/';
            $dirReturn = $this->makedir($org_destination_path);
            if($dirReturn){
                $org_image = $org_destination_path . $its_name;
                if(move_uploaded_file($file["tmp_name"], $org_image))
                {     
                    $e_destination_path = $destination_path.'resized/';
                    $dirReturn = $this->makedir($e_destination_path);
                    if ($dirReturn) {
			//chmod($e_destination_path,0777);
                        $this->navResize($org_image, $e_destination_path.$its_name, "554", "310");
                    }
                        if($modelName == 'Service')
                        {
                            $e_destination_path = $destination_path.'800/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                $this->getResize($height, $width, "800", $org_image, $e_destination_path.$its_name);
                            }
                                $e_destination_path = $destination_path.'500/';
                                $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                    $this->getResize($height, $width, "500", $org_image, $e_destination_path.$its_name);
                            }
                            $e_destination_path = $destination_path.'350/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                $this->getResize($height, $width, "350", $org_image, $e_destination_path.$its_name);
                            }
                            $e_destination_path = $destination_path.'150/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                $this->getResize($height, $width, "200", $org_image, $e_destination_path.$its_name);
                            }
                            $e_destination_path = $destination_path.'50/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                $this->getResize($height, $width, "50", $org_image, $e_destination_path.$its_name);
                            }
                        }else if($modelName == 'User'){
                           // echo 'sf';die;
                            $e_destination_path = $destination_path.'400/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                $this->getResize($height, $width, "558", $org_image, $e_destination_path.$its_name);
                            }
                            $e_destination_path = $destination_path.'200/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                $this->getResize($height, $width, "320", $org_image, $e_destination_path.$its_name);
                            }
                            $e_destination_path = $destination_path.'350/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                $this->getResize($height, $width, "350", $org_image, $e_destination_path.$its_name);
                            }
                            $e_destination_path = $destination_path.'50/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                $this->getResize($height, $width, "50", $org_image, $e_destination_path.$its_name);
                            }
                        }
                      
                        return $its_name;    
                }
                else{
                    return 0;
                }
            }else{
                return 0;
            }
          
    }
   

/**************************************************************************************************************
    @Function Name  : upImage
    @Params	    : $file array , $destination_path , $its_name(imnage Name)
    @Author         : Aman Gupta
    @date           : 14-Nov-2014
****************************************************************************************************************/        
    function upImage($file,$destination_path,$its_name,$modelName){
            list($width, $height, $type, $attr) = getimagesize($file["tmp_name"]);
            $org_destination_path = $destination_path.'original/';
            $dirReturn = $this->makedir($org_destination_path);
            if($dirReturn){
                $org_image = $org_destination_path . $its_name;
                if(move_uploaded_file($file["tmp_name"], $org_image))
                {
                        //resized image
                        $e_destination_path = $destination_path.'resized/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
			    //chmod($e_destination_path,0777);
                            $this->navResize($org_image, $e_destination_path.$its_name, "554", "310");
                        }
                        if($modelName == 'Salon')
                        {
                            //for 1600/800

                            $e_destination_path = $destination_path.'1600/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {

                                $this->getResize('800', '1600', "1600", $org_image, $e_destination_path.$its_name);
                            }
                            
                            //for 1423/476
                            $e_destination_path = $destination_path.'1423/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                //$this->navResize($org_image, $e_destination_path.$its_name, "1423", "476");
                                $this->getResize($height, $width, "1423", $org_image, $e_destination_path.$its_name);
                            }
                            //for 353/118
                            $e_destination_path = $destination_path.'353/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
                                //chmod($e_destination_path,0777);
								$this->navResize($org_image, $e_destination_path.$its_name, "353", "118");
                            }
                            //for 499/167
                            $e_destination_path = $destination_path.'499/';
                            $dirReturn = $this->makedir($e_destination_path);
                            if ($dirReturn) {
								//chmod($e_destination_path,0777);
                                $this->navResize($org_image, $e_destination_path.$its_name, "499", "167");
                            }
                        }
                        //end
                        $e_destination_path = $destination_path.'800/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
                            $this->getResize($height, $width, "800", $org_image, $e_destination_path.$its_name);
                        }
                        $e_destination_path = $destination_path.'500/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
                            $this->getResize($height, $width, "500", $org_image, $e_destination_path.$its_name);
                        }
                        $e_destination_path = $destination_path.'350/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
                            $this->getResize($height, $width, "350", $org_image, $e_destination_path.$its_name);
                        }
                        $e_destination_path = $destination_path.'150/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
                            $this->getResize($height, $width, "200", $org_image, $e_destination_path.$its_name);
                        }
                        $e_destination_path = $destination_path.'50/';
                        $dirReturn = $this->makedir($e_destination_path);
                        if ($dirReturn) {
                            $this->getResize($height, $width, "50", $org_image, $e_destination_path.$its_name);
                        }
                        return $its_name;    
                }
                else{
                    return 0;
                }
            }else{
                return 0;
            }
          
    }
    
    
/**************************************************************************************************************
    @Function Name  : uploadResizeImage
    @Params	    : $file array , $destination_path , $its_name(imnage Name)
    @Author         : Navish Kumar
    @date           : 24-April-2014
****************************************************************************************************************/        
    function uploadResizeImage($file,$its_name){
            list($width, $height, $type, $attr) = getimagesize($file["tmp_name"]);
            $destination_path = WWW_ROOT . "images/staff/";
            if($destination_path){
                $org_image = $destination_path.'original/' . $its_name;
                if(move_uploaded_file($file["tmp_name"], $org_image))
                {
                        
                        $imgdestination_path = $destination_path.'resized/'.$its_name;
                        //chmod($destination_path.'resized/',0777);
						if ($imgdestination_path) {
                            $this->navResize($org_image, $imgdestination_path, "554", "310");
                        }
                        return $its_name;    
                }
                else{
                    return 0;
                }
            }else{
                return 0;
            }
          
    }    
    
/**************************************************************************************************************
    @Function Name  : makedir
    @Params	    : $folder Path
    @Author         : Aman Gupta
    @date           : 14-Nov-2014
****************************************************************************************************************/ 
    function makedir($path){
        if (!file_exists($path)) {
                    if(mkdir($path, 0777)){
                        return 1;
                    }
                    else{
                        return 0;
                    }
            }
            else{
                return 1;
            }
    }
/**************************************************************************************************************
    @Function Name  : check_error
    @Params	    : $file array
    @Author         : Aman Gupta
    @date           : 14-Nov-2014
****************************************************************************************************************/    
    function check_error($file){
        if ($file['error'] == 0) {
            if ($file['type'] == 'image/jpeg' || $file['type'] == 'image/png' || $file['type'] == 'image/gif' || $file['type'] == 'image/pjpeg') {
                return 1;
            }
            else{
                return 0;
            }
        }
        else{
            return 0;
        }
    }
    
/**************************************************************************************************************
    @Function Name : getResize
    @Params	       : NULL
    @Author         : Aman Gupta
    @date           : 13-Nov-2014
****************************************************************************************************************/

    public function getResize($height, $width, $new_dimension_pass, $filename_pass, $upload_path) {

        //Get Extension
        $extension = $this->getExtension($upload_path);
        $extension = strtolower($extension);

        //Scale To Ratio
        if ($width >= $height) {
            $new_width = $new_dimension_pass;
            $new_height = ($height / $width) * $new_dimension_pass;
        } else {
            $new_height = $new_dimension_pass;
            $new_width = ($width / $height) * $new_dimension_pass;
        }

        $image_p = imagecreatetruecolor($new_width, $new_height);
        if ($extension == "jpg" || $extension == "jpeg") {
            $image = imagecreatefromjpeg($filename_pass);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagejpeg($image_p, $upload_path, 100);
            return 1;
        } else if ($extension == "png") {
            $image = imagecreatefrompng($filename_pass);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagepng($image_p, $upload_path, 9);
            return 1;
        } else {
            $image = imagecreatefromgif($filename_pass);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagegif($image_p, $upload_path);
            return 1;
        }
        return 0;
    }

/**************************************************************************************************************
    @Function Name : resize
    @Params	       : NULL
    @Author         : Navish
    @date           : 1-May-2015
****************************************************************************************************************/    

function navResize($source_image, $destination, $tn_w, $tn_h, $quality = 100, $wmsource = false)
{
    $info = getimagesize($source_image);
    $imgtype = image_type_to_mime_type($info[2]);

    #assuming the mime type is correct
    switch ($imgtype) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($source_image);
            break;
        case 'image/gif':
            $source = imagecreatefromgif($source_image);
            break;
        case 'image/png':
            $source = imagecreatefrompng($source_image);
            break;
        default:
            die('Invalid image type.');
    }

    #Figure out the dimensions of the image and the dimensions of the desired thumbnail
    $src_w = imagesx($source);
    $src_h = imagesy($source);


    #Do some math to figure out which way we'll need to crop the image
    #to get it proportional to the new size, then crop or adjust as needed

    $x_ratio = $tn_w / $src_w;
    $y_ratio = $tn_h / $src_h;

    if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
        $new_w = $src_w;
        $new_h = $src_h;
    } elseif (($x_ratio * $src_h) < $tn_h) {
        $new_h = ceil($x_ratio * $src_h);
        $new_w = $tn_w;
    } else {
        $new_w = ceil($y_ratio * $src_w);
        $new_h = $tn_h;
    }

    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
    imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
    $final = imagecreatetruecolor($tn_w, $tn_h);
    $backgroundColor = imagecolorallocate($final, 255, 255, 255);
    imagefill($final, 0, 0, $backgroundColor);
    //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
    imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

    #if we need to add a watermark
    if ($wmsource) {
        #find out what type of image the watermark is
        $info    = getimagesize($wmsource);
        $imgtype = image_type_to_mime_type($info[2]);

        #assuming the mime type is correct
        switch ($imgtype) {
            case 'image/jpeg':
                $watermark = imagecreatefromjpeg($wmsource);
                break;
            case 'image/gif':
                $watermark = imagecreatefromgif($wmsource);
                break;
            case 'image/png':
                $watermark = imagecreatefrompng($wmsource);
                break;
            default:
                die('Invalid watermark type.');
        }

        #if we're adding a watermark, figure out the size of the watermark
        #and then place the watermark image on the bottom right of the image
        $wm_w = imagesx($watermark);
        $wm_h = imagesy($watermark);
        imagecopy($final, $watermark, $tn_w - $wm_w, $tn_h - $wm_h, 0, 0, $tn_w, $tn_h);

    }
    if (imagejpeg($final, $destination, $quality)) {
        return 1;
    }
    return 0;
}

    
/**************************************************************************************************************
    @Function Name  : getExtension
    @Params	    : NULL
    @Description    : for fetching extension of files.
    @Author         : Aman Gupta
    @date           : 13-Nov-2014
*************************************************************************************************************** */

    public function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }
    
/**************************************************************************************************************
    @Function Name  : delete_image
    @Params	    : $image name , $model
    @Description    : for deleting Image
    @Author         : Aman Gupta
    @date           : 14-Nov-2014
*************************************************************************************************************** */

    public function delete_image($image,$model,$user_id,$fullpath=TRUE){
        if($image && $model){
            if($fullpath){
                $path = WWW_ROOT . "images/$user_id/$model/";    
            }
            else{
                $path = WWW_ROOT . "images/$model/";
            }
            
            $org_path = $path."original/".$image;
            if(file_exists($org_path))
                unlink($org_path);
            $e_path = $path."800/".$image;
            if(file_exists($e_path))
                unlink($e_path);
            $f_path = $path."500/".$image;
            if(file_exists($f_path))
                unlink($f_path);
            $t_path = $path."350/".$image;
            if(file_exists($t_path))
                unlink($t_path);
            $o_path = $path."150/".$image;
            if(file_exists($o_path))
                unlink($o_path);
            $h_path = $path."50/".$image;
            if(file_exists($h_path))
                unlink($h_path);
        }
    }
    
}