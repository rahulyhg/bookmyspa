<script type="text/javascript">
    $(document).ready(function(){
	$(".custom_option").each(function(){
            $(this).wrap("<span class='option_wrapper'></span>");
            $(this).after("<span class='holder'></span>");
        });
        $(".custom_option").change(function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);
        }).trigger('change');
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
if ($('.scroll-append').height() > 600) {
    // Greater than 700px in height
	$('.scroll-append').addClass("active-scroll");
}

});

</script>

<div class="setting-wrapper">
    <div class="setting-block-rw">
    <div class="tag-block scroll-append">
	<div class="treat-head">
		<a class="cmn-magenta-btn" href="#">Create a New Tag</a>
	</div>
    <div class="tag-block-item">
    <ul>
        
        <li>
            <div class="tag-lft">
                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                <span class="tag-text">
                    Body
                </span>
            </div>
            <div class="tag-rt">
                <ul>
                    <li>
                        <?php echo $this->Form->input('che',array('div'=>false,'type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'&nbsp;'))); ?>
			<!--<label class="new-chk" for="test1122">&nbsp;</label>
			<input type="checkbox" id="test1122" />-->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-trash"></i></a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="tag-lft">
                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                <span class="tag-text">
                    Counselling & Holistic
                </span>
            </div>
            <div class="tag-rt">
                <ul>
                    <li>
                        <input type="checkbox" id="test2" />
						<label class="new-chk" for="test2">&nbsp;</label>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-trash"></i></a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="tag-lft">
                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                <span class="tag-text">
                    Dance
                </span>
            </div>
            <div class="tag-rt">
                <ul>
                    <li>
                        <input type="checkbox" id="test3" />
						<label class="new-chk" for="test3">&nbsp;</label>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-trash"></i></a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="tag-lft">
                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                <span class="tag-text">
                    Face
                </span>
            </div>
            <div class="tag-rt">
                <ul>
                    <li>
                        <input type="checkbox" id="test4" />
						<label class="new-chk" for="test4">&nbsp;</label>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-trash"></i></a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="tag-lft">
                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                <span class="tag-text">
                    Fitness
                </span>
            </div>
            <div class="tag-rt">
                <ul>
                    <li>
                        <input type="checkbox" id="test5" />
						<label class="new-chk" for="test5">&nbsp;</label>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-trash"></i></a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="tag-lft">
                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                <span class="tag-text">
                    Hair
                </span>
            </div>
            <div class="tag-rt">
                <ul>
                    <li>
                        <input type="checkbox" id="test6" />
						<label class="new-chk" for="test6">&nbsp;</label>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-trash"></i></a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="tag-lft">
                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                <span class="tag-text">
                    Hair removal
                </span>
            </div>
            <div class="tag-rt">
                <ul>
                    <li>
                        <input type="checkbox" id="test7" />
						<label class="new-chk" for="test7">&nbsp;</label>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-trash"></i></a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="tag-lft">
                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                <span class="tag-text">
                    Massage
                </span>
            </div>
            <div class="tag-rt">
                <ul>
                    <li>
                        <input type="checkbox" id="test8" />
						<label class="new-chk" for="test8">&nbsp;</label>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-trash"></i></a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="tag-lft">
                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                <span class="tag-text">
                    Medical & Dental
                </span>
            </div>
            <div class="tag-rt">
                <ul>
                    <li>
                        <input type="checkbox" id="test9" />
						<label class="new-chk" for="test9">&nbsp;</label>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-trash"></i></a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="tag-lft">
                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                <span class="tag-text">
                    Nails
                </span>
            </div>
            <div class="tag-rt">
                <ul>
                    <li>
                        <input type="checkbox" id="test10" />
						<label class="new-chk" for="test10">&nbsp;</label>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-trash"></i></a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
    </div>
    </div>
    <div class="category-block scroll-append">
    <div class="category-item">
        
        	<div class="panel-group" id="accordion">
                <div class="blog-li">
                	<a class="cmn-magenta-btn" href="#">Add Category</a>
            	</div>
                <div class="panel panel-default panel-active">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseone" aria-expanded="true" aria-controls="collapseone">
                            <span class="tag-lft">
                                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                                <span class="tag-text">
                                    Facials
                                </span>
                            </span>
                        </a>
                        <span class="tag-rt2">
				<input type="checkbox" id="test11" />
				<label class="new-chk" for="test11">&nbsp;</label>
                        </span>
                    </div>
                    <div id="collapseone" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapseone">
                        <div class="panel-body">
                            <div class="category-bx">
                                <div class="category-pic no-pic">
                                    <img src="/img/admin/treat-pic.png">
                                </div>
                                <div class="category-info">
                                    <div class="category-rw">
                                        <p class="category-txt">Weekly sale: 500</p>
                                        <p class="category-txt">Monthly sale: 3000</p>
                                        <div class="category-icons">
                                            <div><a href="#"><img src="/img/admin/clock-icn.png"></a></div>
                                            <div><a href="#"><i class="fa fa-pencil"></i></a></div>
                                            <div><a href="#"><i class="icon-trash"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                            <span class="tag-lft">
                                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                                <span class="tag-text">
                                    Makeup
                                </span>
                            </span>
                        </a>
                        <span class="tag-rt2">
                               <input type="checkbox" id="test12" />
						<label class="new-chk" for="test12">&nbsp;</label>
                        </span>
                    </div>
                    <div id="collapsetwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsetwo">
                        <div class="panel-body">
                            <div class="category-bx">
                                <div class="category-pic no-pic">
                                    <img src="/img/admin/treat-pic.png">
                                </div>
                                <div class="category-info">
                                    <div class="category-rw">
                                        <p class="category-txt">Weekly sale: 500</p>
                                        <p class="category-txt">Monthly sale: 3000</p>
                                        <div class="category-icons">
                                            <div><a href="#"><img src="/img/admin/clock-icn.png"></a></div>
                                            <div><a href="#"><i class="fa fa-pencil"></i></a></div>
                                            <div><a href="#"><i class="icon-trash"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapsethree" aria-expanded="true" aria-controls="collapsethree">
                            <span class="tag-lft">
                                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                                <span class="tag-text">
                                    HD Brows
                                </span>
                            </span>
                        </a>
                         <span class="tag-rt2">
                               <input type="checkbox" id="test13" />
						<label class="new-chk" for="test13">&nbsp;</label>
                         </span>
                    </div>
                    <div id="collapsethree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsethree">
                        <div class="panel-body">
                            <div class="category-bx">
                                <div class="category-pic">
                                    <img src="/img/admin/category-pic1.jpg">
                                </div>
                                <div class="category-info">
                                    <div class="category-rw">
                                        <p class="category-txt">Weekly sale: 500</p>
                                        <p class="category-txt">Monthly sale: 3000</p>
                                        <div class="category-icons">
                                            <div><a href="#"><img src="/img/admin/clock-icn.png"></a></div>
                                            <div><a href="#"><i class="fa fa-pencil"></i></a></div>
                                            <div><a href="#"><i class="icon-trash"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
                            <span class="tag-lft">
                                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                                <span class="tag-text">
                                    Makeup
                                </span>
                            </span>
                        </a>
                         <span class="tag-rt2">
                               <input type="checkbox" id="test14" />
						<label class="new-chk" for="test14">&nbsp;</label>
                            </span>
                    </div>
                    <div id="collapsefour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsefour">
                        <div class="panel-body">
                            <div class="category-bx">
                                <div class="category-pic">
                                    <img src="/img/admin/category-pic1.jpg">
                                </div>
                                <div class="category-info">
                                    <div class="category-rw">
                                        <p class="category-txt">Weekly sale: 500</p>
                                        <p class="category-txt">Monthly sale: 3000</p>
                                        <div class="category-icons">
                                            <div><a href="#"><img src="/img/admin/clock-icn.png"></a></div>
                                            <div><a href="#"><i class="fa fa-pencil"></i></a></div>
                                            <div><a href="#"><i class="icon-trash"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapsefive" aria-expanded="true" aria-controls="collapsefive">
                            <span class="tag-lft">
                                <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
                                <span class="tag-text">
                                    HD Brows
                                </span>
                            </span>
                        </a>
                        <span class="tag-rt2">
                               <input type="checkbox" id="test15" />
						<label class="new-chk" for="test15">&nbsp;</label>
						</span>
                    </div>
                    <div id="collapsefive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsefive">
                        <div class="panel-body">
                            <div class="category-bx">
                                <div class="category-pic">
                                    <img src="/img/admin/category-pic1.jpg">
                                </div>
                                <div class="category-info">
                                    <div class="category-rw">
                                        <p class="category-txt">Weekly sale: 500</p>
                                        <p class="category-txt">Monthly sale: 3000</p>
                                        <div class="category-icons">
                                            <div><a href="#"><img src="/img/admin/clock-icn.png"></a></div>
                                            <div><a href="#"><i class="fa fa-pencil"></i></a></div>
                                            <div><a href="#"><i class="icon-trash"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>	
    </div>
    <div class="treat-block scroll-append">
    <div class="treat-head">
    <div class="treat-head-col">
        <div class="search">
        <input type="search" placeholder="Search">
            <i>
                <img src="/img/admin/search-icon.png" alt="" title="">
            </i>
        </div>
    </div>
    <div class="treat-head-col">
        <div class="popular">
            <select class="custom_option">
                <option>Active</option>
                <option> Options </option>
                <option> Options </option>
            </select>
        </div>
    </div>
    <div class="treat-head-btn">
        <a class="cmn-magenta-btn" href="#">Add Treatment</a>
    </div>
    </div>
    <div class="treat-box">
    <ul>
        <li>
            <div class="treat-pic-box">
                <div class="treat-pic">
            <img src="/img/admin/category-pic1.jpg">
            </div>
                <div class="treat-info-rw">
                <div class="treat-check-rw">
                    <span class="treat-check-txt">
                    Silver Facial
                    </span>
                    <span class="treat-check">
                    <input type="checkbox" id="test16" />
						<label class="new-chk" for="test16">&nbsp;</label>
                    </span>
                </div>
                <div class="treat-info">
                    <p class="category-txt">Weekly sale: 500</p>
                    <p class="category-txt">Monthly sale: 3000</p>
                    <div class="category-icons">
                    <div><a href="#"><img src="/img/admin/clock-icn.png"></a></div>
                    <div><a href="#"><i class="fa fa-pencil"></i></a></div>
                    <div><a href="#"><i class="icon-trash"></i></a></div>
                    </div>
                </div>
            </div>
            </div>
        </li>
        <li>
            <div class="treat-pic-box">
                <div class="treat-pic no-pic">
            <img src="/img/admin/treat-pic.png">
            </div>
                <div class="treat-info-rw">
                <div class="treat-check-rw">
                    <span class="treat-check-txt">
                    Silver Facial
                    </span>
                    <span class="treat-check">
                    <input type="checkbox" id="test17" />
						<label class="new-chk" for="test17">&nbsp;</label>
                    </span>
                </div>
                <div class="treat-info">
                    <p class="category-txt">Weekly sale: 500</p>
                    <p class="category-txt">Monthly sale: 3000</p>
                    <div class="category-icons">
                    <div><a href="#"><img src="/img/admin/clock-icn.png"></a></div>
                    <div><a href="#"><i class="fa fa-pencil"></i></a></div>
                    <div><a href="#"><i class="icon-trash"></i></a></div>
                    </div>
                </div>
            </div>
            </div>
        </li>
        <li>
            <div class="treat-pic-box">
                <div class="treat-pic no-pic">
            <img src="/img/admin/treat-pic.png">
            </div>
                <div class="treat-info-rw">
                <div class="treat-check-rw">
                    <span class="treat-check-txt">
                    Silver Facial
                    </span>
                    <span class="treat-check">
                    <input type="checkbox" id="test18" />
						<label class="new-chk" for="test18">&nbsp;</label>
                    </span>
                </div>
                <div class="treat-info">
                    <p class="category-txt">Weekly sale: 500</p>
                    <p class="category-txt">Monthly sale: 3000</p>
                    <div class="category-icons">
                    <div><a href="#"><img src="/img/admin/clock-icn.png"></a></div>
                    <div><a href="#"><i class="fa fa-pencil"></i></a></div>
                    <div><a href="#"><i class="icon-trash"></i></a></div>
                    </div>
                </div>
            </div>
            </div>
        </li>
        <li>
            <div class="treat-pic-box">
                <div class="treat-pic no-pic">
            <img src="/img/admin/treat-pic.png">
            </div>
                <div class="treat-info-rw">
                <div class="treat-check-rw">
                    <span class="treat-check-txt">
                    Silver Facial
                    </span>
                    <span class="treat-check">
                    <input type="checkbox" id="test19" />
						<label class="new-chk" for="test19">&nbsp;</label>
                    </span>
                </div>
                <div class="treat-info">
                    <p class="category-txt">Weekly sale: 500</p>
                    <p class="category-txt">Monthly sale: 3000</p>
                    <div class="category-icons">
                    <div><a href="#"><img src="/img/admin/clock-icn.png"></a></div>
                    <div><a href="#"><i class="fa fa-pencil"></i></a></div>
                    <div><a href="#"><i class="icon-trash"></i></a></div>
                    </div>
                </div>
            </div>
            </div>
        </li>
        
        <li>
            <div class="treat-pic-box">
                <div class="treat-pic no-pic">
            <img src="/img/admin/treat-pic.png">
            </div>
                <div class="treat-info-rw">
                <div class="treat-check-rw">
                    <span class="treat-check-txt">
                    Silver Facial
                    </span>
                    <span class="treat-check">
                    <input type="checkbox" id="test20" />
						<label class="new-chk" for="test20">&nbsp;</label>
                    </span>
                </div>
                <div class="treat-info">
                    <p class="category-txt">Weekly sale: 500</p>
                    <p class="category-txt">Monthly sale: 3000</p>
                    <div class="category-icons">
                    <div><a href="#"><img src="/img/admin/clock-icn.png"></a></div>
                    <div><a href="#"><i class="fa fa-pencil"></i></a></div>
                    <div><a href="#"><i class="icon-trash"></i></a></div>
                    </div>
                </div>
            </div>
            </div>
        </li>
        <li>
            <div class="treat-pic-box">
                <div class="treat-pic no-pic">
            <img src="/img/admin/treat-pic.png">
            </div>
                <div class="treat-info-rw">
                <div class="treat-check-rw">
                    <span class="treat-check-txt">
                    Silver Facial
                    </span>
                    <span class="treat-check">
                    <input type="checkbox" id="test21" />
						<label class="new-chk" for="test21">&nbsp;</label>
                    </span>
                </div>
                <div class="treat-info">
                    <p class="category-txt">Weekly sale: 500</p>
                    <p class="category-txt">Monthly sale: 3000</p>
                    <div class="category-icons">
                    <div><a href="#"><img src="/img/admin/clock-icn.png"></a></div>
                    <div><a href="#"><i class="fa fa-pencil"></i></a></div>
                    <div><a href="#"><i class="icon-trash"></i></a></div>
                    </div>
                </div>
            </div>
            </div>
        </li>
    </ul>
    </div>
    </div>
    </div>
    <div class="setting-btm-btns">    	
    <div class="setting-btn-col">
    <a class="grey-btns" href="#">Cancel</a>
    <a class="magenta-btns" href="#">Save</a>
    </div>
    </div>
</div>

