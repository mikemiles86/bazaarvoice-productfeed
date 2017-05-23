<?php
namespace BazaarvoiceProductFeed\Elements;

interface FeedElementInterface extends ElementInterface {

  public function setIncremental($incremental = TRUE);

  public function addProduct(ProductElementInterface $product);

  public function addCategory(CategoryElementInterface $category);

  public function addBrand(BrandElementInterface $brand);

  public function addProducts(array $products);

  public function addCategories(array $categories);

  public function addBrands(array $brands);

}