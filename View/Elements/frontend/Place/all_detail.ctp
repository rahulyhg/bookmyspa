<div class="tab-content clearfix">
    <div role="tabpanel" class="tab-pane active" id="About">
        <?php echo $this->element('frontend/Place/about'); ?>
    </div>  
    <div role="tabpanel" class="tab-pane" id="Services">
        <div class="container bukingService"></div>
        <div class="container serviceList"></div>
    </div>
    <div role="tabpanel" class="tab-pane" id="Package">
        <div class="container bukingPackage"></div>
        <div class="container packageList"></div>
    </div>
     <div role="tabpanel" class="tab-pane" id="Spa Day">
        <div class="container bukingSpaday"></div>
        <div class="container SpadayList"></div>
    </div>
    <div role="tabpanel" class="tab-pane" id="Deals">
        <div class="container bukingDeal"></div>
        <div class="container dealList">
            
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="Gifts"></div>
    <div role="tabpanel" class="tab-pane" id="Staff"><?php //echo $this->element('frontend/Place/staff'); ?></div>  
    <div role="tabpanel" class="tab-pane" id="Gallery"><?php //echo $this->element('frontend/Place/gallery'); ?></div>  
</div>
