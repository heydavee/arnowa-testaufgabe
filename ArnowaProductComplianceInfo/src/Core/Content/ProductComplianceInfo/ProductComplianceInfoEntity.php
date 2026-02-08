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
  protected string $productVersionId;
  protected bool $complianceRequired = false;
  protected ?string $complianceText = null;
  protected ?ProductEntity $product = null;

  public function getProductId(): string
  {
    return $this->productId;
  }

  public function setProductId(string $productId): void
  {
    $this->productId = $productId;
  }

  public function getProductVersionId(): string
  {
    return $this->productVersionId;
  }

  public function setProductVersionId(string $productVersionId): void
  {
    $this->productVersionId = $productVersionId;
  }

  public function getComplianceRequired(): bool
  {
    return $this->complianceRequired;
  }

  public function setComplianceRequired(bool $complianceRequired): void
  {
    $this->complianceRequired = $complianceRequired;
  }

  public function getComplianceText(): ?string
  {
    return $this->complianceText;
  }

  public function setComplianceText(?string $complianceText): void
  {
    $this->complianceText = $complianceText;
  }

  public function getProduct(): ?ProductEntity
  {
    return $this->product;
  }

  public function setProduct(?ProductEntity $product): void
  {
    $this->product = $product;
  }
}
