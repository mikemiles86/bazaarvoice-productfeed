<?php
namespace Tests\Feature;

use BazaarVoice\Elements\BrandElement;
use PHPUnit\Framework\TestCase;

class BrandElementTest extends TestCase
{
    /** @test */
    public function it_generates_xml_array()
    {
        $externalId = '123';
        $brandName = 'Some Brand';
        $brandElement = new BrandElement($externalId, $brandName);
        $expectedBrandXMLArray = [
            '#name' => 'Brand',
            '#children' => [
                [
                    '#name' => 'ExternalId',
                    '#value' => '123',
                ],
                [
                    '#name' => 'Name',
                    '#value' => 'Some Brand',
                ]
            ],
        ];

        $brandXMLArray = $brandElement->generateXMLArray();

        $this->assertEquals($expectedBrandXMLArray, $brandXMLArray);
    }
}
