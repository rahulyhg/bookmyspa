<div class="row">
    <div class="tabs-container ">
        <ul class="tabs tabs-inline tabs-left">
            <?php
            if($user['User']['type'] == 2){ ?>
                <li class="active">
                    <a href="#salonChk" data-toggle='tab'><i class="icon-twitter"></i> Salons</a>
                </li>
            <?php }
            elseif($user['User']['type'] == 3){ ?>
                <li class="active">
                    <a href="#salonChk" data-toggle='tab'><i class="icon-twitter"></i> Salons</a>
                </li>
                <li>
                    <a href="#FacInfo" data-toggle='tab'><i class="icon-lock"></i> Facility Information</a>
                </li>
            <?php }
            elseif($user['User']['type'] == 4){ ?>
                <li class="active">
                    <a href="#StaffInfo" data-toggle='tab'><i class="icon-lock"></i> Staff</a>
                </li>
                <li>
                    <a href="#FacInfo" data-toggle='tab'><i class="icon-lock"></i> Facility Information</a>
                </li>
                <li>
                    <a href="#VenGalery" data-toggle='tab'><i class="icon-lock"></i> Venue Gallery</a>
                </li>
            <?php }?>
            <li>
                <a href="#serviceChk" data-toggle='tab'><i class="icon-twitter"></i> Services</a>
            </li>
            <li>
                <a href="#pgalleryChk" data-toggle='tab'><i class="icon-twitter"></i> Public Gallery</a>
            </li>
            <li>
                <a href="#billInfo" data-toggle='tab'><i class="icon-twitter"></i> Billing Information</a>
            </li>
            <li>
                <a href="#bankDtl" data-toggle='tab'><i class="icon-user"></i> Bank Details</a>
            </li>
        </ul>
    </div>
    <div class="tab-content padding tab-content-inline" style="min-height: 287px;">
        <?php
            if($user['User']['type'] == 2){ ?>
                <div class="tab-pane active" id="salonChk">
                    <?php echo $this->element('admin/Business/salons_list'); ?>
                </div>
            <?php }
            elseif($user['User']['type'] == 3){ ?>
                <div class="tab-pane active" id="salonChk">
                    <?php echo $this->element('admin/Business/salons_list'); ?>
                </div>
                <div class="tab-pane" id="FacInfo">
                    <?php echo $this->element('admin/Business/facility_view'); ?>
                </div>
            <?php }
            elseif($user['User']['type'] == 4){ ?>
                <div class="tab-pane active" id="StaffInfo">
                    <?php echo $this->element('admin/Business/staff_list'); ?>
                </div>
                <div class="tab-pane" id="FacInfo">
                    <?php echo $this->element('admin/Business/facility_view'); ?>
                </div>
                <div class="tab-pane" id="VenGalery">
                    <?php echo $this->element('admin/Business/venue_gallery'); ?>
                </div>
            <?php }?>
            <div class="tab-pane" id="serviceChk">
                 <?php echo $this->element('admin/Business/list_services'); ?>
            </div>
            <div class="tab-pane" id="pgalleryChk">
               <?php echo $this->element('admin/Business/public_gallery'); ?>
            </div>
            <div class="tab-pane" id="bankDtl">
                 <?php echo $this->element('admin/Business/business_details'); ?>
            </div>
            <div class="tab-pane" id="billInfo">
               <?php echo $this->element('admin/Business/billing_detail'); ?>
            </div>
    </div>
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