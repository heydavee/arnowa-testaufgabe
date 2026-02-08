<?php

declare(strict_types=1);

namespace ArnowaProductComplianceInfo\Core\Content\ProductComplianceInfo;

use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class ProductComplianceInfoEntity extends Entity
{
  use EntityIdTrait;

  protected string $productId;
  protected bool $complianceRequired = false;
  protected ?string $complianceText = null;
  protected ?ProductEntity $product = null;
}
