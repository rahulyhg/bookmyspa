<?php if(!empty($srvcDeals)){ ?>
<div class="vendor-service-content clearfix">
    <div class="panel-group ui-sortable" id="services-accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default panel-active ui-sortable-handle" data-id="thedlService">
            <div class="panel-heading" role="tab" id="heading-thedlService">
              <h4 class="panel-title">
                <a class="forcheck " data-toggle="collapse" data-parent="#services-accordion" href="#collapse-thedlService" aria-expanded="true" aria-controls="collapse-thedlService">
                    <span class="tag-icon"><i title="Re-Order Service" class="fa fa-hand-o-up"></i></span>
                    <span class="cat-name-wrap">Service Deals </span>
                </a>
              </h4>
            </div>
            <div id="collapse-thedlService" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-thedlService">
                <div class="panel-body">
                    <?php echo $this->element('admin/Business/list_deals',array('deals'=>$srvcDeals)); ?>
                </div>
            </div>
        </div>
    </div>		      

    <div class="clear"></div>
</div>
<?php } ?>
<?php if(!empty($pkgDeals)){ ?>
<div class="vendor-service-content clearfix">
    <div class="panel-group ui-sortable" id="package-accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default panel-active ui-sortable-handle" data-id="thedlpkg">
            <div class="panel-heading" role="tab" id="heading-thedlpkg">
              <h4 class="panel-title">
                <a class="forcheck " data-toggle="collapse" data-parent="#package-accordion" href="#collapse-thedlpkg" aria-expanded="true" aria-controls="collapse-thedlpkg">
                    <span class="tag-icon"><i title="Re-Order Service" class="fa fa-hand-o-up"></i></span>
                    <span class="cat-name-wrap">Package Deals</span>
                </a>
              </h4>
            </div>
            <div id="collapse-thedlpkg" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-thedlpkg">
                <div class="panel-body">
                    <?php echo $this->element('admin/Business/pkg_deals',array('thedeals'=>$pkgDeals,'type'=>'Package')); ?>
                </div>
            </div>
        </div>
    </div>		      

    <div class="clear"></div>
</div>
<?php } ?>
<?php if(isset($spadayDeals) && !empty($spadayDeals)){
    $pkgDeals = $spadayDeals;
    ?>
<div class="vendor-service-content clearfix">
    <div class="panel-group ui-sortable" id="package-accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default panel-active ui-sortable-handle" data-id="thedlpkg">
            <div class="panel-heading" role="tab" id="heading-thedlpkg">
              <h4 class="panel-title">
                <a class="forcheck " data-toggle="collapse" data-parent="#package-accordion" href="#collapse-thedlpkg" aria-expanded="true" aria-controls="collapse-thedlpkg">
                    <span class="tag-icon"><i title="Re-Order Service" class="fa fa-hand-o-up"></i></span>
                    <span class="cat-name-wrap">Spa Day Deals</span>
                </a>
              </h4>
            </div>
            <div id="collapse-thedlpkg" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-thedlpkg">
                <div class="panel-body">
                    <?php echo $this->element('admin/Business/pkg_deals',array('pkgDeals'=>$spadayDeals,'type'=>'Spaday')); ?>
                </div>
            </div>
        </div>
    </div>		      
    <div class="clear"></div>
</div>
<?php } ?>