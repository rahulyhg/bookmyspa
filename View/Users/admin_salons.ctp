<div class="row-fluid">
    <div class="span12">
        <section class="utopia-widget">
            <div class="utopia-widget-title">
                <?php echo $this->Html->image('admin/icons/window.png',array('class'=>'utopia-widget-icon')); ?>
                <span>Users</span>
                
            </div>

            <div class="utopia-widget-content">
                <p>
                    <?php echo $this->Html->link('Add New Salon',array('controller'=>'Users','action'=>'addUser','admin'=>true),array('class'=>''));?>
                </p>
                <table class="table datatable table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Salon Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(!empty($users)){
                            foreach($users as $user){ ?>
                                <tr data-id="<?php echo $user['User']['id']; ?>" >
                                    <td><?php echo $user['User']['username']; ?></td>
                                    <td><?php echo ucfirst($user['User']['first_name'])." ".ucfirst($user['User']['last_name']); ?></td>
                                    <td><?php echo $user['User']['email']; ?></td>
                                    <td><?php echo $user['User']['type']; ?></td>
                                    <td><?php echo $this->Common->theStatusImage($user['User']['status']); ?></td>
                                    <td>
                                        <?php echo $this->Html->link($this->Html->image('admin/icons/eye.png',array('alt'=>'View')), array('controller'=>'Users','action'=>'viewSalon','admin'=>true,base64_encode($user['User']['id']),ucfirst($user['User']['username'])) , array('title'=>'View','class'=>'view','escape'=>false) ) ?>
                                        <?php echo $this->Html->link($this->Html->image('admin/icons/pencil.png',array('alt'=>'Edit')), array('controller'=>'Users','action'=>'addUser','admin'=>true,base64_encode($user['User']['id']),ucfirst($user['User']['username'])) , array('title'=>'Edit','class'=>'edit','escape'=>false) ) ?>
                                        <?php echo $this->Html->link($this->Html->image('admin/icons/trash_can.png',array('alt'=>'Delete')), array('controller'=>'Users','action'=>'deleteUser','admin'=>true,base64_encode($user['User']['id']),ucfirst($user['User']['username'])) , array('title'=>'Delete','class'=>'delete','escape'=>false),' Are you sure, you want to delete this Salon ? ' ) ?>
                                    </td>
                                </tr>    
                            <?php }
                        }?>
                        
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Salon Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(document).on('click','.changeStatus',function(){
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var statusTo = theJ.attr('data-status');
            
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'changeStatus','admin'=>true));?>",
                data: { id: theId, status: statusTo }
            })
            .done(function( msg ) {
                if(msg == 0){
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(0); ?>')
                }
                else{
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(1); ?>')
                }
            });
        })
    });
</script>