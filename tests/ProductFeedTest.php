<?php

namespace BazaarvoiceProductFeed\Tests;

use BazaarvoiceProductFeed\ProductFeed;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;

/**
 * Class ProductFeedTest
 * @package BazaarvoiceProductFeed\Tests
 */
class ProductFeedTest extends \PHPUnit_Framework_TestCase {

  /**
   * Test instantiation of FeedElement
   */
  public function testNewFeedElement() {
    $pf = new ProductFeed();
    $name = substr( md5(rand()), 0, 8);
    $feed = $pf->newFeed($name);
    $this->assertInstanceOf('BazaarvoiceProductFeed\Elements\FeedElementInterface', $feed);
  }

  /**
   * Test instantiation of BrandElement.
   */
  public function testNewBrandElement() {
    $pf = new ProductFeed();
    $name = substr( md5(rand()), 0, 8);
    $id = 'test_brand';
    $brand = $pf->newBrand($id, $name);
    $this->assertInstanceOf('BazaarvoiceProductFeed\Elements\BrandElementInterface', $brand);
  }

  /**
   * Test instantiation of CategoryElement.
   */
  public function testNewCategoryElement() {
    $pf = new ProductFeed();
    $name = substr( md5(rand()), 0, 8);
    $id = 'test_category';
    $page_url = 'http://www.example.com/' . $id;
    $category = $pf->newCategory($id, $name, $page_url);
    $this->assertInstanceOf('BazaarvoiceProductFeed\Elements\CategoryElement', $category);
  }

  /**
   * Test instantiation of ProductElement.
   */
  public function testNewProductElement() {
    $pf = new ProductFeed();
    $name = substr( md5(rand()), 0, 8);
    $id = 'test_product';
    $page_url = 'http://www.example.com/' . $id;
    $image_url = $page_url . '/' . $name . '.jpg';
    $product = $pf->newProduct($id, $name, 'test_category', $page_url, $image_url);
    $this->assertInstanceOf('BazaarvoiceProductFeed\Elements\ProductElement', $product);
  }

  /**
   * Test generating valid XML document.
   */
  public function testPrintFeed() {
    $pf = new ProductFeed();
    $feed = $pf->newFeed('testFeed');
    $xml_string = $pf->printFeed($feed);
    new \SimpleXMLElement($xml_string);

    $prev = libxml_use_internal_errors(true);
    try {
      new \SimpleXMLElement($xml_string);
    } catch(\Exception $e) {
    }
    $this->assertEquals(0,count(libxml_get_errors()));
    // Tidy up.
    libxml_clear_errors();
    libxml_use_internal_errors($prev);

  }

  /**
   * Test saving ProductFeed gzipped XML file.
   */
  public function testSaveFeed() {
    $test_feed = 'testFeed_' . substr( md5(rand()), 0, 10);
    $pf = new ProductFeed();
    $feed = $pf->newFeed($test_feed);
    vfsStreamWrapper::register();
    vfsStreamWrapper::setRoot(new vfsStreamDirectory($test_feed . '_dir'));
    $pf->saveFeed($feed, vfsStream::url($test_feed . '_dir'), $test_feed);
    $this->assertTrue(vfsStreamWrapper::getRoot()->hasChild($test_feed . '.xml.gz'));
  }

}