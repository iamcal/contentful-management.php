<?php

/**
 * This file is part of the contentful-management.php package.
 *
 * @copyright 2015-2017 Contentful GmbH
 * @license   MIT
 */
declare(strict_types=1);

namespace Contentful\Tests\E2E\Management;

use Contentful\Management\Resource\Extension;
use Contentful\Management\Resource\Extension\FieldType;
use Contentful\Tests\End2EndTestCase;

class ExtensionTest extends End2EndTestCase
{
    /**
     * @vcr e2e_extension_get.json
     */
    public function testGet()
    {
        $client = $this->getReadWriteClient();

        $extension = $client->extension->get('3GKNbc6ddeIYgmWuUc0ami');

        $this->assertEquals('Test extension', $extension->getName());
        $this->assertEquals('https://www.example.com/cf-test-extension', $extension->getSource());
        $this->assertTrue($extension->isSidebar());
        $this->assertEquals([new FieldType('Integer')], $extension->getFieldTypes());

        $extensions = $client->extension->getAll();

        $this->assertCount(1, $extensions);
        $extension = $extensions[0];

        $this->assertEquals('Test extension', $extension->getName());
        $this->assertEquals('https://www.example.com/cf-test-extension', $extension->getSource());
        $this->assertTrue($extension->isSidebar());
        $this->assertEquals([new FieldType('Integer')], $extension->getFieldTypes());
    }

    /**
     * @vcr e2e_extension_create_update_delete.json
     */
    public function testCreateUpdateDelete()
    {
        $client = $this->getReadWriteClient();
        $extension = new Extension('My awesome extension');

        $source = '<!doctype html><html lang="en"><head><meta charset="UTF-8"/><title>Sample Editor Extension</title><link rel="stylesheet" href="https://contentful.github.io/ui-extensions-sdk/cf-extension.css"><script src="https://contentful.github.io/ui-extensions-sdk/cf-extension-api.js"></script></head><body><div id="content"></div><script>window.contentfulExtension.init(function (extension) {window.alert(extension);var value = extension.field.getValue();extension.field.setValue("Hello world!"");extension.field.onValueChanged(function(value) {if (value !== currentValue) {extension.field.setValue("Hello world!"");}});});</script></body></html>';

        $extension
            ->addFieldType(new FieldType('Symbol'))
            ->addFieldType(new FieldType('Array', ['Symbol']))
            ->addFieldType(new FieldType('Link', ['Entry']))
            ->setSource($source)
            ->setSidebar(false);

        $client->extension->create($extension);

        $this->assertNotNull($extension->getId());
        $this->assertSame('My awesome extension', $extension->getName());
        $this->assertEquals($source, $extension->getSource());
        $this->assertFalse($extension->isSidebar());
        $fieldTypes = $extension->getFieldTypes();
        $this->assertContainsOnlyInstancesOf(FieldType::class, $fieldTypes);
        $this->assertEquals([
            new FieldType('Symbol'),
            new FieldType('Array', ['Symbol']),
            new FieldType('Link', ['Entry']),
        ], $fieldTypes);

        $extension->setName('Maybe not-so-awesome extension');
        $extension->setSource('https://www.example.com/cf-ui-extension');
        $extension->setFieldTypes([
            new FieldType('Array', ['Link', 'Asset']),
        ]);
        $extension->update();

        $this->assertEquals('Maybe not-so-awesome extension', $extension->getName());
        $this->assertEquals('https://www.example.com/cf-ui-extension', $extension->getSource());
        $this->assertEquals([new FieldType('Array', ['Link', 'Asset'])], $extension->getFieldTypes());

        $extension->delete();
    }
}
