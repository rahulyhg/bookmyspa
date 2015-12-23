<?php if(is_array($getData) && count($getData) > 0) {
    foreach($getData as $theTf) { ?>
        <div class="treat-div treat-tag-<?php echo $theTf['Service']['id']; ?>" style="display: none" >
        <?php if(!empty($theTf['children'])){
             $mainchild = $theTf['Service']['frontend_display'];
            
            foreach($theTf['children'] as $theCatF){
                if(!empty($theCatF['children'])){
                    $subchild = $theCatF['Service']['frontend_display'];
                    ?>
                    <ul data-id="<?php echo $theCatF['Service']['id']; ?>" class="treat-list treat-cat-<?php echo $theCatF['Service']['id']; ?>" style="display: none">
                        <?php
                        foreach($theCatF['children'] as $treatmentD){ ?>
                            <li data-id="<?php echo $treatmentD['Service']['id']; ?>">
                                <div class="treat-pic-box">
                                    <?php if(!empty($treatmentD['ServiceImage'])){ ?>
                                        <div class="category-pic">
                                            <?php echo $this->Html->image('/images/Service/350/'.$treatmentD['ServiceImage'][0]['image'],array('class'=>" ", 'data-img'=>$treatmentD['ServiceImage'][0]['image'])); ?>
                                        </div>
                                    <?php }else{?>
                                        <div class="category-pic no-pic">
                                            <img src="/img/admin/treat-pic.png">
                                        </div>
                                    <?php } ?>
                                    <div class="treat-info-rw">
                                        <div class="treat-check-rw">
                                            <span class="treat-check-txt">
                                            <?php echo ucfirst($treatmentD['Service']['name']); ?>
                                            </span>
                                            <span class="treat-check <?php echo ($mainchild == 0 && $subchild == 1)?'atv':'';?>">
                                                <?php
                                                $checked = ($treatmentD['Service']['frontend_display'])?TRUE:FALSE;
                                                echo $this->Form->input('check-'.$treatmentD['Service']['id'],array('checked'=>$checked,'div'=>false,'type'=>'checkbox','class'=>'tagtreatcheck','label'=>array('class'=>'new-chk','text'=>'&nbsp;','title'=>'Front end display'))); ?>
                                            </span>
                                        </div>
                                        <div class="treat-info">
                                            <p class="category-txt">Weekly sale: 500</p>
                                            <p class="category-txt">Monthly sale: 3000</p>
                                            <div class="category-icons">
                                            <div>
                                            <?php  if($treatmentD['Service']['status']){ ?>
                                                    <a href="javascript:void(0);" alt='De-activate' title='De-activate' class="activeCategory active" data-id="<?php echo $treatmentD['Service']['id']; ?>"><i class="fa fa-check-square-o"></i></a>
                                                    <?php }else{ ?>
                                                    <a href="javascript:void(0);" alt='Activate' title='Activate' class="activeCategory" data-id="<?php echo $treatmentD['Service']['id']; ?>"><i class="fa fa-square-o"></i></a>
                                                    <?php } ?>
                                            </div>
                                            <div>
                                                <a href="javascript:void(0);" alt='Edit' title='Edit' class="addtreatment" data-id="<?php echo $treatmentD['Service']['id']; ?>"><i class="fa fa-pencil"></i></a>
                                            </div>
                                            <div>
                                            <?php echo $this->Html->link('<i class="icon-trash"></i>','javascript:void(0);',array('escape'=>false,'alt'=>'Delete','data-rel'=>'Treatment','title'=>'Delete',"class"=>"deleteCategory",'data-id'=>$treatmentD['Service']['id'])); ?>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php //pr($treatmentD); ?>
                            </li>
                        <?php }?>
                        
                    </ul>        
                <?php }
                else{ ?>
                    <ul class="treat-list no-treat treat-cat-<?php echo $theCatF['Service']['id']; ?>" data-id="<?php echo $theCatF['Service']['id']; ?>" style="display: none">
                        <li>
                            No treatment added yet
                        </li>
                    </ul>        
                <?php }
            }
        }
        else{ ?>
            <ul class="no-treat">
                <li>
                    No Treatment Added Yet
                </li>
            </ul>    
        <?php } ?>
        </div>
    <?php }?>
    
<?php }
else{ ?>
<ul class="no-treat">
    <li>
        No Treatment Added Yet
    </li>
</ul>
<?php }?>

    