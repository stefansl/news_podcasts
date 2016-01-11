<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   news_podcasts
 * @author    Stefan Schulz-Lauterbach
 * @author    Samuel Heer
 * @license   GNU/LGPL
 * @copyright CLICKPRESS Internetagentur 2015
 */


/**
 * Namespace
 */
namespace CLICKPRESS;

use Contao\UserModel;


/**
 * Class NewsPodcasts
 *
 * @copyright  CLICKPRESS Internetagentur 2015
 * @author     Stefan Schulz-Lauterbach
 */
class NewsPodcasts extends \Frontend
{

    /**
     * Update a particular RSS feed
     *
     * @param integer
     * @param boolean
     */
    public function generateFeed( $intId, $blnIsFeedId = false )
    {

        $objFeed = $blnIsFeedId ? \NewsModel::findByPk( $intId ) : \NewsArchiveModel::findByArchive( $intId );

        if ( $objFeed === null ) {
            return;
        }

        $objFeed->feedName = $objFeed->alias ?: 'itunes' . $objFeed->id;

        // Delete XML file
        if ( \Input::get( 'act' ) == 'delete' ) {
            $this->import( 'Files' );
            $this->Files->delete( $objFeed->feedName . '.xml' );
        } // Update XML file
        else {
            $this->generateFiles( $objFeed->row() );
            $this->log( 'Generated podcast feed "' . $objFeed->feedName . '.xml"', __METHOD__, TL_CRON );
        }
    }


    /**
     * Delete old files and generate all feeds
     */
    public function generateFeeds()
    {
        $this->import( 'Automator' );
        $this->Automator->purgeXmlFiles();

        $objFeed = \NewsPodcastsFeedModel::findAll();

        if ( $objFeed !== null ) {
            while ( $objFeed->next() ) {
                $objFeed->feedName = $objFeed->alias ?: 'itunes' . $objFeed->id;
                $this->generateFiles( $objFeed->row() );
                $this->log( 'Generated podcast feed "' . $objFeed->feedName . '.xml"', __METHOD__, TL_CRON );
            }
        }
    }


    /**
     * Generate all feeds including a certain archive
     * @param integer
     */
    public function generateFeedsByArchive($intId)
    {
        $objFeed = \NewsPodcastsFeedModel::findByArchive($intId);

        if ($objFeed !== null)
        {
            while ($objFeed->next())
            {
                $objFeed->feedName = $objFeed->alias ?: 'itunes' . $objFeed->id;

                // Update the XML file
                $this->generateFiles($objFeed->row());
                $this->log('Generated podcast feed "' . $objFeed->feedName . '.xml"', __METHOD__, TL_CRON);
            }
        }
    }


    /**
     * Generate an XML files and save them to the root directory
     *
     * @param array
     */
    protected function generateFiles( $arrFeed )
    {
        $arrArchives = deserialize( $arrFeed['archives'] );

        if ( !is_array( $arrArchives ) || empty($arrArchives) ) {
            return;
        }

        $strType = 'generateItunes';

        $strLink = $arrFeed['feedBase'] ?: \Environment::get( 'base' );
        $strFile = $arrFeed['feedName'];

        $objFeed              = new iTunesFeed( $strFile );
        $objFeed->link        = $strLink;
        $objFeed->headline    = $arrFeed['headline'];
        $objFeed->description = $arrFeed['description'];
        $objFeed->language    = $arrFeed['language'];
        $objFeed->owner       = $arrFeed['owner'];
        $objFeed->email       = $arrFeed['email'];
        $objFeed->category    = $arrFeed['category'];
        $objFeed->published   = $arrFeed['tstamp'];

        //Add Feed Image

        $objFile = \FilesModel::findByUuid( $arrFeed['image'] );

        if ( $objFile !== null ) {
            $objFeed->imageUrl = \Environment::get( 'base' ) . $objFile->path;
        }



        // Get the items
        if ( $arrFeed['maxItems'] > 0 ) {
            $objPodcasts = \NewsModel::findPublishedByPids( $arrArchives, null, $arrFeed['maxItems'], null, array( 'column' => 'addPodcast', 'value' => 1 ) );
        } else {
            $objPodcasts = \NewsModel::findPublishedByPids( $arrArchives, null, null, null, array( 'column' => 'addPodcast', 'value' => 1 ) );
        }


        // Parse the items
        if ( $objPodcasts !== null ) {
            $arrUrls = array();

            while ( $objPodcasts->next() ) {
                $jumpTo = $objPodcasts->getRelated( 'pid' )->jumpTo;

                // No jumpTo page set (see #4784)
                if ( !$jumpTo ) {
                    continue;
                }

                // Get the jumpTo URL
                if ( !isset($arrUrls[$jumpTo]) ) {
                    $objParent = \PageModel::findWithDetails( $jumpTo );

                    // A jumpTo page is set but does no longer exist (see #5781)
                    if ( $objParent === null ) {
                        $arrUrls[$jumpTo] = false;
                    } else {
                        $arrUrls[$jumpTo] = $this->generateFrontendUrl( $objParent->row(), (($GLOBALS['TL_CONFIG']['useAutoItem'] && !$GLOBALS['TL_CONFIG']['disableAlias']) ? '/%s' : '/items/%s'), $objParent->language );
                    }
                }

                // Skip the event if it requires a jumpTo URL but there is none
                if ( $arrUrls[$jumpTo] === false && $objPodcasts->source == 'default' ) {
                    continue;
                }

                $strUrl  = $arrUrls[$jumpTo];
                $objItem = new \FeedItem();


                $objItem->headline = $objPodcasts->headline;
                $objItem->subheadline = ($objPodcasts->subheadline !== null ) ? $objPodcasts->subheadline : $objPodcasts->description;
                $objItem->link  = $strLink . sprintf( $strUrl, (($objPodcasts->alias != '' && !$GLOBALS['TL_CONFIG']['disableAlias']) ? $objPodcasts->alias : $objPodcasts->id) );

                $objItem->published = $objPodcasts->date;

                $objAuthor = $objPodcasts->getRelated('author');
                $objItem->author    = $objAuthor->name;

                $objItem->description = $objPodcasts->teaser;

                // Add the article image as enclosure
                $objItem->addEnclosure( $objFeed->imageUrl );


                // Add the Audio File
                if ( $objPodcasts->podcast ) {
                    $objFile = \FilesModel::findByUuid( $objPodcasts->podcast );
                    if ( $objFile !== null ) {
                        $objItem->addEnclosure( $objFile->path );

                        //Prepare the duration
                        $mp3file           = new GetMp3Duration( TL_ROOT . '/' . $objFile->path );
                        $objItem->duration = $mp3file->formatTime( $mp3file->getDuration() );
                    }
                }

                $objFeed->addItem( $objItem );
            }
        }

        // Create the file
        \File::putContent( 'share/' . $strFile . '.xml', $this->replaceInsertTags( $objFeed->$strType(), false ) );

    }
}
