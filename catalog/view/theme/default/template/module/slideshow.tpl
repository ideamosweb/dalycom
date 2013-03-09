<div class="clear"></div>
<div class="slider">
    <div id="slider">
        <ul>
            <?php foreach ($banners as $banner) { ?>
            <?php if ($banner['link']) { ?>
            <li><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" /></a></li>
            <?php } else { ?>
            <li><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" /></li>
            <?php } ?>
            <?php } ?>            
        </ul>
    </div>
</div>