<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package   news_podcasts
 * @author    Stefan Schulz-Lauterbach
 * @license   GNU/LGPL
 * @copyright CLICKPRESS Internetagentur 2015,2016
 */

$GLOBALS['TL_DCA']['tl_news']['config']['onload_callback'][]              = array('tl_news_podcast', 'generatePodcastFeed');
$GLOBALS['TL_DCA']['tl_news']['config']['oncut_callback'][]               = array(
    'tl_news_podcast',
    'schedulePodcastUpdate',
);
$GLOBALS['TL_DCA']['tl_news']['config']['ondelete_callback'][]            = array(
    'tl_news_podcast',
    'schedulePodcastUpdate',
);
$GLOBALS['TL_DCA']['tl_news']['config']['onsubmit_callback'][]            = array(
    'tl_news_podcast',
    'schedulePodcastUpdate',
);
$GLOBALS['TL_DCA']['tl_news']['list']['sorting']['child_record_callback'] = array(
    'tl_news_podcast',
    'listNewsPodcastArticles',
);
$GLOBALS['TL_DCA']['tl_news']['palettes']['default']                      = str_replace(
    'source;',
    'source;{podcast_legend},addPodcast;',
    $GLOBALS['TL_DCA']['tl_news']['palettes']['default']
);
$GLOBALS['TL_DCA']['tl_news']['palettes']['__selector__'][]               = 'addPodcast';
$GLOBALS['TL_DCA']['tl_news']['subpalettes']['addPodcast']                = 'podcast,explicit';

$GLOBALS['TL_DCA']['tl_news']['fields']['addPodcast'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_news']['addPodcast'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => array('submitOnChange' => true),
    'sql'       => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_news']['fields']['podcast'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_news']['podcast'],
    'exclude'   => true,
    'inputType' => 'fileTree',
    'eval'      => array('filesOnly' => true, 'extensions' => 'mp3', 'fieldType' => 'radio', 'mandatory' => true),
    'sql'       => "binary(16) NULL",
);

$GLOBALS['TL_DCA']['tl_news']['fields']['explicit'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_news']['explicit'],
    'exclude'   => true,
    'filter'    => true,
    'inputType' => 'select',
    'options'   => array('no', 'clean', 'yes'),
    'default'   => 'no',
    'eval'      => array('chosen' => true, 'includeBlankOption' => true),
    'sql'       => "varchar(255) NOT NULL default ''",
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer, Stefan Schulz-Lauterbach
 */
class tl_news_podcast extends tl_news
{

    /**
     * Check for modified news feeds and update the XML files if necessary
     */
    public function generatePodcastFeed()
    {
        $session = $this->Session->get('podcast_feed_updater');

        if (!is_array($session) || empty($session)) {
            return;
        }

        $this->import('NewsPodcasts');

        foreach ($session as $id) {
            $this->NewsPodcasts->generateFeedsByArchive($id);
        }

        $this->Session->set('podcast_feed_updater', null);
    }


    /**
     * Schedule a news feed update
     *
     * This method is triggered when a single news item or multiple news
     * items are modified (edit/editAll), moved (cut/cutAll) or deleted
     * (delete/deleteAll). Since duplicated items are unpublished by default,
     * it is not necessary to schedule updates on copyAll as well.
     *
     * @param \DataContainer
     */
    public function schedulePodcastUpdate(DataContainer $dc)
    {
        // Return if there is no ID
        if (!$dc->activeRecord || !$dc->activeRecord->pid || Input::get('act') == 'copy') {
            return;
        }

        // Store the ID in the session
        $session   = $this->Session->get('podcast_feed_updater');
        $session[] = $dc->activeRecord->pid;
        $this->Session->set('podcast_feed_updater', array_unique($session));
    }


    /**
     * Add the type of input
     *
     * @param array $arrRow
     *
     * @return string
     */
    public function listNewsPodcastArticles($arrRow)
    {
        $arrRow['headline'] = ($arrRow['addPodcast'] == 1) ? $arrRow['headline'].' <img src="system/modules/news_podcasts/assets/icon_mic.svg" width="16" height="16" alt="Podcast">' : $arrRow['headline'];

        return parent::listNewsArticles($arrRow);
    }

}