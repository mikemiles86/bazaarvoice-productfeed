<?php

namespace BazaarvoiceProductFeed;

use BazaarvoiceProductFeed\Elements\FeedElementInterface;
use BazaarvoiceProductFeed\Xml\BazaarvoiceSimpleXMLElement;

class ProductFeed implements ProductFeedInterface {
    private $feed;
    private $xml;

    public function __construct(FeedElementInterface $feed) {
      $this->feed = $feed;
      return $this;
    }

    public function getFeed() {
      return $this->feed;
    }

    public function generateXMLFeed() {
      $xml = new BazaarvoiceSimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>');
      $elements = $this->feed->generateXMLArray();
      $this->buildXML($xml, $elements);
      $this->xml = $xml;
    }

    private function buildXML(&$xml, array $elements = []) {

    }
}