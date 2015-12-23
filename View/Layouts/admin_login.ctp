    <!DOCTYPE html>
    <html lang="en">
        <head>
            <?php $logoData  = $this -> requestAction(array('controller' => 'settings','action' => 'getlogodata'));
                    if($logoData =="No Logo"){
                        $logoLink = "No Logo";
                        $logoimage = "logo/thumb/no_pic.png";
                    }else{
                        $logoLink = $logoData['Company']['name'];
                        $logoimage = "logo/thumb/".$logoData['Company']['logo'];
                    }
            ?>
            <?php echo $this->Html->charset('UTF-8'); ?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="">
            <meta name="author" content="">        
            <title>BuzzFeed - Admin </title>
            <?php
                echo $this->Html->css('admin/bootstrap'); 
                echo $this->Html->css('admin/sb-admin');
                echo $this->Html->css('admin/login');     
                echo $this->Html->css('admin/font/css/font-awesome.min');
                echo $this->Html->css('admin/custom_admin'); 
                echo $this->Html->script('jquery-1.7.2.min');
                echo $this->Html->script('jquery.validate');
            ?>                
        </head>    
        <body>
            <section class="container wrapper">
                <div class="row">
                    <nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">            
                        <div class="navbar-header ">             
                            <div class="logoimg"> <?php echo $this->Html->image($logoimage);?></div> 
                            <?php echo $this->Html->link($logoLink,'/admin',array('class' => 'navbar-brand logotxt','title' => $logoLink));?>
                        </div>
                        <div class="headerRightText">Administrator Panel</div>
                    </nav>
                    <div class="col-md-5 col-md-offset-4">
                        <div class="login-panel panel panel-default">
                            <?php echo $this->fetch('content'); ?>
                        </div>
                    </div>
                </div>
                <div class="push"></div>
            </section>
            <?php echo $this->element('admin/footer'); ?>  
        </body>
    </html>
