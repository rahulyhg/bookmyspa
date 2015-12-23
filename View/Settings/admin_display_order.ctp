<div class="row-fluid">
   <h6>This is the order of Employees that will appear on your Sieasta webpage under the Staff tab.</h6>
   
    <div class="form-group">
        <label>Employee Display Order</label>
        <div class="emp-dis-box">
            <?php
                if(!empty($admin_user)){
                  echo '<div><a id="'.$admin_user['User']['id'].'" class="list_emp select_'.$admin_user['User']['id'].'"" onclick="selectme('.$admin_user['User']['id'].')" href="javascript:void(0);">'.$admin_user['User']['first_name'].' '.$admin_user['User']['last_name'] .'</a><br/></div>';
                 
                }
                if(!empty($users)){
                  //  pr($users);exit;
                    foreach($users as $user){
                        $display_name  = '';
                        if(!empty($user['User']['first_name'])){
                            $display_name = $user['User']['first_name'];
                        }if(!empty($user['User']['last_name'])){
                            $display_name .= ' '.$user['User']['last_name'];
                        }
                        echo '<div><a id="'.$user['User']['id'].'" class="list_emp select_'.$user['User']['id'].'" onclick="selectme('.$user['User']['id'].')" href="javascript:void(0);">'.$display_name.'</a><br/></div>';
                    }
                }
            ?>
           
        </div> <i class="fa-set fa fa-arrow-up"></i><i class="fa-down fa fa-arrow-down"></i>
    </div>
   
</div>

<script>

    function selectme(id){
        $(document).find('.backgroundHigh').removeClass('backgroundHigh');
        $(document).find('.select_'+id).parent().addClass('backgroundHigh');
    }
    $('.fa-set').click(function() {
            var element = $(document).find('div.backgroundHigh');
            element.insertBefore(element.prev());
    });
    $('.fa-down').click(function() {
            var element = $(document).find('div.backgroundHigh');
            element.insertAfter(element.next());
    });
    
</script>
<style>
    .emp-dis-box{
        border: 1px solid #ccc;
        height:200px;
        width:251px;
    }
    
    .fa-set{
        float:left;
        margin-left: 256px;
        margin-top: -199px;
        cursor: pointer;
    }
    
    .fa-down{
        float:left;
        margin-left: 256px;
        margin-top: -183px;
        cursor: pointer;

    }
    .list_emp{
        text-decoration: none;
    }
    .backgroundHigh{
       background-color: #ccc;
    }
</style>