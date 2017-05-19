<?php

namespace BazaarvoiceProductFeed\Elements;

interface ElementInterface {

  public function getExternalId();

  public function setExternalId($external_id);

  public function setName($name);

  public function setRemoved($removed = TRUE);

  public function generateXMLArray();
}