
<?php 
//echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js');  
//echo $this->Html->script('admin/oauthpopup');  ?>

<script type="text/javascript">
    $.oauthpopup = function (options) {
        options.windowName = options.windowName || 'ConnectWithOAuth';
        options.windowOptions = options.windowOptions || 'location=0,status=0,width='+options.width+',height='+options.height+',scrollbars=1';
        options.callback = options.callback || function () {
            window.location.reload();
        };
        var that = this;
        that._oauthWindow = window.open(options.path, options.windowName, options.windowOptions);
        that._oauthInterval = window.setInterval(function () {
            if (that._oauthWindow.closed) {
                window.clearInterval(that._oauthInterval);
                options.callback();
            }
        }, 1000);
    };
$(document).ready(function(){
    $('#facebook').click(function(e){
       
        $.oauthpopup({
            path: '/Users/facebook_login',
			width:600,
			height:300,
            callback: function(){
                window.location.reload();
            }
        });
		e.preventDefault();
    });
});


</script>

<?php 
//$ses_user=$this->Session->read('User');
//$logout=$this->Session->read('logout');
//
//if(!$this->Session->check('User') && empty($ses_user))   { 

echo $this->Html->image('facebook.png',array('id'=>'facebook','style'=>'cursor:pointer;float:left;margin-left:50px;'));
// }  else{
//	
// echo '<img src="https://graph.facebook.com/'. $ses_user['id'] .'/picture" width="30" height="30"/><div>'.$ses_user['name'].'</div>';	
//	echo '<a href="'.$logout.'">Logout</a>';
//
//	
//	
//	
//}
	?>

