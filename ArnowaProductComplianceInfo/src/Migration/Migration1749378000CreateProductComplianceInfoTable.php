<?php

declare(strict_types=1);

namespace ArnowaProductComplianceInfo\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1749378000CreateProductComplianceInfoTable extends MigrationStep
{
  public function getCreationTimestamp(): int
  {
    return 1749378000;
  }

  public function update(Connection $connection): void
  {
    $connection->executeStatement('
            CREATE TABLE IF NOT EXISTS `arnowa_product_compliance_info` (
                `id` BINARY(16) NOT NULL,
                `product_id` BINARY(16) NOT NULL,
                `compliance_required` TINYINT(1) NOT NULL DEFAULT 0,
                `compliance_text` LONGTEXT NULL,
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq.product_id` (`product_id`),
                CONSTRAINT `fk.arnowa_product_compliance_info.product_id`
                    FOREIGN KEY (`product_id`)
                    REFERENCES `product` (`id`)
                    ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
  }

  public function updateDestructive(Connection $connection): void {}
}
