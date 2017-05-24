# Bazaarvoice Productfeed Library

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bazaarvoice-productfeed/api.svg?style=flat-square)](https://packagist.org/packages/mikemiles86/bazaarvoice-productfeed)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/bazaarvoice-productfeed/api.svg?style=flat-square)](https://packagist.org/packages/mikemiles86/bazaarvoice-productfeed)

A PHP library for generating and sFTPing XML [Bazaarvoice ProductFeeds](http://labsbp-docsportal.aws.bazaarvoice.com/DataFeeds/Introduction/IntroductionDataFeeds_con.html).

## Install

Via Composer

``` bash
$ composer require mikemiles86/bazaarvoice-productfeed
```

## Usage

### Creating a Feed.
``` php
$productFeed = new \BazaarvoiceProductFeed\ProductFeed();
```

#### Creating a feedElement
``` php
$productFeed = new \BazaarvoiceProductFeed\ProductFeed();
$feed_element = $productFeed->newFeed('my_feed');
```

### Creating products and adding them to a feed.
``` php
$productFeed = new \BazaarvoiceProductFeed\ProductFeed();
$feed_element = $productFeed->newFeed('my_feed');

$product_element = $productFeed->newProduct('my_product', 'My Product', 'product_category_123', 'htttp://www.example.com/my-product', 'http://www.example.com/images/my-product.jpg');
$feed_element->addProduct($product_element);

$more_products = [];

$second_product = $productFeed->newProduct('second_product', 'Second Product', 'product_category_456', 'htttp://www.example.com/second-product', 'http://www.example.com/images/second-product.jpg');
  ->setDescription('This is my second product')
  ->addPageUrl('http://www.example.es/second-product', 'es_SP')
  ->setBrandId('my_brand_123')
  ->addUPC('012345');
  
$more_products[] = $second_product;

$more_products[] = $productFeed->newProduct('third_product', 'Third Product', 'product_category_789', 'htttp://www.example.com/third-product', 'http://www.example.com/images/third-product.jpg')
  ->addISBN('123-456-7890')
  ->addPageUrl('http://www.example.co.uk/third-product', 'en_UK')
  ->addCustomAttribute('PRODUCT_FAMILY', 'example_products');

$feed_element->addProducts($more_products);

```

### Creating categories and adding them to a feed.
``` php
$productFeed = new \BazaarvoiceProductFeed\ProductFeed();
$feed_element = $productFeed->newFeed('my_feed');

// ...

$category_element = $productFeed->newCategory('my_category', 'My Category', 'htttp://www.example.com/my-product');
$feed_element->addCategory($category_element);

$more_categories = [];

$second_category = $productFeed->newCategory('second_category', 'Second Category', 'http://www.example.com/second-category')
  ->setImageUrl('http://www.example.com/images/second-category.jpg')
  ->addImageUrl('http://www.example.co.uk/images/uk-second-category.jpg', 'en_UK')
  ->setParentId('parent_category_id');

$more_categories[] = $second_category;

$feed_element->addCategories($more_categories);

```

### Creating brands and adding them to a feed.
``` php
$productFeed = new \BazaarvoiceProductFeed\ProductFeed();
$feed_element = $productFeed->newFeed('my_feed');

// ...

$brand_element = $productFeed->newBrand('my_brand', 'My Brand');
$feed_element->addBrand($brand_element);

$more_brands = [];

$second_brand = $productFeed->newBrand('second_brand', 'Second Brand')
  ->addName('Duo Brand', 'es_SP')
  ->addName('Brand the Second', 'en_UK');

$more_brands[] = $second_brand;

$more_brands[] = $productFeed->newBrand('third_brand', 'Third Brand');

$feed_element->addBrands($more_brands);

```

## Print ProductFeed XML string
``` php
$productFeed = new \BazaarvoiceProductFeed\ProductFeed();
$feed_element = $productFeed->newFeed('my_feed');

// ... add products, brands & categories ...

print $productFeed->printFeed($feed_element);
```

### Saving Productfeed as an XML file.
``` php

$productFeed = new \BazaarvoiceProductFeed\ProductFeed();
$feed_element = $productFeed->newFeed('my_feed');

// ... add products, brands & categories ...

$productFeed->saveFeed($feed_element, 'path/to/dir', 'my_feed_XYZ');
```

### SFTP ProductFeed to Bazaarvoice.
``` php

$productFeed = new \BazaarvoiceProductFeed\ProductFeed();
$feed_element = $productFeed->newFeed('my_feed');

// ... add products, brands & categories ...

if ($feed_file = $productFeed->saveFeed($feed_element, 'path/to/dir', 'my_feed_XYZ') {  
  try {
    $productFeed->sendFeed($feed_file, $sftp_username, $sftp_password);
  } catch (\Exception $e) {
    // Failed to FTP feed file.
  }
}

```

## Testing

``` bash
$ composer test
```

## Credits

- [Mike Miles](https://github.com/mikemiles86)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.