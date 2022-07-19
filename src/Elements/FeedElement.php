<?php

namespace BazaarvoiceProductFeed\Elements;

/**
 * Class FeedElement
 * @package BazaarvoiceProductFeed\Elements
 */
class FeedElement extends ElementBase implements FeedElementInterface {

  /**
   * @var string
   */
  protected static $apiVersion = '5.6';

  /**
   * @var array
   */
  protected $products = [];

  /**
   * @var array
   */
  protected $brands = [];

  /**
   * @var array
   */
  protected $categories = [];

  /**
   * @var bool
   */
  protected $incremental;

  /**
   * FeedElement constructor.
   * @param string $name
   *   Feed name
   *
   * @param bool $incremental
   *   Boolean TRUE or FALSE if is an incremental feedElement.
   */
  public function __construct($name, $incremental = FALSE) {
    // See: ElementBase::setName().
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
    // Build rool XML element, with only Attributes.
    $element = [
      '#attributes' => [
        'xmlns' => 'http://www.bazaarvoice.com/xs/PRR/ProductFeed/' . self::$apiVersion,
        'name' => $this->name,
        'incremental' => $this->incremental ? 'true' : 'false',
        'extractDate' => date('Y-m-d') . 'T' . date('H:i:s'),
        ],
      ];

    // Get brands array if brands have been added.
    if ($brands = $this->generateBrandsXMLArray()) {
      // Add as element children.
      $element['#children'][] = $brands;
    }

    // Get categories array if categories have been added.
    if ($categories = $this->generateCategoriesXMLArray()) {
      // Add as element children.
      $element['#children'][] = $categories;
    }

    // Get products array if products have been added.
    if ($products = $this->generateProductsXMLArray()) {
      // Add as element children.
      $element['#children'][] = $products;
    }

    return $element;
  }

  /**
   * If brands have been added, generate their XML arrays.
   *
   * @return array|bool
   *   XML element array or boolean FALSE.
   */
  private function generateBrandsXMLArray() {
    $element = false;
    // Have brands?
    if (count($this->brands) > 0) {
      // Generate root 'Brands' element.
      $element = $this->generateElementXMLArray('Brands');
      // Loop through each brand.
      foreach ($this->brands as $brand) {
        // Add XML array as child to Brands element.
        $element['#children'][] = $brand->generateXMLArray();
      }
    }

    return $element;
  }

  /**
   * If categories have been added, generate their XML arrays.
   *
   * @return array|bool
   *   XML element array or boolean FALSE.
   */
  private function generateCategoriesXMLArray() {
    $element = false;
    // Have categories?
    if (count($this->categories) > 0) {
      // Generate root 'Categories' element.
      $element = $this->generateElementXMLArray('Categories');
      // Loop through each category.
      foreach ($this->categories as $category) {
        // Add XML array as child to Categories element.
        $element['#children'][] = $category->generateXMLArray();
      }
    }

    return $element;
  }

  /**
   * If products have been added, generate their XML arrays.
   *
   * @return array|bool
   *   XML element array or boolean FALSE.
   */
  private function generateProductsXMLArray() {
    $element = false;
    // Have products?
    if (count($this->products) > 0) {
      // Generate root 'Products' element.
      $element = $this->generateElementXMLArray('Products');
      // Loop through each product.
      foreach ($this->products as $product) {
        // Add XML array as child to Products element.
        $element['#children'][] = $product->generateXMLArray();
      }
    }

    return $element;
  }

}
