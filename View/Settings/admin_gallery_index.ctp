    <?php  
		echo $this->Html->script('fancybox/jquery.fancybox');
        echo $this->Html->css('fancybox/jquery.fancybox');
		echo $this->Html->script('admin/admin_gallery_index'); 
        $recordExits = false;            
        if(isset($getData) && !empty($getData))
        {
           $recordExits = true;            
        }    
        echo $this->Form->create('Search', array('url' => array('controller' => 'settings', 'action' => 'gallery_index'),'id'=>'titleId','type'=>'get'));  ?>
        <div class="row padding_btm_20">
            <div class="col-lg-4">   
                 <?php echo $this->Form->input('keyword',array('value'=>$keyword,'label' => false,'div' => false, 'placeholder' => 'Keyword Search','class' => 'form-control','maxlength' => 55));?>
                 <span class="blue">(<b>Search by:</b> Image Name)</span>
            </div>
           
            <div class="col-lg-4">                        
                <?php echo $this->Form->button('Search', array('type' => 'submit','class' => 'btn btn-default'));?>
                <?php echo $this->Html->link('List All',array('controller'=>'settings','action'=>'gallery_index'),array('class' => 'btn btn-default'));?>
            </div>
            <div class="col-lg-4">    
               <div class="addbutton">                
                    <?php echo $this->Html->link('Add Gallery Image','/admin/settings/photoupload',array('class' => 'icon-file-alt','title' => 'Add Page'));?>
                </div>
               
            </div>
        </div>
        <?php echo $this->Form->end();    
    ?>
    
    <div class="row">
        <div class="col-lg-12">                        
             <?php echo $this->Session->flash();?>   
        </div>            
    </div>
    
    <?php echo $this->Form->create('GalleryPhoto', array('url' => array('controller' => 'settings', 'action' => 'gallery_index'),'id'=>'contentFormId'));  ?>
    <div class="row">
        <div class="col-lg-12">            
            <div class="table-responsive">               
                <?php if($recordExits){ ?>
                <table class="table table-bordered table-hover table-striped tablesorter">
                    <thead>
                        <tr>
                            <th class="th_checkbox"><input type="checkbox" class="checkall"></th>
                            <th><?php echo $this->Paginator->sort('image_name', 'Image Name'); ?></th>
                            <th class="th_checkbox"><?php echo $this->Paginator->sort('status', 'Status'); ?> </th>
                            <th class="th_checkbox"><?php echo $this->Paginator->sort('created', 'Created'); ?> </th>                            
                            <th class="th_checkbox">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="dyntable">
                        <?php
							$i = 0;
							foreach($getData as $key => $getData){
								$class = ($i%2 == 0) ? ' class="active"' : '';
                       ?>
                        <tr <?php echo $class;?>>
                        <td align="center"><input type="checkbox" name="checkboxes[]" class ="checkboxlist" value="<?php echo base64_encode($getData['GalleryPhoto']['id']);?>" ></td>
                        <td><?php echo $getData['GalleryPhoto']['image_name'];?></td>                            
                        <!--td align="center">
                        <?php //echo $getData['Category']['Category']; ?>
                        </td-->     
                        <?php   
							$status = $getData['GalleryPhoto']['status'];
                                    $statusImg = ($getData['GalleryPhoto']['status'] == 1) ? 'active' : 'inactive';
                                    echo $this->Form->hidden('status',array('value'=>$status,'id'=>'statusHidden_'.$getData['GalleryPhoto']['id'])); ?>
                            <?php  $pid = $getData['GalleryPhoto']['id'];?>
                            <td align="center"><?php echo $this->Html->link($this->Html->image("admin/".$statusImg.".png", array("alt" => ucfirst($statusImg),"title" => ucfirst($statusImg))),'javascript:void(0)',array('escape'=>false,'id'=>'link_status_'.$getData['GalleryPhoto']['id'],'onclick'=>'setStatus('.$pid.')')) ; ?></td>
                        
                          <td align="center"><?php echo date('M j, Y',strtotime($getData['GalleryPhoto']['created']));?></td>                            
                            <td align="center">
                            <?php
                               echo $this->Html->link($this->Html->image("admin/edit.png", array("alt" => "Edit","title" => "Edit")),"/admin/settings/photoupload/".base64_encode($getData['GalleryPhoto']['id']),array('escape' =>false));
                                echo $this->Html->link($this->Html->image("admin/delete.png", array("alt" => "Delete","title" => "Delete")),"/admin/settings/delete/".base64_encode($getData['GalleryPhoto']['id']).'/',array('escape' =>false),"Are you sure you wish to delete this content?");
								echo $this->Html->link($this->Html->image("admin/view.png", array("alt" => "Image Detail","title" => "Image Detail")),"/admin/settings/view/".base64_encode($getData['GalleryPhoto']['id']),array('escape' =>false,'class' => 'fancybox fancybox.ajax'));                                
                            ?>
                            
                            </td>                    
                        </tr>
                        <?php
                            $i++;
                        } ?>
                    </tbody>
                    
                </table>
                <div class="row oprdiv">
                  <div class="col-lg-12 actiondivinr"> 
                     <?php
                        if($recordExits){
                            echo $this->element('admin/operation');  // Active/ Inactive/ Delete
                        }
                     ?>
                    </div>
                 </div>
                <div class="row">
                                      
                     <div class="col-lg-12"> <?php
                        if($this->Paginator->param('pageCount') > 1)
                        {
                            echo $this->element('admin/pagination');                 
                        }
                        ?>
                     </div>
                 </div>
                <div class="row padding_btm_20 ">
                     <div class="col-lg-2">   
                          LEGENDS:                        
                     </div>
                     
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/edit.png"). " Edit"; ?> </div>
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/active.png"). " Active"; ?> </div>
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/inactive.png"). " Inactive"; ?> </div>
                     <div class="col-lg-2"><?php echo $this->Html->image("admin/delete.png"). " Delete &nbsp;"; ?></div>
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/view.png"). " View"; ?> </div>
                 </div>
              
               <?php
                }else{ 
                    echo $this->element('admin/no_record_exists');
                } ?>
            </div>
        </div>         
    </div><!-- /.row -->
   <?php  echo $this->Form->end(); ?>
