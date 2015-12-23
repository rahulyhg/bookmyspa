<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_layout; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Spa Industry admin panel">
        <meta name="author" content="SpaIndustry">
	<?php
            echo $this->Html->meta('icon');
            
            if(isset($auth_user)){
                $themeId = $this->Common->getThemeId($auth_user);
                switch($themeId){
                    case 2:
                        echo $this->Html->css('admin/utopia-dark');
                        break;
                    case 3:
                        echo $this->Html->css('admin/utopia-wooden');
                        break;
                    default:
                        echo $this->Html->css('admin/utopia-white');
                }
            }else{
                echo $this->Html->css('admin/utopia-white');
            }
            
            
            echo $this->Html->css('admin/utopia-responsive');
			echo $this->Html->css('admin/jquery.cleditor');
			echo $this->Html->css('admin/validationEngine.jquery');
			echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->Html->script('jquery.min');
            echo $this->Html->script('jquery.cookie');
            echo $this->fetch('script');
	?>
	<style>
		.loaderImage{
			background: none repeat scroll 0 0 rgba(0, 0, 0, 0.65);
			height: 100%;
			left: 0;
			position: absolute;
			top: 0;
			width: 100%;
			z-index: 2147483647;
			display: none;
		}
		.loaderImage img{
			display: block;
			left: 50%;
			margin-left: -32px;
			margin-top: -32px;
			position: absolute;
			top: 50%;
		}
	</style>
	<!--[if IE 8]>
		<?php echo $this->Html->css('admin/ie8'); ?>
	<![endif]-->
    
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
    <div class="container-fluid">
        <?php echo $this->element('admin/header'); ?>
        <div class="row-fluid">
            <!-- Sidebar starts -->
            <div class="span2 sidebar-container">
                <?php echo $this->element('admin/menu'); ?>
            </div>
            <!-- Sidebar end -->

            <!-- Body start -->
            <div class="span10 body-container">
                <?php if(isset($breadcrumb)){
                    echo $this->element('admin/breadcrumb'); 
                }?>
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->fetch('content'); ?>
            </div>
        </div>
    </div>

    <?php
    echo $this->Html->script('admin/utopia');
    //echo $this->Html->script('admin/jquery.cleditor');
    echo $this->Html->script('ckeditor/ckeditor');
    echo $this->Html->script('admin/chosen.jquery');
    echo $this->Html->script('admin/header.js?v1');
    echo $this->Html->script('admin/sidebar');
    echo $this->Html->script('admin/bundle/SCF.ui.js');
    echo $this->Html->script('admin/bundle/SCF.ui/commutator');
    echo $this->Html->script('admin/bundle/SCF.ui/checkbox');
    echo $this->Html->script('admin/bundle/SCF.ui/radio');
    echo $this->Html->script('admin/jquery.datatable');
    echo $this->Html->script('admin/tables');
    echo $this->Html->script('admin/jquery.validationEngine');
    echo $this->Html->script('admin/jquery.validationEngine-en');
    
    
    ?>
    <?php echo $this->element('sql_dump'); ?>
</body>
</html>
