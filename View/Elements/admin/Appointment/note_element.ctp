<?php //pr($note_history_array);  ?>
<h3>
    <?php   echo $this->Form->button('Add a note',array('user-id'=>base64_encode($userId),'type'=>'button','class'=>'btn btn-primary form-control-xs AddNote','label'=>false));
    ?>
</h3>
<table id="example" class="table table-striped table-bordered example" cellspacing="0" width="100%">
    <thead>
	<tr>
	    <th>Created Date</th>
            <th class="nosort">Added By</th>
            <th class="nosort">Type</th>
            <th class="nosort">Note Description</th>
            <th class="nosort">Edit</th>
            <th class="nosort">Delete</th>
	</tr>
    </thead>
    <tbody>
        <?php
	$note_history=$note_history_array;
	//pr($note_history); 
        if(isset($note_history) && $note_history != ""){
	   // pr($note_history_array); die;
	    //foreach ($note_history_array as $note_history){ ?>
	    <?php for ($i=0;$i<count($note_history);$i++){ ?>
		<tr>
                    <td><?php echo date('M d,Y',strtotime($note_history[$i]['Note']['created'])); ?></td>
                    <td><?php echo $this->Common->get_user_name($note_history[$i]['Note']['user_id']); ?></td>
		    <td><?php switch($note_history[$i]['Note']['category']) {
                            case 1: echo "Allergy";
                            break;
                            case 2: echo "Formula";
                            break;
                            case 3: echo "General";
                            break;
                            case 4: echo "Popup Notes";
                            break;
                        }   ?>
		    </td>						
		    <td><?php echo $note_history[$i]['Note']['description']; ?></td>
                    <td>
			<?php //echo $this->Html->link(__('<i class="glyphicon glyphicon-edit icon-white"></i> Edit'), array('controller' =>'appointments','action' => 'add_edit_note', base64_encode($note_history['Note']['user_id'])),array('class'=>'btn btn-primary form-control-xs','escape'=>false)); ?>
                    <?php echo $this->Form->button('Edit',array('type'=>'button','class'=>'btn btn-primary EditNote pull-left','label'=>false,'div'=>false,'value'=>base64_encode($note_history[$i]['Note']['user_id']),'note_id'=>$note_history[$i]['Note']['id']));?>
                    
                    </td>
		    <td>
			<?php //echo $this->Form->postLink(__('<i class="glyphicon glyphicon-delete icon-white"></i> Delete'), array('controller'=> 'appointments','action' => 'delete_note', base64_encode($note_history[$i]['Note']['user_id'])), array('class'=>'btn btn-primary form-control-xs','escape'=>false), __('Are you sure you want to delete this note?', base64_encode(base64_encode($note_history[$i]['Note']['user_id'])))); ?>
		    
		    <?php echo $this->Form->button('Delete',array('type'=>'button','class'=>'btn btn-primary DeleteNote pull-left','label'=>false,'div'=>false,'value'=>base64_encode($note_history[$i]['Note']['user_id']),'note_id'=>$note_history[$i]['Note']['id']));?>
		    </td>
		</tr>
            <?php //if($i==1){ die; } 
	    }
	}else{
            echo "No Notes Found";
	} ?>
    </tbody>
</table>
<script>
    $(document).ready(function(){
	$(document).find('.EditNote').click(function(){
	    var editNoteURL = "<?php echo $this->Html->url(array('controller'=>'appointments','action'=>'add_notes','admin'=>true)); ?>";
            var itsId = $(this).val();
	    var note_id=$(this).attr('note_id');
            fetchModal($forwardModal,editNoteURL+'/'+itsId+'/'+note_id+'/'+'edit');
	});
	$(document).find('.DeleteNote').click(function(){
	    var r = confirm("Would you like to delete Note?");
	    if (r==true) {
		var itsId = $(this).val();
		var note_id=$(this).attr('note_id');
		$.ajax({
		    url: '<?php echo $this->Html->url(array('controller'=>'appointments','action'=>'delete_notes','admin'=>true)); ?>',
		    method: "POST",
		    data: { note_id : note_id,
			    user_id:itsId
		    },
		}).done(function(response) {
		    if (response) {
			$(document).find("#sectionD").html(response);
		    }
		});
	    }else{
		return false;
	    }
	});
    });
</script>