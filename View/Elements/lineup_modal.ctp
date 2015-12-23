<div class="modal-dialog popup">
    <div class="modal-content">
        <section class="modal-header">
                    <button data-dismiss="modal" class="close close-btn" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h2 id="myModalLabel" class="modal-title">Meme</h2>
        </section>
        <?php echo $this->Form->create('Lineup', array('url' => array('controller' => 'contents', 'action' => 'lineup'), 'id' => 'lineupContent', 'type' => 'file')); ?>
        <input id="lineup_id" value="<?php echo $id;?>" name="data[Lineup][lineup_id]" type="hidden" />
       
            <section class="modal-body p-btm0">
                <section class="blue-bar clearfix">
                    <section class="selectlineup">
                        <?php
                            $lineup_class = 'lineup1';
                            if(!empty($datasets[0]['lineup_items'])){
                                foreach($datasets[0]['lineup_items'] as $key => $lineup_items){
                                    $players = json_decode($lineup_items['players']);
                                    $lineup_class = $lineup_items['lineup_class'];
                                }
                            }
                        ?>
                        <select id="changeLineup" class="form-control font16" name="data[Lineup][lineup_class]">
                            <?php 
                            foreach($lineup_select as $k => $v){
                                ?>
                                <option value="<?php echo $k;?>" <?php echo ($lineup_class == $k ? 'selected' : '');?>><?php echo $v;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </section>
                    <button id="insertLineup" data-loading-text="<?php echo (isset($this->data['id']) ? 'Updating...' : 'Inserting...');?>" class="btn button pull-right" type="submit"><i class="fa fa-upload font16"></i> <span><?php echo (isset($this->data['id']) ? 'Update' : 'Insert');?></span></button>
                </section>

                <!--Line Content Start-->
                  <section class="lineupcontent clearfix">
                    <section class="lineupwidget">
                        <section class="ground-surface <?php echo $lineup_class;?>">
<!--                            <a href="#" class="1" data-toggle="tooltip" title="Some tooltip text!">Hover over me</a>
                            <a href="#" class="ttt" data-toggle="tooltip" title="Some tooltip textfgfd!">Hover over me</a>
                            <a href="#" class="ttt" data-toggle="tooltip" title="Some tooltip textfdgfdg!">Hover over me</a>-->
<!--                              <span data-original-title="" id="tol" class="player-pos pos tootltip-info"></span> -->
<!--                                <span data-original-title="" id="tol" class="custom-tooltip pos tootltip-info">
                                    <span class="tooltip-label">Player Name</span>
                                    <div class="tooltip top fade in" role="tooltip">
                                    <div class="tooltip-arrow"></div>
                                   <div class="tooltip-inner">
                                    Some tooltip text!
                                    </div>
                                    </div>
                                    <span class="player-pos">
                                        1
                                    </span>
                                </span> -->
                            <?php 
                             if(!empty($players)){
                                 $key = 0;
                                 foreach($players as $position => $player){
                                 ?>
<!--                              <span data-original-title="" id="tol" class="player-pos pos tootltip-info">
                                  
                              </span> -->
                                    <span data-original-title="<?php echo $player->name;?>" id="tol<?php echo $key + 1;?>" class="custom-tooltip  pos<?php echo $key + 1;?> tootltip-info">
                                    <div class="tooltip top fade in" role="tooltip">
                                    <div class="tooltip-arrow"></div>
                                    <div class="tooltip-inner">
                                     <?php echo $player->name;?>
                                    </div>
                                    </div>
                                    <span class="player-pos">
                                   <?php echo $player->number;?>
                                    </span>
                                    </span>
                                 <?php
                                    $key++;
                                 }
                             }
                             else{
                                 for($i = 0; $i < 11; $i++){
                                    ?>
                                    <span data-original-title="Player Name" id="tol<?php echo $i + 1;?>" class="custom-tooltip pos<?php echo $i + 1;?> tootltip-info">
                                    <div class="tooltip top fade in" role="tooltip">
                                    <div class="tooltip-arrow"></div>
                                    <div class="tooltip-inner">
                                    player name
                                    </div>
                                    </div>
                                     <span class="player-pos">
                                    <?php echo $i + 1;?>
                                    </span>
                                    </span>   
    <?php
                                 }
                             }
                            ?>
                        </section>
                    </section>
                    <section class="lineupleft">
                        <ul class="players-lineup liststyle-none">
                            <?php
                                    if(!empty($players)){
                                        $key = 0;
                                        foreach($players as $position => $player){
                                            ?>
                                             <li>
                                                <label><span data-ref="pos<?php echo $key+1;?>" class="count-label">
                                                <input maxlength="2" type="text" value="<?php echo $player->number;?>" name="data[Lineup][players][<?php echo $position;?>][number]" /></span> <?php echo $position;?></label>
                                                <section class="playername">
                                                    <input data-ref="pos<?php echo $key+1;?>" type="text" value="<?php echo $player->name;?>" class="form-control" name="data[Lineup][players][<?php echo $position;?>][name]">
                                                </section>
                                            </li> 
                                            <?php
                                            $key++;
                                        }
                                    } else {
                                        
                                    ?>
                                    <li>
                                        <label><span data-ref="pos1" class="count-label">
                                        <input maxlength="2" type="text" value="1" name="data[Lineup][players][GK][number]" /></span> GK</label>
                                        <section class="playername">
                                            <input data-ref="pos1" required="required" type="text" placeholder="Name" maxlength="15" class="form-control" name="data[Lineup][players][GK][name]">
                                        </section>
                                    </li>
                                    <li>
                                        <label><span data-ref="pos2" class="count-label"><input maxlength="2" type="text" value="2" name="data[Lineup][players][RB][number]" /></span> RB</label>
                                        <section class="playername">
                                            <input data-ref="pos2" required="required"  type="text" maxlength="15" placeholder="Name" class="form-control" name="data[Lineup][players][RB][name]">
                                        </section>
                                    </li>
                                    <li>
                                        <label><span data-ref="pos3" class="count-label"><input maxlength="2" type="text" value="3" name="data[Lineup][players][RCB][number]" /></span> RCB</label>
                                        <section class="playername">
                                            <input data-ref="pos3" required="required" type="text" maxlength="15" placeholder="Name" class="form-control" name="data[Lineup][players][RCB][name]">
                                        </section>
                                    </li>
                                    <li>
                                        <label><span data-ref="pos4" class="count-label"><input maxlength="2" type="text" value="4" name="data[Lineup][players][LCB][number]" /></span> LCB</label>
                                        <section class="playername">
                                            <input data-ref="pos4" required="required" maxlength="15" type="text" placeholder="Name" class="form-control" name="data[Lineup][players][LCB][name]">
                                        </section>
                                    </li>
                                    <li>
                                        <label><span data-ref="pos5" class="count-label"><input maxlength="2" type="text" value="5" name="data[Lineup][players][LB][number]" /></span> LB</label>
                                        <section class="playername">
                                            <input data-ref="pos5" required="required" maxlength="15" type="text" placeholder="Name" class="form-control" name="data[Lineup][players][LB][name]">
                                        </section>
                                    </li>
                                    <li>
                                        <label><span data-ref="pos6" class="count-label"><input maxlength="2" type="text" value="6" name="data[Lineup][players][DM][number]" /></span> DM</label>
                                        <section class="playername">
                                            <input data-ref="pos6" required="required" maxlength="15" type="text" placeholder="Name" class="form-control" name="data[Lineup][players][DM][name]">
                                        </section>
                                    </li>
                                    <li>
                                        <label><span data-ref="pos7" class="count-label"><input maxlength="2" type="text" value="7" name="data[Lineup][players][CM][number]" /></span> CM</label>
                                        <section class="playername">
                                            <input data-ref="pos7" required="required" maxlength="15" type="text" placeholder="Name" class="form-control" name="data[Lineup][players][CM][name]">
                                        </section>
                                    </li>
                                    <li>
                                        <label><span data-ref="pos8" class="count-label"><input maxlength="2" type="text" value="8" name="data[Lineup][players][RM][number]" /></span> RM</label>
                                        <section class="playername">
                                            <input data-ref="pos8" required="required" maxlength="15"  type="text" placeholder="Name" class="form-control" name="data[Lineup][players][RM][name]">
                                        </section>
                                    </li>
                                    <li>
                                        <label><span data-ref="pos9" class="count-label"><input maxlength="2" type="text" value="9" name="data[Lineup][players][LM][number]" /></span> LM</label>
                                        <section class="playername">
                                            <input data-ref="pos9" required="required" type="text" maxlength="15"  placeholder="Name" class="form-control" name="data[Lineup][players][LM][name]">
                                        </section>
                                    </li>
                                    <li>
                                        <label><span data-ref="pos10" class="count-label"><input maxlength="2" type="text" value="10" name="data[Lineup][players][SS][number]" /></span> SS</label>
                                        <section class="playername">
                                            <input data-ref="pos10" required="required" type="text" maxlength="15"  placeholder="Name" class="form-control" name="data[Lineup][players][SS][name]">
                                        </section>
                                    </li>
                                    <li>
                                        <label><span data-ref="pos11" class="count-label"><input maxlength="2" type="text" value="11" name="data[Lineup][players][LF][number]" /></span> LF</label>
                                        <section class="playername">
                                        <input data-ref="pos11" required="required" type="text" maxlength="15"  placeholder="Name" class="form-control" name="data[Lineup][players][LF][name]">
                                        </section>
                                    </li>
                                    <?php
                                      
                                }
                            ?>
                        </ul>
                    </section>
                </section>
                <!--Line Content Closed-->
            </section>
        
        <?php echo $this->Form->end(); ?>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script type="text/javascript">
$(document).ready(function(){
$('#changeLineup').trigger('change');
});
</script>