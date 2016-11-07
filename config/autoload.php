<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'CLICKPRESS',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Models
	'CLICKPRESS\NewsPodcastsModel'     => 'system/modules/news_podcasts/models/NewsPodcastsModel.php',
	'CLICKPRESS\NewsPodcastsFeedModel' => 'system/modules/news_podcasts/models/NewsPodcastsFeedModel.php',

	// Classes
	'CLICKPRESS\NewsPodcasts'          => 'system/modules/news_podcasts/classes/NewsPodcasts.php',
	'CLICKPRESS\iTunesFeed'            => 'system/modules/news_podcasts/classes/iTunesFeed.php',
	'CLICKPRESS\GetMp3Duration'        => 'system/modules/news_podcasts/classes/GetMp3Duration.php',
));
