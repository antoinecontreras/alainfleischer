<?php namespace ProcessWire;

// Template file for “home” template used by the homepage
// ------------------------------------------------------
// The #content div in this file will replace the #content div in _main.php
// when the Markup Regions feature is enabled, as it is by default. 
// You can also append to (or prepend to) the #content div, and much more. 
// See the Markup Regions documentation:
// https://processwire.com/docs/front-end/output/markup-regions/
$projects = $pages->find("template=project");
$projectsByCategory = [];
foreach ($projects as $project) {
	if ($project->img) {
		$categoryTitle = $project->filter->title;
		if (!isset($projectsByCategory[$categoryTitle])) {
			$projectsByCategory[$categoryTitle] = [];
		}
		$projectsByCategory[$categoryTitle][] = $project;
	}
}
?>

<div id="content" class="container">
	<div class="page_row collection_nav">
		<?php foreach ($projectsByCategory as $categoryTitle => $projects) : ?>
				<?php foreach ($projects as $project) : ?>
					<div class="nav_item" id="<?= $project->name; ?>">
					<div class="nav_wallpaper">	
						<img class="" draggable="false" src="<?php echo $project->img->url; ?>" />
					</div>	
					<?php if ($project->gallery) : ?>
						<div class="nav_gallery">
								<?php foreach ($project->gallery as $gallery) : ?>
									<img draggable="false" width="300" src="<?php echo $gallery->url; ?>" />
								<?php endforeach; ?>
							<?php endif; ?>
					</div>	
				</div>
				<?php endforeach; ?>			
		<?php endforeach; ?>
	</div>




	<div class="page_row collection_tab">
		<div class="collection_filter">
		<?php
			$counter = 0;
foreach ($projectsByCategory as $categoryTitle => $projects) : 
    $filters = [];
    foreach ($projects as $project) :
        $filterTitle = $project->filter->title;

        if (!isset($filters[$filterTitle])) :
            $filters[$filterTitle] = $filterTitle; ?>
            <a href="#<?= $filterTitle; ?>" class="<?= $counter === 0 ? 'active' : '' ?>"><?= $filterTitle ?></a>
            <?php endif; 
	$counter++;
	endforeach; 
endforeach;
?>



		</div>
		<?php 	$counter = 0;
		foreach ($projectsByCategory as $categoryTitle => $projects) :?>
    			<div id="<?=$categoryTitle; ?>" class="collection_category <?= $counter === 0 ? 'active' : '' ?>">
			  

        			<?php foreach ($projects as $project) : ?>
            		<a draggable="false" id="<?=$project->title; ?>" class="collection_item ">
                		<p><?php echo $project->filter->title; ?></p>
                		<img draggable="false" src="<?php echo $project->img->url; ?>" />
               				 <p><?=$project->title; ?></p>
               				 <p><?=$project->date . ' - ' . $project->date_end; ?></p>
               				 <p><?=$project->textarea; ?></p>
					</a>
	        <?php $counter++;
			 endforeach; ?>
	    </div> 
	<?php endforeach; ?>
	</div>
</div>	