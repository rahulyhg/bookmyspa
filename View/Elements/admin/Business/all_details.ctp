<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="dropdown active">
        <a aria-controls="myTabDrop1-contents" data-toggle="dropdown" class="dropdown-toggle" id="myTabDrop1" href="#" aria-expanded="false">
            Profile <i class="fa  fa-angle-down"></i>
        </a>
        <ul id="myTabDrop1-contents" aria-labelledby="myTabDrop1" role="menu" class="dropdown-menu">
            <li class="active">
                <a aria-controls="dropdown1" data-toggle="tab" id="dropdown1-tab" role="tab" tabindex="-1" href="#dropdown1" aria-expanded="true">Business Profile</a></li>
            <li>
                <a aria-controls="dropdown2" data-toggle="tab" id="dropdown2-tab" role="tab" tabindex="-1" href="#dropdown2">Personal profile</a></li>
        </ul> 
    </li>
    <li role="presentation">
        <a href="#Services" aria-controls="Services" role="tab" data-toggle="tab">Services</a>
    </li>
        
    <?php
   //echo $user['User']['type'];
    
    if($user['User']['type'] == 2){ ?>
        <li role="presentation">
            <a href="#Staff" aria-controls="Staff" role="tab" data-toggle="tab">Staff </a>
        </li>
        <li role="presentation">
            <a href="#Salonlist" data-toggle='tab'>Salons </a>
        </li>
    <?php }
    elseif($user['User']['type'] == 3){ ?>
         <li role="presentation">
            <a href="#Staff" aria-controls="Staff" role="tab" data-toggle="tab">Staff </a>
        </li>
        <li role="presentation">
            <a href="#Salonlist" data-toggle='tab'>Salons </a>
        </li>
        <li role="presentation">
            <a href="#Facility" aria-controls="Facility" role="tab" data-toggle="tab">Facility Information</a>
        </li>
    <?php }
    elseif($user['User']['type'] == 4){ ?>
        <li role="presentation">
            <a href="#Staff" aria-controls="Staff" role="tab" data-toggle="tab">Staff </a>
        </li>
        <li role="presentation">
            <a href="#Facility" aria-controls="Facility" role="tab" data-toggle="tab">Facility Information</a>
        </li>
    <?php }?>
    <li role="presentation" class="dropdown">
        <a aria-controls="myTabDrop2-contents" data-toggle="dropdown" class="dropdown-toggle" id="myTabDrop2" href="#" aria-expanded="false">Gallery <i class="fa  fa-angle-down"></i></a>
        <ul id="myTabDrop2-contents" aria-labelledby="myTabDrop2" role="menu" class="dropdown-menu">
            <?php if($user['User']['type']==4){ ?>
            <li>
                <a aria-controls="dropdown3" data-toggle="tab" id="dropdown3-tab" role="tab" tabindex="-1" href="#venueGallery" aria-expanded="true">Venue Gallery</a>
            </li>
            <?php } ?>
            <li>
                <a aria-controls="dropdown4" data-toggle="tab" id="dropdown4-tab" role="tab" tabindex="-1" href="#publiccGallery">Public gallery</a>
            </li>
        </ul>
    </li>
    <li role="presentation">
        <a href="#Billing" aria-controls="Billing" role="tab" data-toggle="tab">Billing Information</a></li>
    <li role="presentation">
        <a href="#Bank" aria-controls="Bank" role="tab" data-toggle="tab">Bank Details</a></li>
        <li role="presentation">
        <a href="#Gift" aria-controls="Gift" role="tab" data-toggle="tab">Gift Certificates</a></li>
     <?php 
        if($user['User']['type'] == 3 || $user['User']['type'] == 2){
     ?>
    <li role="Advertisement">
        <a href="#Advertisement" aria-controls="Ads" role="tab" data-toggle="tab">Advertisements</a></li>
    <?php 
        }
    ?>
</ul>

<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="dropdown1">
        <h2>Business Profile</h2>
        <ul class="profile">
            <li>
                <label>Business Name</label>
                <section><?php echo $user['Salon']['eng_name'];?></section>                    
            </li>
            <li>
                <label>Business Description</label>
                <section>
                    <?php echo $user['Salon']['eng_description'];?>
                </section>                    
            </li>
            <li>
                <label>Current Website</label>
                <section>
                    <?php echo $user['Salon']['website_url'];?>
                </section>                    
            </li>
            <li>
                <label>Sieasta URL</label>
                <section>
                  <?php   $business_url =  ($user['Salon']['business_url'] !='')?$user['Salon']['business_url']:$user['User']['username'];
                            echo Configure::read('BASE_URL').'/'.$business_url; ?>   
                                   
            </li>
        </ul>
    </div>
    
    <div role="tabpanel" class="tab-pane" id="dropdown2">
                    <h2>Personal Profile</h2>
                    <ul class="profile">
                        <li>
                            <label>Username</label>
                            <section><?php echo $user['User']['username'];?></section>                    
                        </li>
                        <li>
                            <label>First Name</label>
                            <section><?php echo ucfirst($user['User']['first_name']);?></section>                    
                        </li>
                        <li>
                            <label>Last Name</label>
                            <section><?php echo ucfirst($user['User']['last_name']);?></section>                    
                        </li>
                        <li>
                            <label>Email</label>
                            <section><?php echo $user['User']['email'];?></section>                    
                        </li>
                        <li>
                            <label>Address</label>
                            <section>
                                <?php echo $user['Address']['address'];?><br>
                                <?php echo ucfirst($user['Address']['area']);?>
                            </section>                    
                        </li>
                        <li>
                            <label>Birthdate</label>
                            <section>
                                <?php
                                    if($user['UserDetail']['dob']){
                                            echo $user['UserDetail']['dob'];
                                    }else{
                                            echo '-';
                                    }
                                ?>
                            </section>                    
                        </li>
                        <li>
                            <label>Mobile 1</label>
                            <section>
                            <?php
                                $code='';
                                 if($user['Address']['country_id']){
                                     $code = $this->Common->getPhoneCode($user['Address']['country_id']);
                                 }
                                 if($user['Contact']['cell_phone']){
                                    echo  $code.'-'.$user['Contact']['cell_phone'];
                                 }else{
                                     echo '-';
                                 }
                            ?>
                            </section>                    
                        </li>
                        <li>
                            <label>Mobile 2</label>
                            <section>
                                <?php
                                    $code='';
                                     if($user['Address']['country_id']){
                                         $code = $this->Common->getPhoneCode($user['Address']['country_id']);
                                     }
                                     if($user['Contact']['day_phone']){
                                        echo  $code.'-'.$user['Contact']['day_phone'];
                                     }else{
                                         echo '-';
                                     }
                                ?>
                            </section>                    
                        </li>
                        <li>
                            <label>Mobile 3</label>
                            <section>
                            <?php
                                $code='';
                                 if($user['Address']['country_id']){
                                     $code = $this->Common->getPhoneCode($user['Address']['country_id']);
                                 }
                                 if($user['Contact']['night_phone']){
                                    echo  $code.'-'.$user['Contact']['night_phone'];
                                 }else{
                                     echo '-';
                                 }
                            ?>
                            </section>                    
                        </li>
                    </ul>
                </div>
    <div role="tabpanel" class="tab-pane" id="Services">
        <?php echo $this->element('admin/Business/list_admin_service'); ?>
    </div>
    <?php if($user['User']['type'] == 2 || $user['User']['type'] == 3){ ?>
     <div role="tabpanel" class="tab-pane" id="Staff">
            <?php echo $this->element('admin/Business/staff_list'); ?>
        </div>
    <div role="tabpanel" class="tab-pane" id="Salonlist">
        <?php echo $this->element('admin/Business/salons_list'); ?>
    </div>

    <?php } ?>
    <?php if($user['User']['type'] == 4 || $user['User']['type'] == 3){ ?>
    <div role="tabpanel" class="tab-pane" id="Facility">
        <?php echo $this->element('admin/Business/facility_view'); ?>
    </div>
    <?php } ?>
    <?php if($user['User']['type'] == 4){ ?>
        <div role="tabpanel" class="tab-pane" id="Staff">
            <?php echo $this->element('admin/Business/staff_list'); ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="venueGallery">
            <?php echo $this->element('admin/Business/venue_gallery'); ?>
        </div>
    <?php }?>
        <div role="tabpanel" class="tab-pane" id="publiccGallery">
            <?php echo $this->element('admin/Business/public_gallery'); ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="Bank">
              <?php echo $this->element('admin/Business/business_details'); ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="Billing">
           <?php echo $this->element('admin/Business/billing_detail'); ?>
        </div>
        
        <div role="tabpanel" class="tab-pane" id="Gift">
                <?php echo $this->element('admin/Business/list_gift'); ?>
            </div>
        <?php 
        if($user['User']['type'] == 3 || $user['User']['type'] == 2){
        ?>
            <div role="tabpanel" class="tab-pane" id="Advertisement">
                <?php echo $this->element('admin/Business/advertisement_list'); ?>
            </div>
        <?php
        }
        ?>
    
</div>

<?php 
    //FRENCHISE - 2
    /***
     * All Salons
     *          1. Facility Information
     *          2. Venue Galley
     *          3. Service -> Treatment Gallery
     *          4. Public Gallery
     *          5. Billing and Bank Details
     *          6. Staff - Details/add/edit
     *              Working Hours as per Staff
     * Working Hours       
     * Public Gallery
     * Billing Information
     * Bank Details
     * Staff - Details/add/edit
     * Services - Treatment Gallery
    ***/
    
    //MULTISTORE - 3 
    /***
     * All Salons
     *          1. Venue Galley
     *          2. Service -> Treatment Gallery
     *          3. Public Gallery
     *          4. Staff - Details/add/edit
     *              Working Hours as per Staff
     * Facility Information
     * Working Hours
     * Public Gallery
     * Billing Information
     * Bank Details
     * Staff - Details/add/edit
     * Services - Treatment Gallery
    ***/
    
    //INDIVIDUAL - 4
    /***
     * Facility Information
     * Venue Galley
     * Staff - Details/add/edit
     *  Working Hours as per Staff
     * Service -> Treatment Gallery
     * Public Gallery
     * Billing Information
     * Bank Details
    ***/
 ?>