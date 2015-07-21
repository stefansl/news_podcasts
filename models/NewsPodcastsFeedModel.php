<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package News
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace CLICKPRESS;


/**
 * Reads podcasts feeds
 *
 * @package   Models
 * @author    Leo Feyer <https://github.com/leofeyer>
 * @copyright Leo Feyer 2005-2014
 */
class NewsPodcastsFeedModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_news_podcasts_feed';

    /**
     * Find all feeds which include a certain news archive
     *
     * @param integer $intId      The news archive ID
     * @param array   $arrOptions An optional options array
     *
     * @return \Model\Collection|null A collection of models or null if the news archive is not part of a feed
     */
    public static function findByArchive($intId, array $arrOptions=array())
    {
        $t = static::$strTable;
        return static::findBy(array("$t.archives LIKE '%\"" . intval($intId) . "\"%'"), null, $arrOptions);
    }
}
