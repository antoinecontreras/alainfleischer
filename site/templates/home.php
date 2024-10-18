<?php namespace ProcessWire;

// Template file for “home” template used by the homepage
// ------------------------------------------------------
// The #content div in this file will replace the #content div in _main.php
// when the Markup Regions feature is enabled, as it is by default. 
// You can also append to (or prepend to) the #content div, and much more. 
// See the Markup Regions documentation:
// https://processwire.com/docs/front-end/output/markup-regions/
$projects = $page->projects;
?>

<div id="content" class="container">
	<div class="row"></div>
	<div class="row collection_grid">
		<div>
			<?php  foreach ($projects as $project => $value) :
				if ($value->img) :?>
	
					<p><?php echo $value->filter->title?></p>
		
					<img src="<?php echo $value->img->url?>" />
					<p><?php echo $value->title?></p>
					<p><?php echo $value->date .  " - " . $value->date_end?></p>
					<p><?php echo $value->textarea?></p>
					<?php if ($value->gallery) :
						foreach ($value->gallery as $gallery) :?>
							<img width="300" src="<?php  $gallery->url?>" 	/>	
						<?php endforeach;
			 		endif; ?>
		
				<?php endif; 
			endforeach; ?>
		</div>
	</div>
</div>	