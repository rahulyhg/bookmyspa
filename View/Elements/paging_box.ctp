<style>


.next
{
  background: -moz-linear-gradient(center bottom , #EEEEEE 50%, #FFFFFF 50%) repeat scroll 0 0 transparent;
    border: 1px solid #CCCCCC;
    color: #000000;
    display: block;
    height: 22px;
    line-height: 22px;
    padding: 0 5px;
}
.prev
{
  background: -moz-linear-gradient(center bottom , #EEEEEE 50%, #FFFFFF 50%) repeat scroll 0 0 transparent;
    border: 1px solid #CCCCCC;
    color: #000000;
    display: block;
    height: 22px;
    line-height: 22px;
    padding: 0 5px;
}

.homeLink
{
  background: -moz-linear-gradient(center bottom , #EEEEEE 50%, #FFFFFF 50%) repeat scroll 0 0 transparent;
    border: 1px solid #CCCCCC;
    color: #000000;
    display: block;
    height: 22px;
    line-height: 22px;
    padding: 0 5px;
}

.current {
    display: block;
    height: 22px;
    line-height: 22px;
    padding: 0 5px;
    text-decoration:none;
    background:#5b3671;
    border:1px solid #787878;
    color:#ffffff;
}

/*.mypaging { float:right; margin:10px 0;} */
.mypaging { float:right; margin-right: 0px; text-align:right;} 
.mypaging span { /*float:left;*/ display: inline-block; margin-left:0px;}
.mypaging span a { display:block; border:1px solid #ccc; height:22px; line-height:22px; padding:0 5px; color:#000;
	background: -webkit-gradient(
		linear,
		left bottom,
		left top,
		color-stop(0.50, rgb(238,238,238)),
		color-stop(0.50, rgb(255,255,255))
	);
	background: -moz-linear-gradient(
		center bottom,
		rgb(238,238,238) 50%,
		rgb(255,255,255) 50%
	);
	background: -o-linear-gradient(
		bottom,
		rgb(238,238,238) 50%,
		rgb(255,255,255) 50%
	);
}
.pagiarea { padding:3px 5px; overflow:hidden;}
.mypaging span a:hover, .mypaging span a.active {
    text-decoration:none;
    background:#EBCAFE;
    border:1px solid #787878;
    color:#ffffff;
    height:22px;
    line-height:22px;
    padding:0 5px;
    display:block; 
    }


</style>


<?php if(isset($this->params['models'][0]))
 $model_name = $this->params['models'][0] ;
?>
<section style="width: 100%; float: right; margin-top: 10px;">
<?php if($this->Paginator->numbers()){
	//echo $target_page_url = SITE_URL.ltrim($_SERVER['REQUEST_URI'], "/");
	$target_page_url = "/".ltrim($_SERVER['REQUEST_URI'], "/");
	//echo $form->create($model_name,array("action"=>"index","method"=>"post", "id"=>"frmRecordsPages", "name"=>"frmRecordsPages"));
	?>


<div style="float:right;" class="mypaging">
<?php
	echo $this->Paginator->first('First', array('class'=>""));echo '&nbsp;&nbsp;';
	echo $this->Paginator->prev('Previous',array('class'=>""));  echo '&nbsp;&nbsp;';
	echo $this->Paginator->numbers(); echo '&nbsp;&nbsp;';
	echo $this->Paginator->next('Next',array('class'=>"")); echo '&nbsp;';
	echo $this->Paginator->last('Last',array('class'=>""));
	echo $this->Js->writeBuffer();
    }
?>
</div>
</section> 
