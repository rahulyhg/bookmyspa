<?php if(is_array($getData) && count($getData) > 0) {
    foreach($getData as $theTar){?>
        <div class="panel-group" data-id="<?php echo $theTar['Service']['id']; ?>" id="accordion-<?php echo $theTar['Service']['id']; ?>" style="display: none">
            <?php
            if(!empty($theTar['children'])){
                foreach($theTar['children'] as $kecat=>$thecat){ ?>
                    <div data-id="<?php echo $thecat['Service']['id']; ?>" class="panel panel-default <?php echo ($kecat == 0)? 'panel-active':''; ?> ">
                        <div class="panel-heading" role="tab" >
                            <a data-toggle="collapse" data-parent="#accordion-<?php echo $theTar['Service']['id']; ?>" href="#collapse-<?php echo $thecat['Service']['id']; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $thecat['Service']['id']; ?>" class="for-cat-toggle">
                                <span class="tag-lft">
                                    <span class="tag-icon"><i title="Reorder Category" class="fa fa-hand-o-up"></i></span>
                                    <span class="tag-text">
                                        <?php echo ucfirst($thecat['Service']['name']); ?>
                                    </span>
                                </span>
                            </a>
                            <span class="tag-rt2">
                                  <div class="pos-rel"> <?php
                                   $checked = ($thecat['Service']['frontend_display'])?TRUE:FALSE;
                                   echo $this->Form->input('check-'.$thecat['Service']['id'],array('checked'=>$checked,'div'=>false,'type'=>'checkbox','class'=>'tagcatcheck','label'=>array('class'=>'new-chk','text'=>'&nbsp;','title'=>'Front end display'))); ?></div>
                            </span>
                        </div>
                        <div id="collapse-<?php echo $thecat['Service']['id']; ?>" class="panel-collapse collapse <?php echo ($kecat == 0)? 'in':''; ?> " role="tabpanel" aria-labelledby="collapse-<?php echo $thecat['Service']['id']; ?>">
                            <div class="panel-body">
                                <div class="category-bx">
                                    <?php if(!empty($thecat['ServiceImage'])){ ?>
                                        <div class="category-pic">
                                            <?php echo $this->Html->image('/images/Service/350/'.$thecat['ServiceImage'][0]['image'],array('class'=>" ", 'data-img'=>$thecat['ServiceImage'][0]['image'])); ?>
                                        </div>
                                    <?php }else{?>
                                    <div class="category-pic no-pic">
                                        <img src="/img/admin/treat-pic.png">
                                    </div>
                                    <?php } ?>
                                    <div class="category-info">
                                        <div class="category-rw">
                                            <p class="category-txt">Weekly sale: 500</p>
                                            <p class="category-txt">Monthly sale: 3000</p>
                                            <div class="category-icons">
                                                <div>
                                                <?php  if($thecat['Service']['status']){ ?>
                                                    <a href="javascript:void(0);" alt='De-activate' title='De-activate' class="activeCategory active" data-id="<?php echo $thecat['Service']['id']; ?>"><i class="fa fa-check-square-o"></i></a>
                                                    <?php }else{ ?>
                                                    <a href="javascript:void(0);" alt='Activate' title='Activate' class="activeCategory" data-id="<?php echo $thecat['Service']['id']; ?>"><i class="fa fa-square-o"></i></a>
                                                    <?php } ?>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);" alt='Edit' title='Edit' class="addeditCategory" data-id="<?php echo $thecat['Service']['id']; ?>"><i class="fa fa-pencil"></i></a>
                                                </div>
                                                <div>
                                                <?php echo $this->Html->link('<i class="icon-trash"></i>','javascript:void(0);',array('escape'=>false,'alt'=>'Delete','data-rel'=>'Category','title'=>'Delete',"class"=>"deleteCategory",'data-id'=>$thecat['Service']['id'])); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            }else{ ?>
                <div class="ui-disabled panel panel-default panel-active">
                    <div role="tab" class="panel-heading">
                        <a href="javascript:void(0);" >
                            <span class="tag-lft">
                                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                                <span class="tag-text">
                                    No category added yet
                                </span>
                            </span>
                        </a>
                        <span class="tag-rt2">
                        </span>
                    </div>
                </div>
            <?php }?>
        </div>
    <?php }
}else{ ?>
    <div class="panel-group" id="accordion-empty" >
        <div class="panel panel-default panel-active">
            <div role="tab" class="panel-heading">
                <a href="javascript:void(0);" >
                    <span class="tag-lft">
                        <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                        <span class="tag-text">
                            No Category Added Yet
                        </span>
                    </span>
                </a>
                <span class="tag-rt2">
                </span>
            </div>
        </div>
    </div>
<?php }?>

