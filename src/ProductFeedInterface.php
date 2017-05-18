<?php

namespace BazaarvoiceProductFeed;

use BazaarvoiceProductFeed\Elements\BrandElementInterface;
use BazaarvoiceProductFeed\Elements\CategoryElementInterface;
use BazaarvoiceProductFeed\Elements\ProductElementInterface;

interface ProductFeedInterface {

  public function addProduct(ProductElementInterface $product);

  public function addCategory(CategoryElementInterface $category);

  public function addBrand(BrandElementInterface $brand);

  public function addProducts(array $products);

  public function addCategories(array $categories);

  public function addBrands(array $brands);

  public function setName($name);

  public function setExtractDate($date);

  public function generateXML();


}