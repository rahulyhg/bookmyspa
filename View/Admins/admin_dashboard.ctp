  
   <div class="row" style="vertical-align: middle;margin-top: 10px;">
          <div class="col-lg-12">            
               <div class="table-responsive">
                     <h2 class="text_center"><?php echo $this->Html->image('admin/welcome.png'); ?></h2>
                     </div>
          </div>
          <table class="table table-bordered table-striped tablesorter">
               <tbody class="dyntable">
                    <tr class="active">
                         <td align = "left">
                         Total Number of Users
                         </td>     
                         <td align = "center">
                              <?php echo $this->Html->link($total_Users,"/admin/users"); ?>
                         </td>
                         </td>
                    </tr>
                    <tr class="active">
                         <td align = "left">
                         Total Number of Publishers
                         </td>     
                         <td align = "center">
                              <?php echo $this->Html->link($total_Publisher,"/admin/users/index?user_type=1"); ?>
                         </td>
                    </tr>
                    <tr class="active">
                         <td align = "left">
                         Total number of Latest Registred Users
                         </td>     
                         <td align = "center">
                             <?php echo $this->Html->link($total_last_month,"/admin/users/index?currentdate=".$latest_registered_date); ?>
                         </td>
                    </tr>
                   <!--  <tr class="active">
                         <td align = "left">
                         Toal Number of Views
                         </td>     
                        <td align = "center">
                              <a href="">
                                   <?php if(isset($total_content_view)){
                                    //    echo $total_content_view;
                                        }
                                   ?>
                              </a>
                         </td> 
                    </tr>--->
               </tbody>
          </table>
    </div>
