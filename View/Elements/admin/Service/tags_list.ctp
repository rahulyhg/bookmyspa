<ul class="tagBlock">
<?php if(is_array($getData) && count($getData) > 0) { ?>
    <?php $forCategory = array();?>
    <?php foreach($getData as $tagK=>$theTag){ 
        $forCategory[$theTag['Service']['id']] = $theTag['children'];
        ?>
        <li data-id="<?php echo $theTag['Service']['id']; ?>" <?php echo ($tagK == 0 )? 'class="active"' : ''; ?> >
            <div class="tag-lft for-tag-toggle">
                <span class="tag-icon"><i title="Reorder Tags" class="fa fa-hand-o-up"></i></span>
                <span class="tag-text">
                    <?php echo ucfirst($theTag['Service']['name']);?>
                </span>
            </div>
            <div class="tag-rt">
                <ul>
                    <li>
                    <?php
                    $checked = ($theTag['Service']['frontend_display'])?TRUE:FALSE;
                    echo $this->Form->input('check-'.$theTag['Service']['id'],array('checked'=>$checked,'data-id'=>$theTag['Service']['id'],'div'=>false,'type'=>'checkbox','class'=>'tagcheck','label'=>array('class'=>'new-chk','text'=>'&nbsp;','title'=>'Front end display'))); ?>
                    </li>
                    <li>
                        <?php  if($theTag['Service']['status']){ ?>
                            <a href="javascript:void(0);" alt='De-activate' title='De-activate' class="activeCategory active" data-id="<?php echo $theTag['Service']['id']; ?>"><i class="fa fa-check-square-o"></i></a>
                        <?php }else{ ?>
                            <a href="javascript:void(0);" alt='Activate' title='Activate' class="activeCategory" data-id="<?php echo $theTag['Service']['id']; ?>"><i class="fa fa-square-o"></i></a>
                        <?php } ?>
                    </li>
                    <li>
                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i>','javascript:void(0);',array('escape'=>false,'alt'=>'Edit','title'=>'Edit',"class"=>"addeditTag",'data-id'=>$theTag['Service']['id'])); ?>
                    </li>
                    <li>
                        <?php echo $this->Html->link('<i class="icon-trash"></i>','javascript:void(0);',array('escape'=>false,'alt'=>'Delete','title'=>'Delete','data-rel'=>'Tag',"class"=>"deleteCategory",'data-id'=>$theTag['Service']['id'])); ?>
                    </li>
                </ul>
            </div>
        </li>
    <?php } ?>
<?php }else{ ?>
    <li>
        <div class="tag-lft">
            <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
            <span class="tag-text">
                No Tags Added Yet
            </span>
        </div>
        <div class="tag-rt">
        </div>
    </li>
<?php } ?>
</ul>