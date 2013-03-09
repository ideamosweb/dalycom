<!-- <div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <div class="box-product">
      <?php foreach ($products as $product) { ?>
      <div>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
      </div>
      <?php } ?>
    </div>
  </div>
</div> !-->




<div class="log_prov">
    <?php $count = 1; 
          $side = "";  
    ?>
    <?php foreach ($products as $product) { ?>
    <?php $side = ($count % 2 == 0) ? "left" : "right"; ?>
        <div class="cuadro-partes <?php echo $side; ?>">          
        <span class="top-cpartes"></span>
                <div style="background-color:#F4F4F4">                        
                    <div style="overflow:hidden">
                        <a href="<?php echo $product['href_category_parent']; ?>"><img style="float:left; margin: 32px 0 0 11px;" src="<?php echo $product['manufacturer_img']; ?>"></a>
                        <div class="content-dest">
                        <p style="text-align:center; margin-bottom:0; line-height:1.1"><a class="tittle-partes" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></p>
                            <?php if ($product['thumb']) { ?>
                                <img style="margin:5px 0 0 49px" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" width="104" height="78">
                            <?php } ?>    
                        <p style="text-align:center; margin-bottom:0"><a class="tittle-partes" href="<?php echo $product['href_category']; ?>"><?php echo $product['category']; ?></a></p>
                        </div>
                    </div>
                </div>
                <span class="botton-cpartes"></span> 
        </div>
    <?php $count++; ?>
    <?php } ?>				
</div>
