<table class="table table-hover table-nomargin dataTable table-bordered">
             <thead>
                 <tr>
                      <th align="center" style="text-align: center;">Image</th>
                      <th>English Title</th>
                      <th>Arabic Title</th>
                      <th>English Description</th>
                      <th>Arabic Description</th>
                      <th>Categories</th>
                      <th align="center" style="text-align: center;">Status</th>
                      <th align="center" style="text-align: center;">Action</th>
                 </tr>
             </thead>
             <tbody>
                 <?php
                 $uid = $this->Session->read('Auth.User.id');
                 if(!empty($allBlogs)){
                     foreach($allBlogs as $blog){
                          $imagePath = '../img/no_image.png';
                          if($blog['Blog']['image'] != '')
                          {
                                       $imagePath = '../images/'.$uid.'/Blog/50/'.$blog['Blog']['image'];
                          }
                          $eng_description = strip_tags($blog['Blog']['eng_description']);
                          $ara_description = strip_tags($blog['Blog']['ara_description']);
                          if(strlen($eng_description) > 50)
                          {
                                      $eng_description = substr($eng_description,0,50); 
                          }
                          if(strlen($ara_description) > 50)
                          {
                                       $ara_description = substr($ara_description,0,50);
                          }
                          ?>
                             <tr data-id="<?php echo $blog['Blog']['id']; ?>" >
                             <td align="center"><?php echo $this->Html->Image($imagePath); ?></td>
                             <td><?php echo $blog['Blog']['eng_title']; ?></td>
                             <td><?php echo $blog['Blog']['ara_title']; ?></td>
                             <td><?php echo $eng_description; ?></td>
                             <td><?php echo $ara_description; ?></td>
                             <td><?php $catNames=array();
                             foreach($blog['BlogToCategory'] as $catName){
                                 $catNames[] = $catName['category_id'];
                             }
                             echo $this->Common->get_categoryName($catNames); ?></td>
                             <td align="center"><?php echo $this->Common->theStatusImage($blog['Blog']['status']); ?></td>
                             <td align="center">
                                 <?php //echo $this->Html->link('<i class="icon-eye-open"></i>&nbsp;', array('controller'=>'blogs' ,'action'=>'view' , 'admin'=>true, base64_encode($blog['Blog']['id'])), array('target'=>'_blank','title'=>'View','class'=>'view_cmsPage','escape'=>false) ); ?>
                              <?php echo $this->Html->link('<i class="icon-eye-open"></i>', 'javascript:void(0);' , array('title'=>'View','class'=>'view_blog','escape'=>false) ); ?>
                             
                                 <?php echo $this->Html->link('<i class="icon-pencil"></i>&nbsp;', 'javascript:void(0);', array('data-id'=>$blog['Blog']['id'],'title'=>'Edit','class'=>'addedit_blog','escape'=>false) ) ?>
                                 <?php echo $this->Html->link('<i class=" icon-trash"></i>&nbsp;', 'javascript:void(0);', array('title'=>'Delete','class'=>'delete_blog','escape'=>false) ) ?>
                             </td>
                         </tr>    
                     <?php }
                 }?>
             </tbody>
             
         </table>
         