<?php

/**
 * This file is part of the contentful-management.php package.
 *
 * @copyright 2015-2017 Contentful GmbH
 * @license   MIT
 */
declare(strict_types=1);

namespace Contentful\Tests\Unit\Management\Resource\ContentType\Validation;

use Contentful\Management\Resource\ContentType\Validation\RegexpValidation;
use PHPUnit\Framework\TestCase;

class RegexpValidationTest extends TestCase
{
    public function testFromJsonToJsonSerialization()
    {
        $jsonString = '{"regexp": {"pattern": "^such", "flags": "im"}}';
        $validation = RegexpValidation::fromApiResponse(json_decode($jsonString, true));

        $this->assertJsonStringEqualsJsonString($jsonString, json_encode($validation));

        $this->assertEquals(['Text', 'Symbol'], $validation->getValidFieldTypes());
    }

    public function testGetSetData()
    {
        $validation = new RegexpValidation('^such', 'im');

        $this->assertEquals('^such', $validation->getPattern());
        $this->assertEquals('im', $validation->getFlags());

        $validation->setPattern('much');
        $this->assertEquals('much', $validation->getPattern());

        $validation->setFlags('g');
        $this->assertEquals('g', $validation->getFlags());
    }
}
