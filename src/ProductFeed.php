<?php

namespace BazaarvoiceProductFeed;

use BazaarvoiceProductFeed\Elements\BrandElement;
use BazaarvoiceProductFeed\Elements\CategoryElement;
use BazaarvoiceProductFeed\Elements\FeedElement;
use BazaarvoiceProductFeed\Elements\FeedElementInterface;
use BazaarvoiceProductFeed\Elements\ProductElement;
use phpseclib\Net\SFTP;

/**
 * Class ProductFeed
 * @package BazaarvoiceProductFeed
 */
class ProductFeed implements ProductFeedInterface {

  /**
   * @var bool
   */
  protected $use_stage = FALSE;

  public function __construct() {
    return $this;
  }

  /**
   * Set object to use staging (see: sendFeed()).
   * @return $this
   */
  public function useStage() {
    $this->use_stage = TRUE;
    return $this;
  }

  /**
   * Set object to use Production (see: sendFeed()).
   * @return $this
   */
  public function useProduction() {
    $this->use_stage = FALSE;
    return $this;
  }

  public function newFeed($name, $incremental = FALSE) {
    // Create a new FeedElement object.
    return  new FeedElement($name, $incremental);
  }

  public function newProduct($external_id, $name, $category_id, $page_url, $image_url) {
    // Return a new ProductElement object.
    return new ProductElement($external_id, $name, $category_id, $page_url, $image_url);
  }

  public function newBrand($external_id, $name){
    // Return a new BrandElement object.
    return new BrandElement($external_id, $name);
  }

  public function newCategory($external_id, $name, $page_url) {
    // Return a new CategoryElement object.
    return new CategoryElement($external_id, $name, $page_url);
  }

  public function printFeed(FeedElementInterface $feed) {
    $xml_string = FALSE;
    // Generate XML object.
    if ($xml = $this->generateFeedXML($feed)) {
      // retrieve XML string.
      $xml_string = $xml->asXML();
      // Bazaarvoice does not like CDATA.
      $xml_string = str_replace(array("<![CDATA[", "]]>"), "", $xml_string);
    }
    // Return XML string.
    return $xml_string;
  }

  public function saveFeed(FeedElementInterface $feed, $directory, $filename) {
    $saved = FALSE;
    // Get XML string of feed.
    if ($feed_xml = $this->printFeed($feed)) {
      // gzip file.
      if ($file = gzencode($feed_xml)) {
        // Cleanup directory string.
        $directory = rtrim($directory, '/\\');
        // Does directory exists and is it writable?
        if (is_dir($directory) && is_writable($directory)) {
          // build filepath string.
          $file_path = $directory . '/' . $filename . '.xml.gz';
          // Attempt to save the contents.
          if (file_put_contents($file_path, $file)) {
            $saved = $file_path;
          }
        }
      }
    }

    return $saved;
  }

  public function sendFeed($file_path, $sftp_username, $sftp_password, $sftp_directory = 'import-inbox', $sftp_port = '22') {
    $file_sent = FALSE;
    // Build host string, depending if using stage or not.
    $sftp_host = 'sftp' . ($this->use_stage ? '-stg':'') . '.bazaarvoice.com';
    // Get filename.
    $filename = basename($file_path);
    // Create a new SFTP object using host and port.
    $sftp = new SFTP($sftp_host, $sftp_port);
    // Remove any extraneous slashes.
    $sftp_directory = rtrim($sftp_directory, '/');
    $sftp_directory = ltrim($sftp_directory, '/');

    try {
      // Attempt to login with credentials.
      if ($sftp->login($sftp_username, $sftp_password)) {
        // Get full remote directory path.
        $root_directory = $sftp->realpath(".");
        $full_directory_path = $root_directory . ((substr($root_directory, -1) == '/') ? '' : '/') . $sftp_directory;
        // Change to remote directory.
        $sftp->chdir($full_directory_path);
        // Attempt to upload the file contents.
        if ($sftp->put($filename, file_get_contents($file_path, FALSE))) {
          // Successful upload.
          $file_sent = TRUE;
        }
      }
    }
    // Capture what went wrong.
    catch (\Exception $e) {
      $file_sent = $e->getMessage();
    }


    return $file_sent;
  }

  /**
   * Generate and return a  SimpleXMLElement object for the product feed
   *
   * @param \BazaarvoiceProductFeed\Elements\FeedElementInterface $feed
   *   Bazaarvoice FeedElement Object
   *
   * @return \SimpleXMLElement
   *   Simple XML object
   */
  private function generateFeedXML(FeedElementInterface $feed) {
    // Create a new SimpleXML element object.
    $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><Feed></Feed>');
    $feed_xml = $feed->generateXMLArray();
    // Build XML string using FeedElement XML array.
    $this->buildXML($xml, $feed_xml);
    // return XML object.
    return $xml;
  }

  /**
   * Recursive function to build SimpleXMLElements.
   *
   * @param \SimpleXMLElement $xml
   *   SimpleXML Object. Passed by reference.
   * @param array $element
   *   Product feed XML Element array to add to SimpleXML
   */
  private function buildXML(\SimpleXMLElement &$xml, array $element = []) {

    // Is there an element to add?
    if (!empty($element)) {
      // By default set passed by reference element as xml element to manipulate.
      $element_xml = $xml;
      // Element have a #name?
      if (isset($element['#name']) && !empty($element['#name'])) {
        // Create new child on parent and change element_xml to child.
        $element_xml = $element_xml->addChild($element['#name'], ($element['#value'] ?? null));
      }

      // Have attributes to add?
      if (isset($element['#attributes']) && !empty($element['#attributes'])) {
        // Add each attribute to the element_xml.
        foreach ($element['#attributes'] as $attribute => $value) {
          $element_xml->addAttribute($attribute, $value);
        }
      }

      // Have element_xml and there are children?
      if (isset($element['#children']) && !empty($element['#children'])) {
        // Recursively add the child elements.
        foreach ($element['#children'] as $child) {
          $this->buildXML($element_xml, $child);
        }
      }
    }
  }
}
