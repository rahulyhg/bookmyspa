<div class="box-content">
    <div class="box-title">
        <h2>
            <i class="icon-table"></i>
            Staff
        </h2>
                <?php 
                if($this->Session->read('Auth.User.id') != '1'){
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New Staff</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'edit_staff pull-right'));
                 }
                 ?>
    </div>
    
    <div class="table-responsive">
    
    <table class="table datatable table-striped table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Staff Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($staffList)){
                foreach ($staffList as $user){ ?>
            <tr data-type="staff_list" data-id="<?php echo $user['User']['id']; ?>">
                <td><?php echo $user['User']['username']; ?></td>
                <td><?php echo ucfirst($user['User']['first_name'])." ". ucfirst($user['User']['last_name']); ?></td>
                <td><?php echo $user['User']['email']; ?></td>
                <td><?php echo ($user['UserDetail']['employee_type']=='1')?'Account Admin':'Sevice Provider'; ?></td>
                <td><?php echo $this->Common->theStatusImage($user['User']['status']); ?></td>
                <td>
                    <?php echo $this->Html->link('<i class="icon-eye-open"></i>&nbsp;','javascript:void(0)', array('data-id'=>$user['User']['id'],'title' => 'View', 'class' => 'view_user', 'escape' => false)) ?>
                    <?php 
                    if($this->Session->read('Auth.User.id') != '1'){
                    ?>
                    <?php echo $this->Html->link('<i class="icon-pencil"></i>&nbsp;','javascript:void(0)', array('data-id'=>$user['User']['id'],'title' => 'Edit', 'class' => 'edit_staff', 'escape' => false)) ?>
                    <?php
                    }
                    ?>
                    <?php echo $this->Html->link('<i class=" icon-trash"></i>&nbsp;','javascript:void(0)', array('data-id'=>$user['User']['id'],'title' => 'Delete', 'class' => 'delete_staff', 'escape' => false)) ?>
                </td>
            </tr>    
                <?php }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Staff Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>

</div>

</div>

<script>
    $(document).ready(function() {

        $(document).on('click', '.view_user', function() {
            var itsId = $(this).closest('tr').attr('data-id');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'staff_profile')); ?>";
            var $bigmodal = $('#commonContainerModal');
            addeditURL = addeditURL + '/' + itsId;
            fetchModal($bigmodal, addeditURL);
        });

        $(document).on('click', '.edit_staff', function() {
            var itsId = $(this).closest('tr').attr('data-id');
            var uid = '<?php echo isset($uid) ? $uid : null;?>';
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'editStaff')); ?>";
            var $bigmodal = $('#commonContainerModal');
            addeditURL = addeditURL + '/' + itsId + '/' + uid;
            fetchModal($bigmodal, addeditURL);
        });

        /********************** Edit user details ****************/
        $modal = $('#commonContainerModal');
        $modal.on('click', '.update_staff', function(e) {
            var options = {
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success: function(res) {
                    if (onResponse($modal, 'User', res)) {
                        window.location.reload();
                    }
                }
            };
            $('#UserAdminEditStaffForm').submit(function() {
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        /**********************Delte user ****************/
        $(document).on('click', '.delete_staff', function() {
            $this = $(this);
            theId = $this.data('id');
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'delete_user','admin'=>true));?>",
                data: {id: theId}
            })
                    .done(function(msg) {
                        $this.closest('tr').remove();
                    });
        })


        $(document).on('click', '.changeStatus', function() {
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var Type = theJ.closest('tr').data('type');
            console.log(Type);
            if (Type = 'staff_list') {
                var statusTo = theJ.attr('data-status');
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'changeStatus_user','admin'=>true));?>",
                    data: {id: theId, status: statusTo}
                })
                        .done(function(msg) {
                            if (msg == 0) {
                                theJ.closest('td').html('<?php echo $this->Common->theStatusImage(0); ?>')
                            }
                            else {
                                theJ.closest('td').html('<?php echo $this->Common->theStatusImage(1); ?>')
                            }
                        });
            }
        })
    });
</script>
