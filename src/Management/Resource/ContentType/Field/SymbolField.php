<?php

/**
 * This file is part of the contentful-management.php package.
 *
 * @copyright 2015-2017 Contentful GmbH
 * @license   MIT
 */

namespace Contentful\Management\Resource\ContentType\Field;

/**
 * SymbolField class.
 */
class SymbolField extends BaseField
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return 'Symbol';
    }
}
