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
                <div class="nav_item news " id="<?= urlencode($date) ?>">
                    <div class="nav_news">
                        <?php
                        $cartel = $new->textarea;
                        if (!empty($cartel)) : ?>
                            <div class="nav_cartel"><?=html_entity_decode($cartel); ?></div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h2 class='nav_cartel'> <?= $date ?></h2>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <div class="page_row collection_tab news interactive_items">
        <?php
        $currentMonthYear = ''; // Variable pour stocker le mois et l'année courants

        // Boucle sur les dates triées
        foreach ($newsByDate as $date => $newsItems) {
            $dateFromObj = new \DateTime($date);
            $monthYear = $dateFromObj->format('F Y');

            if ($currentMonthYear !== $monthYear) {
                $currentMonthYear = $monthYear;
                echo "<p class='news_date'>$currentMonthYear</p>"; // Affichez le mois et l'année
            }

            foreach ($newsItems as $new) {
                $title = $new->title;
                if (!empty($title)):
                    $place = $new->place;
                    $dateFrom = $new->date; // Date de début
                    $dateTo = $new->date_end; // Date de fin
                    $dateToObj = new \DateTime($dateTo);
                    $informations = $new->textarea;
                    $more_description = $new->more_description;
                    $link = $new->link; ?>
                    <div class="news_item interactive_item" id="<?= urlencode($dateFrom) ?>">
                        <?php if (!empty($link)): ?>
                            <a target='_blank' draggable='false' href='<?= $link ?>' class="new_link">
                                <p class='news_title'><?= $title ?></p>
                                <img src="<?= $config->urls->templates ?>picto/back.svg" alt="" />
                            </a>
                        <?php else: ?>
                            <p class='news_title'><?= $title ?></p>
                        <?php
                        endif; ?>

                        <div class="news_description">
                            <?php
                            if (!empty($informations)) {
                                "<p>" . $informations . "</p>";
                            }

                            if (!empty($more_description)) {

                                $cleanHTML = html_entity_decode($more_description);
                                echo  $cleanHTML;
                            }

                            if (!empty($place)) {
                                echo "<p>$place</p>";
                            }
                            if (!empty($dateFrom)) {
                                echo "<p class='new_date'>" . $dateFromObj->format('F j, Y') . " " . (!empty($dateTo) ? "- " . $dateToObj->format('F j, Y') : '') . "</p>";
                            }



                            ?>
                        </div>
                        <?php if (!empty($cartel)) {
                            echo   "<div class='nav_cartelMobile'>" . html_entity_decode($cartel) . "</div>";;
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