<?php

declare(strict_types=1);

namespace App\UI\Rest\Action\Product;

use App\Application\Command\Product\GetProductDetailsCommandHandler;
use App\Domain\Entity\Category;
use App\Domain\Exception\InfraExceptionInterface;
use App\Domain\Exception\Product\ProductNotFoundException;
use App\UI\Rest\DTO\ProductDTO;
use App\UI\Rest\Exception\RestException;
use App\UI\Rest\Exception\ServerErrorException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class GetProductsAction
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly GetProductDetailsCommandHandler $queryHandler
    )
    {
    }

    /**
     * @throws ServerErrorException
     * @throws RestException
     */
    #[ParamConverter(
        'category',
        class: Category::class,
        options: ['id' => 'categoryId', 'repository_method' => 'findById']
    )]
    public function __invoke(Category $category): JsonResponse
    {
        try {
            $products = $this->queryHandler->handle($category);
        } catch (ProductNotFoundException $notFoundException) {
            throw RestException::fromDomainException($notFoundException, Response::HTTP_NOT_FOUND);
        } catch (InfraExceptionInterface $exception) {
            throw ServerErrorException::fromInfraException($exception);
        }

        return JsonResponse::fromJsonString(
            $this->serializer->serialize(ProductDTO::fromProduct($products), JsonEncoder::FORMAT)
        );
    }
}