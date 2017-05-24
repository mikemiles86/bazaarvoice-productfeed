<?php

namespace BazaarvoiceProductFeed;

use BazaarvoiceProductFeed\Elements\FeedElementInterface;

/**
 * Interface ProductFeedInterface
 * @package BazaarvoiceProductFeed
 */
interface ProductFeedInterface {

  /**
   * Instantiate a new Feed Element object.
   *
   * @param string $name
   *   Name for the feed.
   *
   * @param bool $incremental
   *   Boolean if feed is an incremental feed.
   *
   * @return \BazaarvoiceProductFeed\Elements\FeedElementInterface
   *   New FeedElement object.
   */
  public function newFeed($name, $incremental = FALSE);

  /**
   * Instantiate a new ProductElement object.
   *
   * @param string $external_id
   *   Product unique external_id.
   *
   * @param string $name
   *   Product name
   *
   * @param string $category_id
   *   Product category id
   *
   * @param string $page_url
   *   Product page url.
   *
   * @param string $image_url
   *   Product image url.
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   new ProductElement object.
   */
  public function newProduct($external_id, $name, $category_id, $page_url, $image_url);

  /**
   * Instantiate new BrandElement object.
   *
   * @param string $external_id
   *   Brand external id.
   *
   * @param string $name
   *   Brand name.
   *
   * @return \BazaarvoiceProductFeed\Elements\BrandElementInterface
   *   New brandElement object.
   */
  public function newBrand($external_id, $name);

  /**
   * Instantiate new CategoryElement object.
   *
   * @param string $external_id
   *  Category unique eternal id.
   *
   * @param string $name
   *   Category name.
   *
   * @param string $page_url
   *   Category url
   *
   * @return \BazaarvoiceProductFeed\Elements\CategoryElementInterface
   *   new CategoryElement object.
   */
  public function newCategory($external_id, $name, $page_url);

  /**
   * Generate and return XML string for product feed.
   *
   * @param \BazaarvoiceProductFeed\Elements\FeedElementInterface $feed
   *   FeedElement object.
   *
   * @return string
   *   String of XML data.
   */
  public function printFeed(FeedElementInterface $feed);

  /**
   * Save XML feed to a file on server.
   *
   * @param \BazaarvoiceProductFeed\Elements\FeedElementInterface $feed
   *   FeedElement object.
   * @param string $file_location
   *   Directory path of where to save feedfile.
   *
   * @param string $file_name
   *   Filename of feed file to save.
   *
   * @return bool
   *   True | False if data was saved to file.
   */
  public function saveFeed(FeedElementInterface $feed, $file_location, $file_name);

  /**
   * Send Productfeed file to Bazaarvoice via sFTP.
   * @param string $file_path
   *   Local filepath to Product feed .xml.gz file.
   * @param string $sftp_username
   *   sFTP username.
   * @param string $sftp_password
   *  sFTP password
   * @param string $sftp_directory
   *   Directory to place file into. default: /import-box.
   * @param string $sftp_port
   *   Port to use for sFTP. default on 22.
   *
   * @return bool
   *    True | False on success/failure.
   */
  public function sendFeed($file_path, $sftp_username, $sftp_password, $sftp_directory = '/import-box', $sftp_port = '22');

}