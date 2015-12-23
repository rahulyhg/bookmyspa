<?php if(isset($breadcrumb) && !empty($breadcrumb)){ ?>
<div class="breadcrumbs">
    <ul class="breadcrumb">
        <?php
        $breadCnt = count($breadcrumb);
        $i=1;
        foreach($breadcrumb as $name=>$url){
            echo '<li>';
            echo $this->Html->link($name,$url);
            if($i < $breadCnt){
                echo '<i class="icon-angle-right"></i>';
            }
            echo '</li>';
            $i++;
            
        }?>
    </ul>
    <?php   if(isset($this->params) && !empty($this->params) && strtolower($this->params['controller']) == 'appointments' ){ ?>
        <div class=""><i class="fa fa-search search" style="cursor:pointer;float:right;margin-right:10px;
        margin-top:6px;"></i></div>
    <?php }?>
</div>
<?php } ?>
