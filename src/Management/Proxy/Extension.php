<?php

/**
 * This file is part of the contentful-management.php package.
 *
 * @copyright 2015-2017 Contentful GmbH
 * @license   MIT
 */

namespace Contentful\Management\Proxy;

use Contentful\Management\Resource\Extension as ResourceClass;
use Contentful\ResourceArray;

/**
 * Extension class.
 *
 * This class is used as a proxy for doing operations related to locales.
 *
 * @method ResourceInterface create(\Contentful\Management\Resource\Extension $resource, string $resourceId = null)
 * @method ResourceInterface update(\Contentful\Management\Resource\Extension $resource)
 * @method ResourceInterface delete(\Contentful\Management\Resource\Extension|string $resource, int $version = null)
 */
class Extension extends BaseProxy
{
    /**
     * {@inheritdoc}
     */
    public function getResourceUri(array $values): string
    {
        return \rtrim(\strtr('spaces/'.$this->spaceId.'/extensions/{resourceId}', $values), '/');
    }

    /**
     * {@inheritdoc}
     */
    public function getEnabledMethods(): array
    {
        return ['create', 'update', 'delete'];
    }

    /**
     * Returns an Extension object which corresponds to the given resource ID in Contentful.
     *
     * @param string $resourceId
     *
     * @return ResourceClass
     *
     * @see https://www.contentful.com/developers/docs/references/content-management-api/#/reference/ui-extensions/extension
     */
    public function get(string $resourceId): ResourceClass
    {
        return $this->getResource([
            '{resourceId}' => $resourceId,
        ]);
    }

    /**
     * Returns a ResourceArray object containing Extension objects.
     *
     * @return ResourceArray
     *
     * @see https://www.contentful.com/developers/docs/references/content-management-api/#/reference/ui-extensions/extensions-collection
     */
    public function getAll(): ResourceArray
    {
        return $this->getResource([
            '{resourceId}' => '',
        ]);
    }
}
