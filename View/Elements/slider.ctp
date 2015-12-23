<!--Slider Start-->
    <?php //echo $this->html->script('jquery.bxslider/jquery.bxslider');
     = (strtotime(date('D-m-Y H:i:s'));
    ?>
    <?php echo $this->html->css('bxslider/jquery.bxslider.css?v='.$sl_time); ?>
  <script>
    $(document).ready(function(){
    $('.slider').bxSlider({
    minSlides: 1,
    maxSlides: 5,
    slideWidth: 280,
    slideMargin: 2,
    nextSelector: '.next',
    prevSelector: '.previous',
    nextText: '<i class="fa fa-angle-right"></i>',
    prevText: '<i class="fa fa-angle-left"></i>',
    pager:false,
});
	});
</script>

   
<figure>
    	<section class="slider-widget">
        	<a href="#" class="previous disablebtn">
				<!--<i class="fa fa-angle-left"></i>-->
        	</a>
            <a href="#" class="next">
				<!--<i class="fa fa-angle-right"></i>-->
			</a>
        	<ul class="slider clearfix" style="width:2000px;">
        	<li>
                    <p class="slideimg"><?php echo $this->Html->image('home/slideimg1.jpg', array('alt' => ''));?></p>
                    <p class="slideimg-wrap"><?php echo $this->Html->image('home/bannerfade.png', array('alt' => ''));?></p>
                    <section class="slidecontent">
                    	<section class="centerdcon">
                            <h4>Sports</h4>
                            <p class="sltext">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim rure aborum.</p>
                            <p class="byjenna">By Jenna Kagel</p>
                        </section>
                    </section>
                    
                    <section class="hovercontent">
                        <span class="userpic"><?php echo $this->Html->image('home/userpic3.png', array('alt' => ''));?></span>
                        <span class="post-time"><?php echo $this->Html->link(('Riko'), '#',
						     array('escape' => false));?> - 9 days ago</span>
                   </section>
                </li>
                <li >
                	<p class="slideimg"><?php echo $this->Html->image('home/slideimg2.jpg', array('alt' => ''));?></p>
                    <p class="slideimg-wrap"><?php echo $this->Html->image('home/bannerfade.png', array('alt' => ''));?></p>
                    <section class="slidecontent">
                    	<section class="centerdcon">
                            <h4>Sports</h4>
                            <p class="sltext">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim rure aborum.</p>
                            <p class="byjenna">By Jenna Kagel</p>
                        </section>
                    </section>
                    
                    <section class="hovercontent">
                        <span class="userpic"><?php echo $this->Html->image('home/userpic3.png', array('alt' => ''));?></span>
                        <span class="post-time"><?php echo $this->Html->link(('Riko'), '#',
						     array('escape' => false));?></span>
                   </section>
                </li>
                <li>
                	<p class="slideimg"><?php echo $this->Html->image('home/slideimg3.jpg', array('alt' => ''));?></p>
                    <p class="slideimg-wrap"><?php echo $this->Html->image('home/bannerfade.png', array('alt' => ''));?></p>
                    <section class="slidecontent">
                    	<section class="centerdcon">
                            <h4>Sports</h4>
                            <p class="sltext">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim rure aborum.</p>
                            <p class="byjenna">By Jenna Kagel</p>
                        </section>
                    </section>
                    
                    <section class="hovercontent">
                        <span class="userpic"><?php echo $this->Html->image('home/userpic3.png', array('alt' => ''));?></span>
                        <span class="post-time"><?php echo $this->Html->link(('Riko'), '#',
						     array('escape' => false));?> - 9 days ago</span>
                   </section>
                </li>
                <li>
                	<p class="slideimg"><?php echo $this->Html->image('home/slideimg4.jpg', array('alt' => ''));?></p>
                    <p class="slideimg-wrap"><?php echo $this->Html->image('home/bannerfade.png', array('alt' => ''));?></p>
                    <section class="slidecontent">
                    	<section class="centerdcon">
                            <h4>Sports</h4>
                            <p class="sltext">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim rure aborum.</p>
                            <p class="byjenna">By Jenna Kagel</p>
                        </section>
                    </section>
                    <section class="hovercontent">
                        <span class="userpic"><?php echo $this->Html->image('home/userpic3.png', array('alt' => ''));?></span>
                        <span class="post-time"><?php echo $this->Html->link(('Riko'), '#',
						     array('escape' => false));?> - 9 days ago</span>
                   </section>
                </li>
                 <li>
                	<p class="slideimg"><?php echo $this->Html->image('home/slideimg4.jpg', array('alt' => ''));?></p>
                    <p class="slideimg-wrap"><?php echo $this->Html->image('home/bannerfade.png', array('alt' => ''));?></p>
                    <section class="slidecontent">
                    	<section class="centerdcon">
                            <h4>Sports</h4>
                            <p class="sltext">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim rure aborum.</p>
                            <p class="byjenna">By Jenna Kagel</p>
                        </section>
                    </section>
                    
                    <section class="hovercontent">
                        <span class="userpic"><?php echo $this->Html->image('home/userpic3.png', array('alt' => ''));?></span>
                        <span class="post-time"><?php echo $this->Html->link(('Riko'), '#',
						     array('escape' => false));?> - 9 days ago</span>
                   </section>
                </li>
            </ul>
        </section>
    </figure>
   
    <!--Slider Closed    -->
