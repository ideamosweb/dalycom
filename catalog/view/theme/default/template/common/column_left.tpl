<?php // if ($modules) { ?>
<!-- <div id="column-left">
  <?php // foreach ($modules as $module) { ?>
  <?php // echo $module; ?>
  <?php // } ?>
</div> !-->
<?php // } ?>
<!-- MENU SECTION START (LEFT SIDEBAR) -->
<div id="menu">    
    <!-- HEADER START -->           
    <!--BUSCADOR-->
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>        
    <div class="warning" id="warning_login" style="display:none; padding:2px 2px 2px 10px; font-size:10px;"></div>                
    <div class="buscar">                
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-login">
            <div style="color:#F8F8F8; float:left">Usuario</div>
            <!-- <div style="float:left;"><img src="images/usuario.png" width="187" height="29"></div> !-->
            <div style="float:left;"><input class="loginarea" type="text" id="user_login" name="username" value="<?php echo isset($username) ? $username : ''; ?>" /></div>
            <div style="color:#F8F8F8; float:left">Contraseña</div>
            <div style="float:left;"><input class="loginarea" type="password" id="pass_login" name="password" value="<?php echo isset($password) ? $password : ''; ?>" /></div>
            <div>
                <a class="button-login" onclick="sendFormLogin();">Login</a>            
            </div>
            
        </form>                        
    </div>

    
    <!-- HEADER END -->      
    <!-- NAVIGATION MENU START -->
    <div id="menu_list">       
        <ul class="sf-menu sf-vertical sf-js-enabled sf-shadow">
            <li><a href="#">Inicio</a></li>
            <?php if ($categories) { ?>
            <?php foreach ($categories as $category) { ?>
            <?php $href = $category['name'] == 'Soporte Técnico' ? 'index.php?route=information/contactsoporte' : $category['href'] ?>
            <li><a href="<?php echo $href ?>"><?php echo $category['name'] ?></a>
                <?php if ($category['children']) { ?>                            
                <ul>
                    <?php for ($i = 0; $i < count($category['children']); $i++) { ?>
                    <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
                    <?php for (; $i < $j; $i++) { ?>
                    <?php if (isset($category['children'][$i])) { ?>
                    <li><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a>
                        <?php if ($category['children'][$i]['children_lv1']) { ?>
                        <ul>
                            <?php if ($category['children'][$i]['children_lv1'][$i]) { ?>
                            <?php $k = count($category['children'][$i]['children_lv1']); ?>
                            <?php for ($l = 0; $l < $k; $l++) { ?>
                            <li><a href="<?php echo $category['children'][$i]['children_lv1'][$l]['href'] ?>"><?php echo $category['children'][$i]['children_lv1'][$l]['name'] ?></a></li>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </li>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>                                
                </ul>                            
                <?php } ?>
            </li>
            <?php } ?>
            <?php } ?>
            <li><a href="#">Servicio al Cliente</a>
                <ul>
                    <li><a href="<?php echo HTTP_SERVER ?>index.php?route=information/information&information_id=9">Devoluciones</a></li>
                    <li><a href="<?php echo HTTP_SERVER ?>index.php?route=information/information&information_id=10">Información Despachos</a></li>
                    <li><a href="<?php echo HTTP_SERVER ?>index.php?route=information/information&information_id=11">Opciones de Compra</a>
                </ul>
            </li>                                           
        </ul>                   
    </div>    
    <div class="social_media">
        <div class="left"><a class="face" href=""></a></div>
        <div class="right"><a class="twitt" href=""></a></div>   		
    </div>
    <div class="der_reserv">
        <p>Todos los derechos Reservados ® Dalycom Ltda C/R 2012</p>
        <p>Todas las marcas son propiedad de sus respectivas compañias</p>
        <p>Desarrollado por Ideamosweb</p>
    </div>            
</div>
