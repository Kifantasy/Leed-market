<?php
/*
@name Reading Time
@author Qwerty <qwerty@legtux.org>
@link http://etudiant-libre.fr.nf
@licence Tea Licence
@version 1.0.1
@description Estime le temps de lecture d'un article
*/

function readingtime(&$event) {
    $configurationManager = new Configuration();
    $conf = $configurationManager->getAll();

    $filtered_content = ($configurationManager->get('articleDisplayMode') == 'summary') ? $event->getDescription() : $event->getContent();

    if( $filtered_content ) {
        $readingtime =null;
        $word = str_word_count(strip_tags($filtered_content));
        $minutes_estimate = floor($word / 200);
        $seconds_estimate = floor($word / (200 / 60));
        $hours = intval($seconds_estimate / 3600);
        $minutes=intval(($seconds_estimate % 3600) / 60);
        $secondes=intval((($seconds_estimate % 3600) % 60));
        if($hours>=1) { $readingtime .= $hours.'h ';}
        if($minutes>=1) { $readingtime .= $minutes.'min ';}
        if($minutes<1 && $hours == 0) { $readingtime .= $secondes.'s ';}
        echo _t('READING_TIME').' '.$readingtime;
    }
}

Plugin::addHook("event_pre_top_options", "readingtime");  
?>
