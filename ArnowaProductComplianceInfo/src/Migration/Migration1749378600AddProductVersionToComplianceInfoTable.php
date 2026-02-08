<?php

declare(strict_types=1);

namespace ArnowaProductComplianceInfo\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1749378600AddProductVersionToComplianceInfoTable extends MigrationStep
{
  public function getCreationTimestamp(): int
  {
    return 1749378600;
  }

  public function update(Connection $connection): void
  {
    $connection->executeStatement('
      ALTER TABLE `arnowa_product_compliance_info`
      ADD `product_version_id` BINARY(16) NULL AFTER `product_id`;
    ');

    $connection->executeStatement('
      UPDATE `arnowa_product_compliance_info`
      SET `product_version_id` = UNHEX(\'0fa91ce3e96a4bc2be4bd9ce752c3425\')
      WHERE `product_version_id` IS NULL;
    ');

    $connection->executeStatement('
      ALTER TABLE `arnowa_product_compliance_info`
      MODIFY `product_version_id` BINARY(16) NOT NULL;
    ');

    $connection->executeStatement('
      ALTER TABLE `arnowa_product_compliance_info`
      DROP FOREIGN KEY `fk.arnowa_product_compliance_info.product_id`;
    ');

    $connection->executeStatement('
      ALTER TABLE `arnowa_product_compliance_info`
      DROP INDEX `uniq.product_id`;
    ');

    $connection->executeStatement('
      ALTER TABLE `arnowa_product_compliance_info`
      ADD CONSTRAINT `uniq.product_id_version_id`
      UNIQUE (`product_id`, `product_version_id`);
    ');

    $connection->executeStatement('
      ALTER TABLE `arnowa_product_compliance_info`
      ADD CONSTRAINT `fk.arnowa_product_compliance_info.product_id`
      FOREIGN KEY (`product_id`, `product_version_id`)
      REFERENCES `product` (`id`, `version_id`)
      ON DELETE CASCADE ON UPDATE CASCADE;
    ');
  }

  public function updateDestructive(Connection $connection): void {}
}
