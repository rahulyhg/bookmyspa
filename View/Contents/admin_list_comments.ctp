<?php  
echo $this->Html->script('fancybox/jquery.fancybox');
echo $this->Html->css('fancybox/jquery.fancybox');
echo $this->Html->script('admin/admin_contents'); 

        $recordExits = false;            
        if(isset($getData) && !empty($getData))
        {
           $recordExits = true;            
        }
        echo $this->Form->create('Search', array('id'=>'AdminId','type'=>'get'));  ?>
	
        <div class="row padding_btm_20">
            <div class="col-lg-4">   
               <?php echo $this->Form->input('keyword',array('value'=>$keyword,'label' => false,'div' => false, 'placeholder' => 'Keyword Search','class' => 'form-control','maxlength' => 55));?>
	       <span class="blue">(<b>Search by:</b>User First Name, User Last Name, Post Title, Comment)</span>
            </div>
           
            <div class="col-lg-4">                        
               <?php echo $this->Form->button('Search', array('type' => 'submit','class' => 'btn btn-default'));?>
	       <?php echo $this->Html->link('Show All',array('controller'=>'Contents','action'=>'list_comments', base64_encode($id)),array('class' => 'btn btn-default'));?>
            </div>
        </div>
		
        <?php echo $this->Form->end(); ?>
		
    <div class="row">
        <div class="col-lg-4">                        
             <?php echo $this->Session->flash();?>   
        </div>            
    </div>
    
    <?php echo $this->Form->create('PostComment', array('id'=>'AdminFormId'));  ?>
    
    <div class="row">
        <div class="col-lg-12">            
            <div class="table-responsive">               
                 
                <?php if($recordExits)
                { ?>
                <table class="table table-bordered table-hover table-striped tablesorter">
                    <thead>
                        <tr>
                            <th class="th_checkbox"><input type="checkbox" class="checkall"></th>
			    <th><?php echo $this->Paginator->sort('Content.title', 'Content Title'); ?></th>
			    <th><?php echo $this->Paginator->sort('name', 'User Name'); ?></th>
                            <th><?php echo $this->Paginator->sort('PostComment.comments', 'Comment'); ?></th>
                            <th class="th_checkbox"><?php echo $this->Paginator->sort('created', 'Created'); ?> </th>                            
                            <th class="th_checkbox">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="dyntable">
                        <?php
                        $i = 0;
                        
                        foreach($getData as $key => $getData)
                        {
                            $class = ($i%2 == 0) ? ' class="active"' : '';
                            ?>
                        <tr <?php echo $class;?>>
                            <td align="center"><input type="checkbox" name="checkboxes[]" class ="checkboxlist" value="<?php echo base64_encode($getData['PostComment']['id']);?>" ></td>     
                         
                            <td><?php echo $getData['Content']['title'];?></td>
			    <td><?php echo $getData[0]['name'];?></td>
			    <td><?php echo $getData['PostComment']['comments'];?></td>
                            <td align="center"><?php echo date('m/d/Y',strtotime($getData['PostComment']['created']));?></td>                            
                            <td align="center">
                            <?php
			      echo $this->Html->link($this->Html->image("admin/delete.png", array("alt" => "Delete","title" => "Delete")),"/admin/contents/delete_comments/".base64_encode($id).'/'.base64_encode($getData['PostComment']['id']),array('escape' =>false),"Are you sure you wish to delete this Comment?");
			    
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
                        if($recordExits)
                        { ?>
                           <div class="row">
			      <div class="col-lg-2">   
				  <?php echo $this->Form->input('PostComment.setStatus', array('type' => 'hidden','id'=>'setStatus'));
					echo $this->Form->input('status', array('label' => false,'div' => false,'options' => array('3' => 'Delete'),'class' => 'form-control','id' => 'statusId','empty'=>'-Select Action-'));?>      
			      </div>
			      <div class="col-lg-2">   
				   <?php echo $this->Form->button('Submit', array('type' => 'submit','class' => 'btn btn-default disabled','id' => 'operationId'));?>
			      </div>
			  </div>

                     <?php   }
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
                          Legend:                        
                     </div>
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/active.png"). " Active"; ?> </div>
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/inactive.png"). " Inactive"; ?> </div>
					 
                 </div>
              
               <?php
                }else{ 
                    echo $this->element('admin/no_record_exists');
                } ?>
            </div>
        </div>         
    </div><!-- /.row -->
   <?php  echo $this->Form->end(); ?>