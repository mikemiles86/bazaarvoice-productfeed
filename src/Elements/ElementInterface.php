<?php

namespace BazaarvoiceProductFeed\Elements;

interface ElementInterface {

  public function setExternalId($external_id);

  public function setName($name);

  public function generateXMLElement();
}