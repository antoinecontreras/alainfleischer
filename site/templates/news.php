<?php

namespace ProcessWire;

$purifier = $modules->get('MarkupHTMLPurifier');

// Définir les balises et attributs que vous voulez autoriser
$purifier->set('HTML.Allowed', 'p,a[href],strong,em');

// Purifier votre contenu

$news = $pages->find("template=new");
$newsByDate = [];

// Parcours des actualités pour les trier par date
foreach ($news as $new) {
    // Récupération de la date
    $date = $new->date; // Assurez-vous que cela retourne une chaîne de date valide

    // Ajoute la page à la date correspondante dans le tableau
    if (!isset($newsByDate[$date])) {
        $newsByDate[$date] = [];
    }
    $newsByDate[$date][] = $new;
}

uksort($newsByDate, function ($a, $b) {
    return strtotime($b) <=> strtotime($a); // Inverser l'ordre ici
});
?>

<div id="content" class="container">
    <div class="page_row collection_nav">
        <?php foreach ($newsByDate as $date => $newsItems) :
            foreach ($newsItems as $new): ?>
                <div class="nav_item" id="<?= urlencode($date) ?>">
                    <?php
                        $cartel = $new->textarea;
                    if (!empty($cartel)) : ?>
                        <h2 class='nav_cartel'> <?= $date ?></h2>
                        <h2 class="nav_cartel"><?= $cartel; ?></h2>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <div class="page_row collection_tab news interactive_items">
        <?php
        $currentMonthYear = ''; // Variable pour stocker le mois et l'année courants

        // Boucle sur les dates triées
        foreach ($newsByDate as $date => $newsItems) {
            // Créer un objet DateTime pour formater la date
            $dateFromObj = new \DateTime($date);
            $monthYear = $dateFromObj->format('F Y'); // Récupérer le mois et l'année au format 'Month Year'

            // Afficher le mois et l'année
            if ($currentMonthYear !== $monthYear) {
                $currentMonthYear = $monthYear;
                echo "<p class='news_date'>$currentMonthYear</p>"; // Affichez le mois et l'année
            }

            foreach ($newsItems as $new) {
                $title = $new->title;
                if (!empty($title)) :
                    $place = $new->place;
                    $dateFrom = $new->date; // Date de début
                    $dateTo = $new->date_end; // Date de fin
                    $dateToObj = new \DateTime($dateTo); ?>
                    <div class="news_item interactive_item" id="<?= urlencode($dateFrom) ?>">
                        <?php
                        $informations = $new->textarea;
                        $more_description = $new->more_description;
                        $link = $new->link;

                        echo "<p class='news_title'>$title</p>";
                        if (!empty($place)) {
                            echo "<p><strong>Adresse : </strong>$place</p>";
                        }
                        if (!empty($dateFrom)) {
                            echo "<p><strong>Date : </strong>" . $dateFromObj->format('F j, Y') . " " . (!empty($dateTo) ? "- " . $dateToObj->format('F j, Y') : '') . "</p>";
                        }
                        if (!empty($informations)) {
                            "<p><strong>Informations : </strong>$informations</p>";
                        }
                        if (!empty($more_description)) {

                            $cleanHTML = html_entity_decode($more_description);
                            echo "<p><strong>Informations supplémentaires : </strong></p>" . $cleanHTML;
                        }

                        if (!empty($link)) {
                            echo "<a draggable='false' target='_blank' href='$link'>$link</a>";
                        }
                        ?>
                    </div>
        <?php
                endif;
            }
        }
        ?>
    </div>
</div>