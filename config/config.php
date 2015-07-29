<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   news_podcasts
 * @author    Stefan Schulz-Lauterbach
 * @license   GNU/LGPL
 * @copyright CLICKPRESS Internetagentur 2015
 */


$GLOBALS['BE_MOD']['content']['news']['tables'][] = 'tl_news_podcasts_feed';

/**
 * Cron jobs
 */
$GLOBALS['TL_CRON']['daily'][] = array( 'NewsPodcasts', 'generateFeeds' );

/**
 * Register hook to add news items to the indexer
 */
$GLOBALS['TL_HOOKS']['generateXmlFiles'][] = array( 'NewsPodcasts', 'generateFeeds' );

/**
 * Add permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'newspodcastsfeeds';
$GLOBALS['TL_PERMISSIONS'][] = 'newspodcastsfeedp';