<?php

declare(strict_types=1);

namespace ArnowaProductComplianceInfo\Extension;

use ArnowaProductComplianceInfo\Core\Content\ProductComplianceInfo\ProductComplianceInfoDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class ProductExtension extends EntityExtension
{

  public function extendFields(FieldCollection $collection): void
  {
    $collection->add(
      new OneToOneAssociationField(
        'complianceInfo',
        'id',
        'product_id',
        ProductComplianceInfoDefinition::class,
        false
      )
    );
  }

  public function getDefinitionClass(): string
  {
    return ProductDefinition::class;
  }
}
