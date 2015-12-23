<style>
  body
{
    margin-top: 20px;
}
.panel
{
    text-align: center;
}
.panel:hover { box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4), 0 1px 5px rgba(130, 130, 130, 0.35); }
.panel-body
{
    padding: 0px;
    text-align: center;
}

.the-price
{
    background-color: rgba(220,220,220,.17);
    box-shadow: 0 1px 0 #dcdcdc, inset 0 1px 0 #fff;
    padding: 20px;
    margin: 0;
}

.the-price h1
{
    line-height: 1em;
    padding: 0;
    margin: 0;
}

.subscript
{
    font-size: 25px;
}

/* CSS-only ribbon styles    */
.cnrflash
{
    /*Position correctly within container*/
    position: absolute;
    top: -9px;
    right: 4px;
    z-index: 1; /*Set overflow to hidden, to mask inner square*/
    overflow: hidden; /*Set size and add subtle rounding  		to soften edges*/
    width: 100px;
    height: 100px;
    border-radius: 3px 5px 3px 0;
}
.cnrflash-inner
{
    /*Set position, make larger then 			container and rotate 45 degrees*/
    position: absolute;
    bottom: 0;
    right: 0;
    width: 145px;
    height: 145px;
    -ms-transform: rotate(45deg); /* IE 9 */
    -o-transform: rotate(45deg); /* Opera */
    -moz-transform: rotate(45deg); /* Firefox */
    -webkit-transform: rotate(45deg); /* Safari and Chrome */
    -webkit-transform-origin: 100% 100%; /*Purely decorative effects to add texture and stuff*/ /* Safari and Chrome */
    -ms-transform-origin: 100% 100%;  /* IE 9 */
    -o-transform-origin: 100% 100%; /* Opera */
    -moz-transform-origin: 100% 100%; /* Firefox */
    background-image: linear-gradient(90deg, transparent 50%, rgba(255,255,255,.1) 50%), linear-gradient(0deg, transparent 0%, rgba(1,1,1,.2) 50%);
    background-size: 4px,auto, auto,auto;
    background-color: #aa0101;
    box-shadow: 0 3px 3px 0 rgba(1,1,1,.5), 0 1px 0 0 rgba(1,1,1,.5), inset 0 -1px 8px 0 rgba(255,255,255,.3), inset 0 -1px 0 0 rgba(255,255,255,.2);
}
.cnrflash-inner:before, .cnrflash-inner:after
{
    /*Use the border triangle trick to make  				it look like the ribbon wraps round it's 				container*/
    content: " ";
    display: block;
    position: absolute;
    bottom: -16px;
    width: 0;
    height: 0;
    border: 8px solid #800000;
}
.cnrflash-inner:before
{
    left: 1px;
    border-bottom-color: transparent;
    border-right-color: transparent;
}
.cnrflash-inner:after
{
    right: 0;
    border-bottom-color: transparent;
    border-left-color: transparent;
}
.cnrflash-label
{
    /*Make the label look nice*/
    position: absolute;
    bottom: 0;
    left: 0;
    display: block;
    width: 100%;
    padding-bottom: 5px;
    color: #fff;
    text-shadow: 0 1px 1px rgba(1,1,1,.8);
    font-size: 0.95em;
    font-weight: bold;
    text-align: center;
}
</style>

<div class="container">
     <div class="row">
      <div class="col-sm-10">
    <?php if(count($plans)){
        $i = 0; foreach($plans as $plan){
           // pr($plan);
          if($i % 4==0){
           echo '<div class="row">';
          }
    ?>
          <div class="col-xs-12 col-md-3">
            <div class="panel panel-info">
              <?php if($plan['SmsSubscriptionPlan']['discount'] >=1 ){ ?>
                <div class="cnrflash">
                   <div class="cnrflash-inner">
                       <span class="cnrflash-label"><?php echo $plan['SmsSubscriptionPlan']['discount']; ?>%
                           <br>
                           DISCOUNT</span>
                   </div>
                </div>
            <?php   } ?>
             
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo $plan['SmsSubscriptionPlan']['title']; ?></h3>
                </div>
                <div class="panel-body">
                    <div class="the-price">
                        <h1>
                            AED <?php echo $plan['SmsSubscriptionPlan']['price'];
                            $plan_type = $plan['SmsSubscriptionPlan']['plan_type'];
                            if($plan_type=='M'){
                              $plan_type_val = '1 month';
                            }else if($plan_type=='BA'){
                               $plan_type_val = '6 month';
                            }else{
                              $plan_type_val = '1 Year';
                            }
                            
                            ?>
                           <!-- <span class="subscript">/<?php echo $plan_type_val; ?></span>-->
                        </h1>
                        <small>Validity <?php echo $plan_type_val; ?></small>
                    </div>
                    <table class="table">
                        <tr>
                            <td>
                              <?php
                                echo ($plan['SmsSubscriptionPlan']['customer_type']==0)?'Sieasta':'Own'; ?> customers
                               
                             </td>
                        </tr>
                        <tr class="active">
                            <td>
                           <?php   echo $plan['SmsSubscriptionPlan']['no_of_sms'].' Sms'; ?>
                            </td>
                        </tr>
                        
                        
                    </table>
                </div>
                  <div class="panel-footer">
                    <?php echo $this->Html->link('Buy' ,array('controller'=>'Marketing','action'=>'payment','admin'=>true , base64_encode($plan['SmsSubscriptionPlan']['id'])),array('class'=>'btn btn-success')); ?>
                      <!--<a href="" class="btn btn-success" role="button">Sign Up</a>-->
                  </div>
            </div>
        </div>
    <?php
     
       echo ($i % 4==3)?'</div>':'';
       $i++; }
       }else{ echo 'No records Found';}  ?>
     </div>
</div>
