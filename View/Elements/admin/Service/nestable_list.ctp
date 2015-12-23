<div class="tag-block scroll-append" >
                <div class="treat-head">
                    <?php echo $this->Html->link('Create a New Tag','javascript:void(0);',array('class'=>'cmn-magenta-btn addeditTag','data-id'=>'','alt'=>'Create a New Tag','title'=>'Create a New Tag')); ?>
                </div>
                <div class="tag-block-item for-scroll" style="height:589px" >
                    <?php echo $this->element('admin/Service/tags_list');?>
                </div>
            </div>
            <div class="category-block scroll-append">
                <div class="treat-head">
                    <a class="cmn-magenta-btn addeditCategory" data-id="" alt="Add Category" title="Add Category" href="javascript:void(0);">Add Category</a>
                    <?php echo $this->Form->hidden('forcheckT',array('label'=>false,'div'=>false)); ?>
                </div>
                <div class="category-item for-scroll" style="height:589px" >
                    <?php echo $this->element('admin/Service/category_list');?>
                </div>	
            </div>
            <div class="treat-block scroll-append">
                <div class="treat-head">
                    <div class="treat-head-col">
                        <div class="search">
                        <input class="forSearchTreat" type="search" placeholder="Search">
                            <i>
                                <img src="/img/admin/search-icon.png" alt="" title="">
                            </i>
                        </div>
                    </div>
                    <div class="treat-head-col">
                        <div class="popular">
                            <select class="form-control forfiltertreat">
                                <option value="2">Select Status</option>
                                <option value="1" > Active </option>
                                <option value="0"> InActive </option>
                            </select>
                        </div>
                    </div>
                    <div class="treat-head-btn">
                        <a class="cmn-magenta-btn addtreatment" data-id="" alt="Add Treatment" title="Add Treatment" href="javascript:void(0);">Add Treatment</a>
                    </div>
                </div>
            
            <div class="treat-box for-scroll" style="height:589px">
                <?php echo $this->element('admin/Service/treatment_list');?>  
            </div>
            </div>