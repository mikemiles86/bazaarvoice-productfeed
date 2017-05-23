<?php

namespace BazaarvoiceProductFeed\Elements;

class FeedElement extends ElementBase implements FeedElementInterface {

  protected static $apiVersion = '5.6';
  protected $products;
  protected $brands;
  protected $categories;
  protected $incremental;

  public function __construct($name, $incremental = FALSE) {
    $this->setName($name);
    $this->setIncremental($incremental);
    return $this;
  }

  public function setIncremental($incremental = TRUE) {
    $this->incremental = $incremental ? TRUE:FALSE;
    return $this;
  }

  public function addProduct(ProductElementInterface $product) {
    $this->products[$product->getExternalId()] = $product;
    return $this;
  }

  public function addBrand(BrandElementInterface $brand) {
    $this->brands[$brand->getExternalId()] = $brand;
    return $this;
  }

  public function addCategory(CategoryElementInterface $category) {
    $this->categories[$category->getExternalId()] = $category;
    return $this;
  }

  public function addProducts(array $products) {
    foreach ($products as $product) {
      $this->addProduct($product);
    }
    return $this;
  }

  public function addBrands(array $brands) {
    foreach ($brands as $brand) {
      $this->addBrand($brand);
    }
    return $this;
  }

  public function addCategories(array $categories) {
    foreach ($categories as $category) {
      $this->addCategory($category);
    }
    return $this;
  }

  public function generateXMLArray() {

    $element = [
      '#attributes' => [
        'xmlns' => 'http://www.bazaarvoice.com/xs/PRR/ProductFeed/' . self::$apiVersion,
        'name' => $this->name,
        'incremental' => $this->incremental ? 'true' : 'false',
        'extractDate' => date('Y-m-d') . 'T' . date('H:i:s'),
        ],
      ];

    if ($brands = $this->generateBrandsXMLArray()) {
      $element['#children'][] = $brands;
    }

    if ($categories = $this->generateCategoriesXMLArray()) {
      $element['#children'][] = $categories;
    }

    if ($products = $this->generateProductsXMLArray()) {
      $element['#children'][] = $products;
    }

    return $element;
  }

  private function generateBrandsXMLArray() {
    $element = false;

    if (count($this->brands) > 0) {
      $element = $this->generateElementXMLArray('Brands');
      foreach ($this->brands as $brand) {
        $element['#children'][] = $brand->generateXMLArray();
      }
    }

    return $element;
  }

  private function generateCategoriesXMLArray() {
    $element = false;

    if (count($this->categories) > 0) {
      $element = $this->generateElementXMLArray('Categories');
      foreach ($this->categories as $category) {
        $element['#children'][] = $category->generateXMLArray();
      }
    }

    return $element;
  }

  private function generateProductsXMLArray() {
    $element = false;

    if (count($this->products) > 0) {
      $element = $this->generateElementXMLArray('Products');
      foreach ($this->products as $product) {
        $element['#children'][] = $product->generateXMLArray();
      }
    }

    return $element;
  }

}