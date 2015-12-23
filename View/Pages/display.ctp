<!--Wrapper Start-->
        <section id="wrapper">
            <!--Content Start-->
            <section class="content popular_postclass">
			<!--Gallery Section Start-->
            	<section class="row">
                	<section class="col-xs-12">
                    	<h2 class="head"><?php echo $pageName;?></h2>
						<?php if(!empty($getPageArr)){
							 echo $getPageArr['Staticpage']['description'];
							 }else{ echo 'No contents for this Page.';}
						 ?>
				   </section>		
				</section>	
			</section>	
		 </section>		