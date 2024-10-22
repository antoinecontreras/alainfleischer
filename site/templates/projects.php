<?php

namespace ProcessWire;

$valeur = null;
if (isset($_GET['valeur'])) {
    $valeur = $_GET['valeur']; // Récupère la valeur passée dans l'URL
} else {
    echo "Aucune valeur passée dans l'URL.";
}
$project = $pages->findOne("template=project, name=$valeur");

?>




<div id="content" class="container">

    <div class="projectMobile_tab" id="<?= $project->title; ?>">
        <?php if ($project->img) :
        ?>
            <div class="thumbnail">
                <img class="" draggable="false" src="<?= $project->img->url ?>" />
            </div>
        <?php endif; ?>
        <div class="cartel">
            <h2 class="nav_cartel"><?= $project->textarea; ?></h2>
            <p><?= $project->date . ' - ' . $project->date_end; ?></p>
        </div>
        <?php if ($project->gallery) : ?>
            <div class="gallery">
                <?php

                foreach ($project->gallery as $image) : ?>
                    <img draggable="false" width="300" src="<?php echo $image->url; ?>" />
                <?php endforeach; ?>

            <?php endif; ?>
            </div>
    </div>
</div>