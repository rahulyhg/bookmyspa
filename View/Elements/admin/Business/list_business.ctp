<div class="box-content vendor-deal-sec">
              <div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active" role="presentation">
                        <a data-toggle="tab" role="tab" href="#first11" aria-controls="first11">Individual Salon</a>
                    </li>
                    <li class="" role="presentation">
                        <a data-toggle="tab" role="tab" href="#second22" aria-controls="second22" >Franchise</a>
                    </li>
                     <li class="" role="presentation">
                        <a data-toggle="tab" role="tab" href="#thirds33" aria-controls="thirds33" >Multi Location</a>
                    </li>
                </ul>
                 <div class="tab-content">
                    <div role="tabpanel"  class="tab-pane active" id="first11">
                        <?php echo $this->element('admin/Business/list_individual'); ?>
                    </div>
                    <div  role="tabpanel" class="tab-pane" id="second22">
                        <?php echo $this->element('admin/Business/list_frenchise'); ?>   
                    </div>
                    <div role="tabpanel" class="tab-pane" id="thirds33">
                        <?php echo $this->element('admin/Business/list_multiple_locations'); ?>     
                    </div>
                  </div>
              </div>
</div> 





