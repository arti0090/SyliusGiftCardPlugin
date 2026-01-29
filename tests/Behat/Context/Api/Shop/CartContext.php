<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Tests\Behat\Context\Api\Shop;

use ApiPlatform\Api\IriConverterInterface;
use Behat\Behat\Context\Context;
use Setono\SyliusGiftCardPlugin\Model\ProductInterface;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\RequestFactoryInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Sylius\Behat\Context\Api\Resources;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Product\Resolver\ProductVariantResolverInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

final class CartContext implements Context
{
    public function __construct(
        private ApiClientInterface $cartsClient,
        private ResponseCheckerInterface $responseChecker,
        private SharedStorageInterface $sharedStorage,
        private ProductVariantResolverInterface $productVariantResolver,
        private RequestFactoryInterface $requestFactory,
        private IriConverterInterface $iriConverter,
    ) {
    }

    /**
     * @When /^I add (this product) to the cart with amount ("[^"]+") and custom message "([^"]+)"$/
     */
    public function iAddProductWithAmountAndMessage(ProductInterface $product, int $amount, string $message): void
    {
        $tokenValue = $this->sharedStorage->has('cart_token') ?
            $this->sharedStorage->get('cart_token') :
            $this->pickupCart();

        $request = $this->requestFactory->customItemAction(
            'shop',
            Resources::ORDERS,
            $tokenValue,
            HttpRequest::METHOD_POST,
            'items',
        );

        $variant = $this->productVariantResolver->getVariant($product);

        $request->updateContent([
            'productVariant' => $this->iriConverter->getIriFromResource($variant),
            'quantity' => 1,
            'amount' => $amount,
            'customMessage' => $message,
        ]);

        $this->cartsClient->executeCustomRequest($request);
    }

    private function pickupCart(): string
    {
        $this->cartsClient->buildCreateRequest(Resources::ORDERS);
        $this->cartsClient->addRequestData('localeCode', null);

        $tokenValue = $this->responseChecker->getValue($this->cartsClient->create(), 'tokenValue');

        $this->sharedStorage->set('cart_token', $tokenValue);

        return $tokenValue;
    }
}
