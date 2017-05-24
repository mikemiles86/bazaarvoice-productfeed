<?php
namespace BazaarvoiceProductFeed\Elements;

/**
 * Interface FeedElementInterface
 * @package BazaarvoiceProductFeed\Elements
 */
interface FeedElementInterface extends ElementInterface {

  /**
   * Set boolean status of incremental flag.
   *
   * @param bool $incremental
   *   Boolean TRUE or FALSE.
   *
   * @return \BazaarvoiceProductFeed\Elements\FeedElementInterface
   *    return this instance of FeedElement object.
   */
  public function setIncremental($incremental = TRUE);

  /**
   * Add a ProductElement to feed Element
   * @param \BazaarvoiceProductFeed\Elements\ProductElementInterface $product
   *   Product object to add to feed.
   *
   * @return \BazaarvoiceProductFeed\Elements\FeedElementInterface
   *    return this instance of FeedElement object.
   */
  public function addProduct(ProductElementInterface $product);

  /**
   * Add CategoryElement to feedElement
   *
   * @param \BazaarvoiceProductFeed\Elements\CategoryElementInterface $category
   *   CategoryElement object to add to feed.
   *
   * @return \BazaarvoiceProductFeed\Elements\FeedElementInterface
   *    return this instance of FeedElement object.
   */
  public function addCategory(CategoryElementInterface $category);

  /**
   * Add brandElement to FeedElement
   *
   * @param \BazaarvoiceProductFeed\Elements\BrandElementInterface $brand
   *   BrandElement to add to feed.
   *
   * @return \BazaarvoiceProductFeed\Elements\FeedElementInterface
   *    return this instance of FeedElement object.
   */
  public function addBrand(BrandElementInterface $brand);

  /**
   * Add multiple ProductElements to feed.
   *
   * @param array $products
   *   Array of \BazaarvoiceProductFeed\Elements\ProductElementInterface objects.
   *
   * @return \BazaarvoiceProductFeed\Elements\FeedElementInterface
   *    return this instance of FeedElement object.
   */
  public function addProducts(array $products);

  /**
   * Add multiple CategoryElements to feed.
   *
   * @param array $categories
   *   Array of \BazaarvoiceProductFeed\Elements\CategoryElementInterface objects.
   *
   * @return \BazaarvoiceProductFeed\Elements\FeedElementInterface
   *    return this instance of FeedElement object.
   */
  public function addCategories(array $categories);

  /**
   * Add multiple BrandElements to feed.
   *
   * @param array $brands
   *   Array of \BazaarvoiceProductFeed\Elements\BrandElementInterface objects.
   *
   * @return \BazaarvoiceProductFeed\Elements\FeedElementInterface
   *    return this instance of FeedElement object.
   */
  public function addBrands(array $brands);

}