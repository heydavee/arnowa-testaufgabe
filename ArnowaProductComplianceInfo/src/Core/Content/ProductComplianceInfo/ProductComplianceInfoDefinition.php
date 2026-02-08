<?php

declare(strict_types=1);

namespace ArnowaProductComplianceInfo\Core\Content\ProductComplianceInfo;

use Shopware\Core\Content\Product\ProductDefinition;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\LongTextField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class ProductComplianceInfoDefinition extends EntityDefinition
{

  public const ENTITY_NAME = 'arnowa_product_compliance_info';

  public function getEntityName(): string
  {
    return self::ENTITY_NAME;
  }

  public function getEntityClass(): string
  {
    return ProductComplianceInfoEntity::class;
  }

  public function getCollectionClass(): string
  {
    return ProductComplianceInfoCollection::class;
  }

  protected function defineFields(): FieldCollection
  {
    return new FieldCollection([
      (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
      (new FkField('product_id', 'productId', ProductDefinition::class))->addFlags(new Required()),
      (new ReferenceVersionField(ProductDefinition::class, 'product_version_id'))->addFlags(new Required()),
      new BoolField('compliance_required', 'complianceRequired'),
      new LongTextField('compliance_text', 'complianceText'),
      new OneToOneAssociationField('product', 'product_id', 'id', ProductDefinition::class, false),
    ]);
  }
}
