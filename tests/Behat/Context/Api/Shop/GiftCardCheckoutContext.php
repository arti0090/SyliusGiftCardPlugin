<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Tests\Behat\Context\Api\Shop;

use Behat\Behat\Context\Context;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\RequestFactoryInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Sylius\Behat\Context\Api\Resources;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Symfony\Component\HttpFoundation\Request as HTTPRequest;
use Webmozart\Assert\Assert;

final class GiftCardCheckoutContext implements Context
{
    public function __construct(
        private ApiClientInterface $client,
        private RequestFactoryInterface $requestFactory,
        private ResponseCheckerInterface $responseChecker,
        private SharedStorageInterface $sharedStorage,
        private RepositoryInterface $paymentMethodRepository,
    ) {
    }

    /**
     * @When I proceed through checkout process for a gift card product
     */
    public function iProceedThroughCheckoutProcessForVirtualProduct(): void
    {
        $this->addressOrder($this->getArrayWithDefaultAddress());
        $cart = $this->getCart();

        if (!empty($cart['shipments'])) {
            $this->selectFirstShippingMethod($cart['shipments'][0]);
        }

        /** @var PaymentMethodInterface $paymentMethod */
        $paymentMethod = $this->paymentMethodRepository->findOneBy([]);
        Assert::notNull($paymentMethod, 'No payment method found in repository.');

        $this->selectPaymentMethod((string) $cart['payments'][0]['id'], $paymentMethod);
    }

    private function addressOrder(array $content): void
    {
        if (!array_key_exists('email', $content)) {
            $content['email'] = null;
        }

        $this->client->buildUpdateRequest(Resources::ORDERS, $this->getCartTokenValue());
        $this->client->setRequestData($content);
        $this->client->update();
    }

    private function getCartTokenValue(): ?string
    {
        if ($this->sharedStorage->has('cart_token')) {
            return $this->sharedStorage->get('cart_token');
        }

        if ($this->sharedStorage->has('previous_cart_token')) {
            return $this->sharedStorage->get('previous_cart_token');
        }

        return null;
    }

    private function getArrayWithDefaultAddress(): array
    {
        return [
            'email' => 'rich@sylius.com',
            'billingAddress' => [
                'city' => 'New York',
                'street' => 'Wall Street',
                'postcode' => '00-001',
                'countryCode' => 'US',
                'firstName' => 'Richy',
                'lastName' => 'Rich',
            ],
        ];
    }

    private function selectFirstShippingMethod(array $shippingMethodResponse): void
    {
        $request = $this->requestFactory->customItemAction(
            'shop',
            Resources::ORDERS,
            $this->sharedStorage->get('cart_token'),
            HTTPRequest::METHOD_PATCH,
            sprintf('shipments/%s', $shippingMethodResponse['id']),
        );
        $request->setContent(['shippingMethod' => $shippingMethodResponse['@id']]);

        $this->client->executeCustomRequest($request);
    }

    private function selectPaymentMethod(string $paymentId, PaymentMethodInterface $paymentMethod): void
    {
        $request = $this->requestFactory->customItemAction(
            'shop',
            Resources::ORDERS,
            $this->sharedStorage->get('cart_token'),
            HTTPRequest::METHOD_PATCH,
            sprintf('payments/%s', $paymentId),
        );
        $request->setContent(['paymentMethod' => $paymentMethod->getCode()]);

        $this->client->executeCustomRequest($request);
    }

    private function getCart(): array
    {
        $response = $this->client->show(Resources::ORDERS, $this->sharedStorage->get('cart_token'));

        return $this->responseChecker->getResponseContent($response);
    }
}
