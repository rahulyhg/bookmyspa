<div class="alert alert-success clearfix" id="success_hide">
                        <a href="javascript:void(0)" data-dismiss="alert" class="pos-lft close">x</a>
                        <span class="pos-rgt"><?php echo $message ?></span>
 </div>
<script>
    $(document).ready(function(){
         setTimeout(function() { $("#success_hide").hide("slow"); }, 2000);
    });
</script>
