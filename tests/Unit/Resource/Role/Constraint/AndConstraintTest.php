<?php

/**
 * This file is part of the contentful-management.php package.
 *
 * @copyright 2015-2017 Contentful GmbH
 * @license   MIT
 */
declare(strict_types=1);

namespace Contentful\Tests\Unit\Management\Resource\Role\Constraint;

use Contentful\Management\Resource\Role\Constraint\AndConstraint;
use PHPUnit\Framework\TestCase;

class AndConstraintTest extends TestCase
{
    public function testGetSetData()
    {
        $constraint = new AndConstraint();
        $child = new AndConstraint();
        $constraint->setChildren([$child]);
        $this->assertSame([$child], $constraint->getChildren());

        try {
            $constraint->setChildren(['invalid']);
            $this->fail('Invalid child should throw an exception.');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Argument "$children" of "Contentful\Management\Resource\Role\Constraint\AndConstraint::setChildren()" must be an array of "ConstraintInterface" objects.', $e->getMessage());
        }

        $constraint->clearChildren();
        $this->assertEquals([], $constraint->getChildren());

        $constraint->addChild($child);
        $this->assertSame([$child], $constraint->getChildren());
    }

    public function testJsonSerialize()
    {
        $constraint = new AndConstraint([new AndConstraint()]);

        $json = '{"and":[{"and":[]}]}';
        $this->assertJsonStringEqualsJsonString($json, json_encode($constraint));
    }
}
