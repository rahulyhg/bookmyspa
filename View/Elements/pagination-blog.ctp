<style type="text/css">
    .pagi-nation li.active a{
	background: #5b3671;
	color: #fff;
	border:1px solid #ddd 
    }
</style>


<ul class="pagination pull-right ff">                
<li class=""><?php 

echo $this->Paginator->prev('<< Previous ' . __(''),array('tag'=>''),null,array('class' => 'disabled','tag' => 'a'));?></li>
    <li>    
<li class="">
   <?php echo $this->Paginator->next(' Next >> ' . __(''),array('tag'=>''),null,array('class' => 'disabled','tag' => 'a'));?></li>
</ul>
