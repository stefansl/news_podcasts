<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Table tl_news_podcasts_feed
 */
$GLOBALS['TL_DCA']['tl_news_podcasts_feed'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'onload_callback' => array
        (
            array('tl_news_podcasts_feed', 'checkPermission'),
            array('tl_news_podcasts_feed', 'generateFeed')
        ),
        'onsubmit_callback' => array
        (
            array('tl_news_podcasts_feed', 'scheduleUpdate')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'alias' => 'index'
            )
        ),
        'backlink'                    => 'do=news'
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'fields'                  => array('title'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;search,limit'
        ),
        'label' => array
        (
            'fields'                  => array('title'),
            'format'                  => '%s'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            ),
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        'default'                     => '{title_legend},title,alias,language;{description_legend},description,category;{author_legend},owner,email,image,author,copyright;{archives_legend},archives;{config_legend},maxItems,feedBase'
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['title'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'alias' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['alias'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'rgxp'=>'alias', 'unique'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
            'save_callback' => array
            (
                array('tl_news_podcasts_feed', 'checkFeedAlias')
            ),
            'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
        ),
        'language' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['language'],
            'exclude'                 => true,
            'search'                  => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>32, 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'subtitle' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['subtitle'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'long'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'summary' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['summary'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'textarea',
            'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),
        'description' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['description'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'textarea',
            'eval'                    => array('style'=>'height:60px', 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),
        'category' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['category'],

            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_news_podcasts_feed', 'getItunesCategories'),
            'eval'                    => array('chosen'=>true, 'mandatory'=>true),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'owner' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['owner'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'email' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['email'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'rgxp'=>'email', 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'author' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['author'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'image' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['image'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>'jpg,png', 'mandatory'=>true),
            'sql'                     => "blob NULL"
        ),

        'archives' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['archives'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'checkbox',
            'options_callback'        => array('tl_news_podcasts_feed', 'getAllowedArchives'),
            'eval'                    => array('multiple'=>true, 'mandatory'=>true),
            'sql'                     => "blob NULL"
        ),
        'maxItems' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['maxItems'],
            'default'                 => 25,
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'rgxp'=>'natural', 'tl_class'=>'w50'),
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'"
        ),
        'feedBase' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_news_podcasts_feed']['feedBase'],
            'default'                 => Environment::get('base'),
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('trailingSlash'=>true, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        )
    )
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_news_podcasts_feed extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }


    /**
     * Check permissions to edit table tl_itunes_archive
     */
    public function checkPermission()
    {
        if ($this->User->isAdmin)
        {
            return;
        }

        // Set the root IDs
        if (!is_array($this->User->newspodcastsfeeds) || empty($this->User->newspodcastsfeeds))
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->newspodcastsfeeds;
        }

        $GLOBALS['TL_DCA']['tl_news_podcasts_feed']['list']['sorting']['root'] = $root;

        // Check permissions to add feeds
        if (!$this->User->hasAccess('create', 'newspodcastsfeedp'))
        {
            $GLOBALS['TL_DCA']['tl_news_podcasts_feed']['config']['closed'] = true;
        }

        // Check current action
        switch (Input::get('act'))
        {
            case 'create':
            case 'select':
                // Allow
                break;

            case 'edit':
                // Dynamically add the record to the user profile
                if (!in_array(Input::get('id'), $root))
                {
                    $arrNew = $this->Session->get('new_records');

                    if (is_array($arrNew['tl_news_podcasts_feed']) && in_array(Input::get('id'), $arrNew['tl_news_podcasts_feed']))
                    {
                        // Add permissions on user level
                        if ($this->User->inherit == 'custom' || !$this->User->groups[0])
                        {
                            $objUser = $this->Database->prepare("SELECT newspodcastsfeeds, newspodcastsfeedp FROM tl_user WHERE id=?")
                                ->limit(1)
                                ->execute($this->User->id);

                            $arrnewspodcastsfeedp = deserialize($objUser->newspodcastsfeedp);

                            if (is_array($arrnewspodcastsfeedp) && in_array('create', $arrnewspodcastsfeedp))
                            {
                                $arrnewspodcastsfeeds = deserialize($objUser->newspodcastsfeeds);
                                $arrnewspodcastsfeeds[] = Input::get('id');

                                $this->Database->prepare("UPDATE tl_user SET newspodcastsfeeds=? WHERE id=?")
                                    ->execute(serialize($arrnewspodcastsfeeds), $this->User->id);
                            }
                        }

                        // Add permissions on group level
                        elseif ($this->User->groups[0] > 0)
                        {
                            $objGroup = $this->Database->prepare("SELECT newspodcastsfeeds, newspodcastsfeedp FROM tl_user_group WHERE id=?")
                                ->limit(1)
                                ->execute($this->User->groups[0]);

                            $arrnewspodcastsfeedp = deserialize($objGroup->newspodcastsfeedp);

                            if (is_array($arrnewspodcastsfeedp) && in_array('create', $arrnewspodcastsfeedp))
                            {
                                $arrnewspodcastsfeeds = deserialize($objGroup->newspodcastsfeeds);
                                $arrnewspodcastsfeeds[] = Input::get('id');

                                $this->Database->prepare("UPDATE tl_user_group SET newspodcastsfeeds=? WHERE id=?")
                                    ->execute(serialize($arrnewspodcastsfeeds), $this->User->groups[0]);
                            }
                        }

                        // Add new element to the user object
                        $root[] = Input::get('id');
                        $this->User->newspodcastsfeeds = $root;
                    }
                }
            // No break;

            case 'copy':
            case 'delete':
            case 'show':
                if (!in_array(Input::get('id'), $root) || (Input::get('act') == 'delete' && !$this->User->hasAccess('delete', 'newspodcastsfeedp')))
                {
                    $this->log('Not enough permissions to '.Input::get('act').' podcast feed ID "'.Input::get('id').'"', __METHOD__, TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                break;

            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
                $session = $this->Session->getData();
                if (Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'newspodcastsfeedp'))
                {
                    $session['CURRENT']['IDS'] = array();
                }
                else
                {
                    $session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $root);
                }
                $this->Session->setData($session);
                break;

            default:
                if (strlen(Input::get('act')))
                {
                    $this->log('Not enough permissions to '.Input::get('act').' podcast feeds', __METHOD__, TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                break;
        }
    }


    /**
     * Check for modified itunes feeds and update the XML files if necessary
     */
    public function generateFeed()
    {
        $session = $this->Session->get('podcasts_feed_updater');

        if (!is_array($session) || empty($session))
        {
            return;
        }

        $feed = new NewsPodcasts();

        foreach ($session as $id)
        {
            $feed->generateFeeds($id);
        }



        $this->Session->set('podcasts_feed_updater', null);
    }


    /**
     * Schedule a itunes feed update
     *
     * This method is triggered when a single itunes archive or multiple itunes
     * archives are modified (edit/editAll).
     * @param \DataContainer
     */
    public function scheduleUpdate(DataContainer $dc)
    {
        // Return if there is no ID
        if (!$dc->id)
        {
            return;
        }

        // Store the ID in the session
        $session = $this->Session->get('podcasts_feed_updater');
        $session[] = $dc->id;
        $this->Session->set('podcasts_feed_updater', array_unique($session));
    }


    /**
     * Return the IDs of the allowed itunes archives as array
     * @return array
     */
    public function getAllowedArchives()
    {
        if ($this->User->isAdmin)
        {
            $objArchive = NewsArchiveModel::findAll();
        }
        else
        {
            $objArchive = NewsArchiveModel::findMultipleByIds($this->User->news);
        }

        $return = array();

        if ($objArchive !== null)
        {
            while ($objArchive->next())
            {
                $return[$objArchive->id] = $objArchive->title;
            }
        }

        return $return;
    }


    /**
     * Check the RSS-feed alias
     * @param mixed
     * @param \DataContainer
     * @return mixed
     * @throws \Exception
     */
    public function checkFeedAlias($varValue, DataContainer $dc)
    {
        // No change or empty value
        if ($varValue == $dc->value || $varValue == '')
        {
            return $varValue;
        }

        $varValue = standardize($varValue); // see #5096

        $this->import('Automator');
        $arrFeeds = $this->Automator->purgeXmlFiles(true);

        // Alias exists
        if (array_search($varValue, $arrFeeds) !== false)
        {
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
        }

        return $varValue;
    }

    public function getItunesCategories()
    {
        $categories = array
        (
            'Arts' => array
            (
                'Arts|Design' => 'Design',
                'Arts|Fashion & Beauty' => 'Fashion & Beauty',
                'Arts|Food' => 'Food',
                'Arts|Literature' => 'Literature',
                'Arts|Performing Arts' => 'Performing Arts',
                'Arts|Visual Arts' => 'Visual Arts'
            ),
            'Business' => array
            (
                'Business|Business News' => 'Business News',
                'Business|Careers' => 'Careers',
                'Business|Investing' => 'Investing',
                'Business|Management & Marketing' => 'Management & Marketing',
                'Business|Shopping' => 'Shopping'
            ),
            'Comedy' => 'Comedy',
            'Education' => array
            (
                'Education|Education' => 'Education',
                'Education|Educational Technology' => 'Educational Technology',
                'Education|Higher Education' => 'Higher Education',
                'Education|K-12' => 'K-12',
                'Education|Training' => 'Training'
            ),
            'Games & Hobbies' => array
            (
                'Games & Hobbies|Automotive' => 'Automotive',
                'Games & Hobbies|Aviation' => 'Aviation',
                'Games & Hobbies|Hobbies' => 'Hobbies',
                'Games & Hobbies|Other Games' => 'Other Games',
                'Games & Hobbies|Video Games' => 'Video Games',
            ),
            'Government & Organizations' => array
            (
                'Government & Organizations|Local' => 'Local',
                'Government & Organizations|National' => 'National',
                'Government & Organizations|Non-Profit' => 'Non-Profit',
                'Government & Organizations|Regional' => 'Regional'
            ),
            'Health' => array
            (
                'Health|Alternative Health' => 'Alternative Health',
                'Health|Fitness & Nutrition' => 'Fitness & Nutrition',
                'Health|Self-Help' => 'Self-Help',
                'Health|Sexuality' => 'Sexuality'
            ),
            'Kids & Family' => 'Kids & Family',
            'Music' => 'Music',
            'News & Politics' => 'News & Politics',
            'Religion & Spirituality' => array
            (
                'Religion & Spirituality|Buddhism' => 'Buddhism',
                'Religion & Spirituality|Christianity' => 'Christianity',
                'Religion & Spirituality|Hinduism' => 'Hinduism',
                'Religion & Spirituality|Islam' => 'Islam',
                'Religion & Spirituality|Judaism' => 'Judaism',
                'Religion & Spirituality|Other' => 'Other',
                'Religion & Spirituality|Spirituality' => 'Spirituality'
            ),
            'Science & Medicine' => array
            (
                'Science & Medicine|Medicine' => 'Medicine',
                'Science & Medicine|Natural Sciences' => 'Natural Sciences',
                'Science & Medicine|Social Sciences' => 'Social Sciences'
            ),
            'Society & Culture' => array
            (
                'Society & Culture|History' => 'History',
                'Society & Culture|Personal Journals' => 'Personal Journals',
                'Society & Culture|Philosophy' => 'Philosophy',
                'Society & Culture|Places & Travel' => 'Places & Travel'
            ),
            'Sports & Recreation' => array
            (
                'Sports & Recreation|Amateur' => 'Amateur',
                'Sports & Recreation|College & High School' => 'College & High School',
                'Sports & Recreation|Outdoor' => 'Outdoor',
                'Sports & Recreation|Professional' => 'Professional'
            ),
            'Technology' => array
            (
                'Technology|Gadgets' => 'Gadgets',
                'Technology|Tech News' => 'Tech News',
                'Technology|Podcasting' => 'Podcasting',
                'Technology|Software How-To' => 'Software How-To'
            ),
            'TV & Film' => 'TV & Film'
        );

        return $categories;
    }

}