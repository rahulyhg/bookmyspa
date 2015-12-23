    <?php    
        echo $this->Html->script('fancybox/jquery.fancybox');
        echo $this->Html->css('fancybox/jquery.fancybox');
	echo $this->Html->script('admin/admin_user_list');
    ?>   
    <?php
        $recordExits = false;            
        if(isset($getData) && !empty($getData))
        {
           $recordExits = true;            
        }
        echo $this->Form->create('Search', array('url' => array('controller' => 'users', 'action' => 'publisher'),'id'=>'userId','type'=>'get'));  ?>
		<?php echo $this->Form->hidden('alphabet_letter',array('id'=>'hiddenalpha')); ?>
        <div class="row padding_btm_20">
            <div class="col-lg-4">   
                 <?php echo $this->Form->input('keyword',array('value'=>$keyword,'label' => false,'div' => false, 'placeholder' => 'Keyword Search','class' => 'form-control','maxlength' => 55));?>
				 <span class="blue">(<b>Search by:</b>First Name, Last Name, Email)</span>
            </div>
           <div class="col-lg-2">
	    <?php $user_types = array('' => 'All', '0' => 'User', '1' => 'Publisher');
		echo $this->Form->input(
		    '',
		    array('name' => 'user_type', 'class'=> 'form-control', 'options' => $user_types, 'default' => '', 'selected' => $user_type_key)
		);
            ?>
	    </div>
            <div class="col-lg-4">                        
                <?php echo $this->Form->button('Search', array('type' => 'submit','class' => 'btn btn-default'));?>
		<?php echo $this->Html->link('List All',array('controller'=>'users','action'=>'publisher'),array('class' => 'btn btn-default'));?>
            </div>
            <div class="col-lg-4">    
                <div class="addbutton">                
                    <?php //echo $this->Html->link('Add New User','/admin/users/addedit',array('class' => 'icon-file-alt','title' => 'Add User'));?>
                </div>
            </div>
        </div>
		<div class="row padding_btm_20"> 
			<ul class="letters clearfix">
				<li class="widthFirst"><span class="blue"><b>Alphabetic Search:</b></span></li>
				<?php
				foreach($alphabetArray as $alphabetArr)
				{
					if($alphabetArr == $alphakeyword){ $active = "activeAlpha"; }else{ $active = "";}
					echo "<li>";						
					echo $this->Html->link($alphabetArr,'javascript:void(0)',array('escape' =>false,'onClick'=>'alphaSearch(this)','class'=>$active));
					echo "</li>";
				}
				?>
			</ul>
		</div>
    <?php echo $this->Form->end(); ?>
    <div class="row">
        <div class="col-lg-12">                        
             <?php echo $this->Session->flash();?>   
        </div>            
    </div>
    <?php echo $this->Form->create('Publisher', array('url' => array('controller' => 'users', 'action' => 'publisher'),'id'=>'UserFormId'));  ?>
    
    <div class="row">
        <div class="col-lg-12">            
            <div class="table-responsive">               
                <table class="table table-bordered table-hover table-striped tablesorter">
                    <thead>
                        <tr>
                            <th class="th_checkbox"><input type="checkbox" class="checkall"></th>
			    <th class="th_checkbox"><?php echo $this->Paginator->sort('status', 'Status'); ?> </th>
                            <th><?php echo $this->Paginator->sort('first_name', 'Name'); ?></th>
                            <th><?php echo $this->Paginator->sort('email', 'Email'); ?></th>
                           <!-- <th class="th_checkbox"><?php //echo $this->Paginator->sort('gender', 'Gender'); ?> </th> -->
			                <th class="th_checkbox"><?php echo $this->Paginator->sort('user_type', 'User Type'); ?> </th>
                            <th class="th_checkbox"><?php echo $this->Paginator->sort('created', 'Created'); ?> </th>                            
                            <th class="th_checkbox">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="dyntable">
                      <?php if($recordExits)
                { ?>   
                        
                        <?php
                        $i = 0;
                        foreach($getData as $key => $getData)
                        {
                            $class = ($i%2 == 0) ? ' class="active"' : '';
                            ?>
                        <tr <?php echo $class;?>>
                            <td align="center"><input type="checkbox" name="checkboxes[]" class ="checkboxlist" value="<?php echo base64_encode($getData['Publisher']['id']);?>" ></td>     
                           <?php   
                           
				    $status = $getData['User']['status'];
                                    $statusImg = ($getData['User']['status'] == 1) ? 'active' : 'inactive';
                                    echo $this->Form->hidden('status',array('value'=>$status,'id'=>'statusHidden_'.$getData['User']['id'])); ?>
                              <?php  $pid = $getData['User']['id'];?>
                            <td align="center"><?php echo $this->Html->link($this->Html->image("admin/".$statusImg.".png", array("alt" => ucfirst($statusImg),"title" => ucfirst($statusImg))),'javascript:void(0)',array('escape'=>false,'id'=>'link_status_'.$getData['User']['id'],'onclick'=>'setStatus('.$pid.')')) ; ?></td>
                            <td><?php echo $this->Html->link($getData['User']['first_name'].' '.$getData['User']['last_name'],"/admin/users/addedit/".base64_encode($getData['User']['id']),array('escape' =>false)); ?></td>
                          
                            <td><?php echo $this->Html->link($getData['User']['email'],"mailto:".$getData['User']['email'],array());?></td>
                            <!--<td align="center"><?php
                                //$gender = ($getData['User']['gender'] == 0) ? 'female' : 'male';
                                //echo $this->Html->image("admin/".$gender.".png", array("alt" => ucfirst($gender),"title" => ucfirst($gender)));
                            ?></td> -->
			    <td align="center"><?php
                                $user_type = ($getData['User']['user_type'] == 0) ? 'visitor' : 'publisher';
                                echo ucfirst($user_type);
                            ?></td>
                            <td align="center"><?php echo ($getData['User']['created'] != '0000-00-00 00:00:00') ? date('M j, Y',strtotime($getData['User']['created'])):'N/A';?></td>                            
                            <td align="center">
                            <?php
                                //echo $this->Html->link($this->Html->image("admin/edit.png", array("alt" => "Edit","title" => "Edit")),"/admin/users/addedit/".base64_encode($getData['User']['id']),array('escape' =>false));
                                //echo $this->Html->link($this->Html->image("admin/delete.png", array("alt" => "Delete","title" => "Delete")),"/admin/users/delete/".base64_encode($getData['User']['id']),array('escape' =>false),"Are you sure you wish to delete this user?");
				echo $this->Html->link($this->Html->image("admin/view.png", array("alt" => "User Detail","title" => "User Detail")),"/admin/users/view/".base64_encode($getData['User']['id']),array('escape' =>false,'class' => 'fancybox fancybox.ajax'));                                
				echo $this->Html->link($this->Html->image("admin/grant.png", array("alt" => "Grant","title" => "Authorise")),"/admin/users/authorise_publisher/".base64_encode($getData['User']['id']),array('escape' =>false),"Are you sure you want to grant the permission ?");
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
                            echo $this->element('admin/operation1');  // Active/ Inactive/ Delete
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
                     <!--
                     <div class="col-lg-2"> <?php  //echo $this->Html->image("admin/active.png"). " Active"; ?> </div>
                     <div class="col-lg-2"> <?php // echo $this->Html->image("admin/inactive.png"). " Inactive"; ?> </div>
                     -->
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/view.png"). " View"; ?> </div>
		     <div class="col-lg-2"> <?php echo $this->Html->image("admin/grant.png"). " Authorise"; ?> </div>
                    
                 </div>
              
               <?php
                }else{  ?>
              
                
                     </tbody>
                    </table>
                  <?php echo $this->element('admin/no_record_exists');  ?>
                           
                    
               <?php } ?>
            </div>
        </div>         
    </div><!-- /.row -->
   <?php  echo $this->Form->end(); ?>
