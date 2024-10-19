<?php namespace ProcessWire;

if(!defined("PROCESSWIRE")) die();

/** @var ProcessWire $wire */
$wire->addHookAfter('ProcessPageEdit::buildForm', function($event) {
    $form = $event->return; // Le formulaire d'édition de page
    $page = $event->object->getPage(); // La page actuelle, ici un projet

    // Vérifier si on est en train d'éditer une page de type 'project'
    if ($page->template->name === 'project') {
        $filter = $page->filter;
        if ($filter && !$filter->illustration) {
            bd($filter->illustration);
            $imgField = $form->get('img');
            if ($imgField) {
                $imgField->collapsed = Inputfield::collapsedHidden; // Cache le champ 'gallery'
            }
            $galleryField = $form->get('gallery');
            if ($galleryField) {
                $galleryField->collapsed = Inputfield::collapsedHidden; // Cache le champ 'gallery'
            }
        }
    }
});

