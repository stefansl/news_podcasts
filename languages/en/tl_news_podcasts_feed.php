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

$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['title']              = array( 'Title', 'Please enter a feed title.' );
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['alias']              = array(
    'Feed alias',
    'Here you can enter a unique filename (without extension). The XML feed file will be auto-generated in the &lt;em&gt;share&lt;/em&gt; directory of your Contao installation, e.g. as &lt;em&gt;share/name.xml&lt;/em&gt;.'
);
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['language']           = array(
    'Feed language',
    'Please enter the feed language according to the ISO-639 standard (e.g. &lt;em&gt;en&lt;/em&gt; or &lt;em&gt;en-us&lt;/em&gt;).'
);
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['subtitle']           = array(
    'Subtitle',
    'Will be displayed in the description column in iTunes. For best results, choose a subtitle that is only a few words long.'
);
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['summary']            = array(
    'Summary',
    'This shown on the iTunes Store page for your podcast. The information also appears in a separate window if the information (“i”) icon in the Description column is clicked. This field can be up to 4000 characters.'
);
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['category']           = array(
    'Category',
    'Users can browse podcast subject categories on iTunes. check https://www.apple.com/itunes/podcasts/specs.html#categories'
);
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['owner']              = array(
    'Owner',
    'This tag contains contact information for the owner of the podcast intended to be used for administrative communication about the podcast. This information is not displayed on the iTunes Store.'
);
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['email']              = array( 'E-mail', 'The owner\'s email address' );
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['image']              = array(
    'Image for iTunes',
    'Points to the artwork for your podcast. Cover art must be in the JPEG or PNG file formats and in the RGB color space with a minimum size of 1400 x 1400 pixels and a maximum size of 3000 x 3000 pixels. Note that these requirements are different from the standard RSS image tag specification.'
);
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['author']             = array(
    'Author',
    'The content of this tag is shown in the Artist column in iTunes.'
);
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['copyright']          = array( 'Copyright', 'The podcasts copyright' );
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['archives']           = array(
    'News archives',
    'Here you can choose the news archives to be included in the feed.'
);
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['maxItems']           = array(
    'Maximum number of items',
    'Here you can limit the number of feed items. Set to 0 to export all.'
);
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['feedBase']           = array(
    'Base URL',
    'Please enter the base URL with protocol (e.g. &lt;em&gt;http://&lt;/em&gt;).'
);
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['description']        = array(
    'Feed description',
    'Enter a short description of the iTunes feed.'
);
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['new']                = array( 'New podcast feed', 'Create a new feed' );
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['show']               = array(
    'Feed details',
    'Show the details of feed ID %s'
);
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['edit']               = array( 'Edit feed', 'Edit feed ID %s' );
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['copy']               = array( 'Duplicate feed', 'Duplicate feed ID %s' );
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['delete']             = array( 'Delete feed', 'Delete feed ID %s' );
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['title_legend']       = 'Title and language';
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['archives_legend']    = 'News archives';
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['config_legend']      = 'Feed settings';
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['source_teaser']      = 'News teasers';
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['author_legend']      = 'Author';
$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['description_legend'] = 'Description';
