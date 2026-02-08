<?php

declare(strict_types=1);

namespace ArnowaProductComplianceInfo\Core\Content\ProductComplianceInfo;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

class ProductComplianceInfoCollection extends EntityCollection
{
  protected function getExpectedClass(): string
  {
    return ProductComplianceInfoEntity::class;
  }
}
