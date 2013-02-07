//This is how I used this in my theme. I put it here for reference.
//Also, edit dimensions in items_area.php (lines 52-53) to fit your slideshow script
<?php
      require_once (BASE_DIR.PLUGIN_DIR.'slideshow/slideshow/db.php');
      $ss = new Modules\slideshow\slideshow\Db();
      $slideshow=$ss->getSlides();
      foreach ($slideshow as $slide)
{
    echo '<div class="some-class">
    <span class="slider-frame"></span>
    <img src="'.BASE_URL.IMAGE_DIR.$slide['photo'].'" alt="" width="920px" height="320px" />
    <div class="slide-text">
	<h1>'.$slide['name'].'</h1>
	<p>'.$slide['description'].'</p>
	</div>
    </div>';
}
?>
