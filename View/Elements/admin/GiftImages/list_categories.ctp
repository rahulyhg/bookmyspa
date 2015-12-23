 <table class="table table-hover table-nomargin dataTable table-bordered">
        <thead>
        <tr>
	   <th>English Name</th>
	   <th>Arabic Name</th>
           <th>Action</th>
        </tr>
    </thead>
    <tbody>
        
        <?php $uid = $this->Session->read('Auth.User.id');
	foreach($catLists as $val){ ?>
	    <tr data-id="<?php echo $val['GiftImageCategory']['id']; ?>" >
		<td><?php echo $val['GiftImageCategory']['eng_title']; ?></td>
		<td><?php echo $val['GiftImageCategory']['ara_title']; ?></td>
		<td>
		    <?php echo $this->Html->link('<i class="fa icon-trash"></i>','javascript:void(0);', array('data-id'=>$val['GiftImageCategory']['id'],'title'=>'Delete','class'=>'delete_category','escape'=>false) ); ?>
		</td>
	    </tr>    
        <?php }?>
    </tbody>
</table>
   