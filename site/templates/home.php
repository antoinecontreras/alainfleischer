<?php

namespace ProcessWire;


// ------------------------------------------------------
// The #content div in this file will replace the #content div in _main.php
// when the Markup Regions feature is enabled, as it is by default. 
// You can also append to (or prepend to) the #content div, and much more. 
// See the Markup Regions documentation:
// https://processwire.com/docs/front-end/output/markup-regions/
$projects = $pages->find("template=project");

$projectsByCategory = [];
foreach ($projects as $project) {

	$categoryTitle = $project->filter->title;
	if (!isset($projectsByCategory[$categoryTitle])) {
		$projectsByCategory[$categoryTitle] = [];
	}
	$projectsByCategory[$categoryTitle][] = $project;
}
?>
<div id="content" class="container home">
	<div class="page_row collection_nav">
		<?php foreach ($projectsByCategory as $categoryTitle => $projects) : ?>
			<?php foreach ($projects as $project) : ?>
				<div class="nav_item" id="<?= urlencode($project->title); ?>">
					<?php if ($project->img) :
					?>
						<div class="nav_wallpaper">
							<img class="" draggable="false" src="<?= $project->img->url ?>" />
						</div>
					<?php endif; ?>
					<div class="nav_content">
						<div class="nav_cartel">
							<?= html_entity_decode($project->textarea); ?>
							<p><?= $project->date . ' - ' . $project->date_end; ?></p>
						</div>

						<?php if ($project->gallery) : ?>
							<div class="nav_gallery" onclick="simulateClick()">
								<?php

								foreach ($project->gallery as $image) : ?>
									<!-- <div class="nav_image"> -->
									<?php
									$isLandscape = $image->width > $image->height;
									$class = $isLandscape ? 'landscape' : '';

									?>
									<img class="nav_image <?= $class ?>" draggable="false" width="<?= $image->width; ?>" src="<?php echo $image->url; ?>" />
									<!-- </div> -->
								<?php endforeach; ?>

							<?php endif; ?>
							</div>
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
						<a draggable="false" href="#<?= urlencode($filterTitle); ?>" class="filter-link" onclick="highlightLink('<?= $filterTitle; ?>')"><?= $filterTitle ?></a>
			<?php endif;
				endforeach;
			endforeach; ?>
		</div>

		<!-- Section des projets -->
		<?php foreach ($projectsByCategory as $categoryTitle => $projects) : ?>
			<div id="<?= urlencode($categoryTitle); ?>" class="collection_category">
				<?php
				$projectsByYear = [];
				foreach ($projects as $project) :
					$year = date('Y', strtotime($project->date));
					$projectsByYear[$year][] = $project;
				endforeach;
				foreach ($projectsByYear as $year => $projects) :
					echo "<p class='collection_year'>{$year}</p>"; ?>
					<div class='collection_items'>
						<?php foreach ($projects as $project) :

							$filterRef =  urlencode($project->filter->title);
							$projectRef =  urlencode($project->title);
							$parentRef =  urlencode($project->parent->title);
						?>
							<a
								data-filter="<?= $filterRef ?>"
								data-project="<?= $projectRef ?>"
								data-parent="<?= $parentRef ?>"
								id="<?= urlencode($project->title); ?>" draggable="false" class="collection_item interactive_item <?= $project->img ? 'with_img' : ''; ?>">
								<?php if ($project->img) :
									$img = $project->img;
									$focusX = $img->focus["left"];
									$focusY = $img->focus["top"];
								?>
									<img draggable="false" src="<?= $img->url; ?>"
										alt="<?= $project->title; ?>"
										style=" 
									transform-origin: <?= $focusX; ?>% <?= $focusY; ?>%;" />
								<?php elseif ($project->img == null) : ?>
									<p><?= $project->title; ?></p>
									<div>
										<!-- <img src="<? $config->urls->templates ?>picto/link.svg" alt="" /> -->
										<?php if ($project->text): ?>
											<p class='collection_localite'> <?= $project->text ?></p>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</a>



						<?php endforeach; ?>
					</div>
				<?php endforeach;
				?>
			</div> <!-- Fin de la catégorie -->
		<?php endforeach; ?>
	</div>


</div>