<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\SettingsBundle\Transformer;

use Miky\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer as BaseTransformer;
use Symfony\Component\PropertyAccess\PropertyAccess;


class ResourceToIdentifierTransformer extends BaseTransformer implements ParameterTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (!is_object($value)) {
            return null;
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        return $accessor->getValue($value, $this->identifier);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (empty($value)) {
            return null;
        }

        if ('id' === $this->identifier) {
            return $this->repository->find($value);
        }

        return $this->repository->findOneBy([$this->identifier => $value]);
    }
}
