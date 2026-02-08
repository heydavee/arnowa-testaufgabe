<?php

namespace ArnowaProductComplianceInfo\Subscriber\Storefront;

use ArnowaProductComplianceInfo\Core\Content\ProductComplianceInfo\ProductComplianceInfoEntity;
use Shopware\Core\Framework\Struct\ArrayStruct;
use Shopware\Storefront\Page\Product\ProductPageCriteriaEvent;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductPageLoadedSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ProductPageCriteriaEvent::class => 'onProductPageCriteria',
            ProductPageLoadedEvent::class => 'onProductPageLoaded',
        ];
    }

    public function onProductPageCriteria(ProductPageCriteriaEvent $event): void
    {
        $event->getCriteria()->addAssociation('complianceInfo');
    }

    public function onProductPageLoaded(ProductPageLoadedEvent $event): void
    {
        $complianceInfo = $event->getPage()->getProduct()->getExtension('complianceInfo');

        if (!$complianceInfo instanceof ProductComplianceInfoEntity || !$complianceInfo->getComplianceRequired()) {
            return;
        }

        $complianceText = trim((string) $complianceInfo->getComplianceText());

        if ($complianceText === '') {
            return;
        }

        $event->getPage()->addExtension(
            'arnowaComplianceInfo',
            new ArrayStruct([
                'text' => $complianceText,
            ])
        );
    }
}
