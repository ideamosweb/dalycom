<?php if (isset($_SERVER['HTTP_USER_AGENT']) && !strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) echo '<?xml version="1.0" encoding="UTF-8"?>'. "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/style.css" media="screen" />
<link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Pontano+Sans' rel='stylesheet' type='text/css'>
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/external/jquery.cookie.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />
<script type="text/javascript" src="catalog/view/javascript/jquery/tabs.js"></script>
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<!-- Superfish Menu !-->
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/superfish-1.4.8/css/superfish.css" media="screen">
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/superfish-1.4.8/css/superfish-vertical.css" media="screen">
<script type="text/javascript" src="catalog/view/javascript/jquery/superfish-1.4.8/js/hoverIntent.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/superfish-1.4.8/js/superfish.js"></script>
<!-- End Superfish Menu !-->    
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!-- Scripts by new template !-->
<script type="text/javascript">    
	$(document).ready(function(){	
		$("#slider").easySlider({
			auto: true, 
			continuous: true,
			controlsShow: true,
			pause: 5000
		});

        $('#form-login input').keydown(function(e) {            
            if (e.keyCode == 13) {
                sendFormLogin();
            }
        });
    });

    function sendFormLogin(){
        var user = $('#user_login').val();
        var pass = $('#pass_login').val();
        if(user == "" || pass == ""){
            $('#warning_login').show();
            $('#warning_login').html('');
            $('#warning_login').append('Campos no debe quedar vacios');
        }else{            
            var path = "<?php echo $action; ?>";
            $.ajax({
            type: "POST",
            url: path,
            data: $('#form-login').serialize(),
            }).done(function( msg ) {
                var json_data = JSON.parse(msg);                
                if(json_data.error == "" && json_data.redirect != ""){                    
                    window.location.href = json_data.redirect;
                }else{                    
                    $('#warning_login').show();
                    $('#warning_login').html('');
                    $('#warning_login').append(json_data.error);                    
                }
            });
        }
        
    }    	
</script>
<!-- Superfish Vertical menu script !-->
<script type="text/javascript">
// initialise plugins
jQuery(function(){
        jQuery('ul.sf-menu').superfish({ 
            animation: {height:'show'},   // slide-down effect without fade-in 
            delay:     1200               // 1.2 second delay on mouseout 
        });
});

</script>
<!-- end Superfish Vertical menu script !-->
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<?php echo $google_analytics; ?>
<!-- Style for vertical menu !-->
<style type="text/css">

</style>
</head>
<body>
<div id="container">
    <!-- HEADER BANNER -->
	<div class="content_header">
    	<div class="fondo_header">
   	      	<img src="catalog/view/theme/default/image/baner_sup4.png" width="980" height="128">
        </div>
    	<div class="logo">
                <?php if ($logo) { ?>
                <div class="logo-d">
                    <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" width="446" height="51"></a>
    		</div>
                <?php } ?>
                <?php if ($categories) { ?>
                <div class="menu-header">
                    <ul>
                        <li><a href="#">Inicio  |</a></li>
                        <li><a href="<?php echo HTTP_SERVER ?>index.php?route=information/information&information_id=7">Quiénes Somos  |</a></li>
                        <li><a href="<?php echo HTTP_SERVER ?>index.php?route=information/information&information_id=8">Misión y Visión  |</a></li>
                        <li><a href="<?php echo HTTP_SERVER ?>index.php?route=information/contact">Contáctanos</a></li>
                    </ul>
                </div>
                <?php } ?>    		        	    		
        </div>
        <div style="float:right; position:absolute; right:17px; z-index:1; width:390px;">
        	
                    <div class="infor-headertop"><span style="color:#0D5FBF">Encuentra tu producto aquí </span></div>
       		  <!-- <ul>
       			<li><a href="#">Iniciar Sesión  |</a></li>
           		<li><a href="#">Registrate  |</a></li>
           		<li><a href="#">Soporte Técnico  |</a></li>                
       		  </ul>-->
        	
            <div class="clear"></div>            
            <div class="buscar-header">       	    	
                <div id="search">
                    <div class="button-search"></div>
                    <?php if ($filter_name) { ?>
                    <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" />
                    <?php } else { ?>
                    <input type="text" name="filter_name" value="<?php echo $text_search; ?>" onclick="this.value = '';" onkeydown="this.style.color = '#000000';" />
                    <?php } ?>
                </div>
            </div>
            <div class="infor-header">Llámanos: <span style="color:#0D5FBF">(5)3689615; (5)3685422 </span>Fax: <span style="color:#0D5FBF">(5)3689612</span></div>
            <div class="clear"></div>        	          
      	</div>       
	</div>    
    
<div id="notification"></div>
