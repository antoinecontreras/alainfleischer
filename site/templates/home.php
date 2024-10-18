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
					<div id="<?= $projects->title; ?>">
						<img draggable="false" src="<?php echo $project->img->url; ?>" />
							<?php if ($project->gallery) : ?>
								<?php foreach ($project->gallery as $gallery) : ?>
									<img draggable="false" width="300" src="<?php echo $gallery->url; ?>" />
								<?php endforeach; ?>
							<?php endif; ?>
					</div>
				<?php endforeach; ?>			
		<?php endforeach; ?>
	</div>




	<div class="page_row collection_tab">
		<div class="collection_filter">
			<?php
			$filters= [];
		foreach ($projects as $project) :
			$categoryTitle = $project->filter->title;
				if (!isset($filters[$categoryTitle])) :
					$filters[$categoryTitle] = $categoryTitle ;?>
					
					<p><?= $categoryTitle ?></p>
				
				<?php endif?>
		<?php endforeach?>
		</div>
		
		
			<?php

				foreach ($projectsByCategory as $categoryTitle => $projects) : ?>
    			<div class="collection_category">
			        <!-- <h2><?php $categoryTitle; ?></h2> -->

        			<?php foreach ($projects as $project) : ?>
            		<a draggable="false" id="<?=$project->title; ?>" class="collection_item">
                		<p><?php echo $project->filter->title; ?></p>
                		<img draggable="false" src="<?php echo $project->img->url; ?>" />
               				 <p><?=$project->title; ?></p>
               				 <p><?=$project->date . ' - ' . $project->date_end; ?></p>
               				 <p><?=$project->textarea; ?></p>
							
		                <?php if ($project->gallery) : ?>
                 		   <?php foreach ($project->gallery as $gallery) : ?>
	                        <img draggable="false" width="300" src="<?php echo $gallery->url; ?>" />
	    	            <?php endforeach; ?>
	                <?php endif; ?>
					</a> <!-- Fin de la div projet -->
	        <?php endforeach; ?>
	    </div> <!-- Fin de la div catégorie -->
	<?php endforeach; ?>
		
	</div>
</div>	