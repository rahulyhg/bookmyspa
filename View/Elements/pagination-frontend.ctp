<style type="text/css">
    .pagi-nation li.active a{
	background: #5b3671;
	color: #fff;
	border:1px solid #ddd
    }
</style>

<ul class="pagination hidden-xs hidden-sm hidden-md-block visible-lg-block pull-right">                
    <li class=""><?php 

echo $this->Paginator->prev('< Previous ' . __(''),array('tag'=>''),null,array('class' => 'disabled','tag' => 'a'));?></li>
    <li> 
	<?php echo $this->Paginator->numbers( array('class'=>'numbers','tag' => 'li', 'separator' => ' ', 'currentClass' => 'active', 'currentTag' => 'a' ) );?>
	</li>
    <li><?php echo $this->Paginator->next(' Next > ' . __(''),array('tag'=>''),null,array('class' => 'disabled','tag' => 'a'));?></li>
</ul>

<ul class="pagination visible-xs visible-sm visible-md-block hidden-lg-block pull-right">                
    <li class=""><?php 

echo $this->Paginator->prev('< Previous ' . __(''),array('tag'=>''),null,array('class' => 'disabled','tag' => 'a'));?></li>
    <li> 
	<?php echo $this->Paginator->numbers( array('class'=>'numbers', 'modulus' => 3,'tag' => 'li', 'separator' => ' ', 'currentClass' => 'active', 'currentTag' => 'a' ) );?>
	</li>
    <li><?php echo $this->Paginator->next(' Next > ' . __(''),array('tag'=>''),null,array('class' => 'disabled','tag' => 'a'));?></li>
</ul>