<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace CLICKPRESS;


/**
 * Reads news
 * @author Stefan Schulz-Lauterbach
 */
class NewsPodcastsModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_news';


    /**
     * Find published news items by their parent ID
     *
     * @param array   $arrPids     An array of news archive IDs
     * @param boolean $blnFeatured If true, return only featured news, if false, return only unfeatured news
     * @param integer $intLimit    An optional limit
     * @param integer $intOffset   An optional offset
     * @param array   $arrOptions  An optional options array
     *
     * @return \Model\Collection|\NewsModel[]|\NewsModel|null A collection of models or null if there are no news
     */
    public static function findPublishedByPids($arrPids, $blnFeatured=null, $intLimit=0, $intOffset=0, array $arrOptions=array())
    {
        if (!is_array($arrPids) || empty($arrPids))
        {
            return null;
        }

        $t = static::$strTable;
        $arrColumns = array("$t.pid IN(" . implode(',', array_map('intval', $arrPids)) . ")");

        // Add only items with podcasts
        $arrColumns[] = "$t.addPodcast='1'";

        // Never return unpublished elements in the back end, so they don't end up in the RSS feed
        if (!BE_USER_LOGGED_IN || TL_MODE == 'BE')
        {
            $time = \Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";
        }

        if (!isset($arrOptions['order']))
        {
            $arrOptions['order']  = "$t.date DESC";
        }

        $arrOptions['limit']  = $intLimit;
        $arrOptions['offset'] = $intOffset;

        return static::findBy($arrColumns, null, $arrOptions);
    }
}
