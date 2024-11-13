<?php

namespace ProcessWire;

$bio = $pages->findOne("template=bio");
$fields = [];
foreach ($bio->fields_array as $repeaterItem) {
	$fields[$repeaterItem->text] = $repeaterItem->text;
}

foreach ($bio->fields_array as $repeaterItem) {
	$counter = count($repeaterItem->array_text);
	$counterNormalise = 0;
	for ($i = 0; $i < $counter; $i++) {
		if ($i % 2 == 0)
			$counterNormalise++;
	}
	$itemsCounter[$repeaterItem->text] = $counterNormalise;
}
$maxValue = max($itemsCounter);


?>
<div id="content" class="container home">
	<div class="page_row collection_nav">
		<div class="nav_wallpaper">
			<img class="" draggable="false" src="<?= $bio->img->url ?>" />
		</div>
	</div>
	<div class="page_row collection_tab bio">
		<div class="bio_text">
			<p><?= $bio->text ?></p>
			<?= html_entity_decode($bio->textarea) ?>
		</div>

		<div class="bio_prices">
			<div class="bio_fields">
				<?php
				foreach ($fields as $field) : ?>
					<a href="#<?= $field ?>" class="bio-link"><?= $field ?></a>
				<?php endforeach; ?>
			</div>
			<div class="bio_repeater">

				<?php
				foreach ($bio->fields_array as $repeaterItem) :
					$counter = count($repeaterItem->array_text);
					$itemsCounter[$repeaterItem->text] = $counter;

				?>
					<div class="bio_repeater_item" id="<?= $repeaterItem->text; ?>">
						<?php foreach ($repeaterItem->array_text as $content) : ?>
							<div>
								<p><?= $content->text2 ?></p>
								<p><?= $content->text3 ?></p>
								<p><?= $content->text ?></p>
								<p><?php
									$date = \DateTime::createFromFormat("M j, Y", $content->date);
									$formattedDate = $date->format("M Y");

									echo $formattedDate ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
</div>