<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   news_podcasts
 * @author    Samuel Heer
 * @author    Stefan Schulz-Lauterbach
 * @license   GNU/LGPL
 * @copyright Samuel Heer 2014
 */

namespace CLICKPRESS;

class iTunesFeed extends \Feed
{

    /**
     * Generate an iTunes Podcast feed
     *
     * @return string
     */
    public function generateItunes()
    {

        $this->adjustPublicationDate();

        $xml = '<?xml version="1.0" encoding="' . $GLOBALS['TL_CONFIG']['characterSet'] . '"?>';
        $xml .= '<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">';
        $xml .= '<channel>';
        $xml .= '<atom:link href="' . $this->podcastUrl . '" rel="self" type="application/rss+xml" />';
        $xml .= '<title>' . specialchars( $this->title ) . '</title>';
        $xml .= '<language>' . $this->language . '</language>';

        $xml .= '<copyright>&#x2117; &amp; &#xA9; ' . date('Y') . ' ' . $this->owner . '</copyright>';

        $xml .= '<itunes:subtitle>' . specialchars( $this->subtitle ) . '</itunes:subtitle>';
        $xml .= '<itunes:author>' . $this->author . '</itunes:author>';
        $xml .= '<itunes:summary>' . specialchars( $this->description ) . '</itunes:summary>';
        $xml .= '<itunes:explicit>' . ((!empty($this->explicit)) ? specialchars( $this->explicit )  : 'no') . '</itunes:explicit>';
        $xml .= '<description>' . specialchars( $this->description ) . '</description>';
        $xml .= '<link>' . specialchars( $this->link ) . '</link>';
        $xml .= '<pubDate>' . date( 'r', $this->published ) . '</pubDate>';
        $xml .= '<generator>Contao Open Source CMS - News Podcasts</generator>';
        $xml .= '<itunes:owner>';
        $xml .= '<itunes:name>' . $this->owner . '</itunes:name>';
        $xml .= '<itunes:email>' . $this->email . '</itunes:email>';
        $xml .= '</itunes:owner>';

        $xml .= '<itunes:image href="' . $this->imageUrl . '" />';

        $xml .= $this->generateItunesCategory();

        foreach ( $this->arrItems as $objItem ) {
            $xml .= '<item>';
            $xml .= '<title>' . specialchars( strip_tags( $objItem->headline ) ) . '</title>';
            //$xml .= '<author>' . specialchars( strip_tags( $objItem->author ) ) . '&lt;' . $objFeed->email . '&gt</author>';
            $xml .= '<itunes:author>' . specialchars( strip_tags( $objItem->author ) ) . '</itunes:author>';
            $xml .= '<description><![CDATA[' . $objItem->description . ']]></description>';
            $xml .= '<link>' . specialchars( $objItem->link ) . '</link>';
            $xml .= '<pubDate>' . date( 'r', $objItem->published ) . '</pubDate>';
            $xml .= '<itunes:subtitle><![CDATA[' . $objItem->headline . ']]></itunes:subtitle>';
            $xml .= (!empty($objItem->explicit)) ? '<itunes:explicit>' . specialchars( $objItem->explicit ) . '</itunes:explicit>' : '';
            $xml .= '<itunes:summary><![CDATA[' . $objItem->description . ']]></itunes:summary>';
            $xml .= '<itunes:duration>' . $objItem->duration . '</itunes:duration>';

            // Add the GUID
            if ( $objItem->guid ) {
                // Add the isPermaLink attribute if the guid is not a link (see #4930)
                if ( strncmp( $objItem->guid, 'http://', 7 ) !== 0 && strncmp( $objItem->guid, 'https://', 8 ) !== 0 ) {
                    $xml .= '<guid isPermaLink="false">' . $objItem->guid . '</guid>';
                } else {
                    $xml .= '<guid>' . $objItem->guid . '</guid>';
                }
            } else {
                $xml .= '<guid>' . specialchars( $objItem->link ) . '</guid>';
            }

            // Enclosures
            $xml .= '<enclosure url="' . $objItem->podcastUrl . '" length="' . $objItem->length . '" type="' . $objItem->type . '" />';

            $xml .= '</item>';
        }

        $xml .= '</channel>';
        $xml .= '</rss>';

        return $xml;
    }


    /**
     * Generate iTunes XML for categories
     *
     * @return string
     */
    protected function generateItunesCategory()
    {

        $category = explode('|',$this->category);

        $catStr = '<itunes:category text="' . htmlentities( $category[0] ) . '">';
        if (isset($category[1])) {
            $catStr .= '<itunes:category text="' . htmlentities( $category[1] ) . '" />';
        }
        $catStr .= '</itunes:category>';

        return $catStr;
    }
}
