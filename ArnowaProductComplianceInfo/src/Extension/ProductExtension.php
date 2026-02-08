<?php

declare(strict_types=1);

namespace ArnowaProductComplianceInfo\Extension;

use ArnowaProductComplianceInfo\Core\Content\ProductComplianceInfo\ProductComplianceInfoDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Write\EntityExistence;

class ProductExtension extends EntityExistence
{

  public function extendFields(FieldCollection $collection): void
  {
    $collection->add(
      new OneToOneAssociationField(
        'arnowa_product_compliance_info',
        'id',
        'arnowa_product_compliance_info_id',
        ProductComplianceInfoDefinition::class
      )
    );
  }

  public function getDefinitionClass(): string
  {
    return ProductDefinition::class;
  }
}
