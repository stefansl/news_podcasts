<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package   news_podcasts
 * @author    Stefan Schulz-Lauterbach
 * @license   GNU/LGPL
 * @copyright CLICKPRESS Internetagentur 2015
 */


$GLOBALS['TL_DCA']['tl_news']['palettes']['default']        = str_replace( 'source;', 'source;{podcast_legend},addPodcast;',
    $GLOBALS['TL_DCA']['tl_news']['palettes']['default'] );
$GLOBALS['TL_DCA']['tl_news']['palettes']['__selector__'][] = 'addPodcast';
$GLOBALS['TL_DCA']['tl_news']['subpalettes']['addPodcast']  = 'podcast';

$GLOBALS['TL_DCA']['tl_news']['fields']['addPodcast'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_news']['addPodcast'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => array( 'submitOnChange' => true ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_news']['fields']['podcast'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_news']['podcast'],
    'exclude'   => true,
    'inputType' => 'fileTree',
    'eval'      => array( 'filesOnly' => true, 'extensions' => 'mp3', 'fieldType' => 'radio', 'mandatory' => true ),
    'sql'       => "binary(16) NULL"
);
