<div class="ipPluginSimpleSlideshowImages" data-options='<?php echo json_encode($options); ?>' style="width: <?php echo (int)$width; ?>px; height:<?php echo (int)$height; ?>px;">
    <?php foreach ($images as $imageKey => $image) { ?>
        <div><img alt="<?php echo $this->esc($image['title']) ?>" src="<?php echo BASE_URL.IMAGE_DIR.$this->esc($image['image']) ?>" /></div>
    <?php } ?>
</div>
<div class="ipPluginSimpleSlideshowTabs">

</div>
