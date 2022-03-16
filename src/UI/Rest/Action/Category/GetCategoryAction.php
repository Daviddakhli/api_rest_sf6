<?php

declare(strict_types=1);

namespace App\UI\Rest\Action\Category;

use App\Domain\Entity\Category;
use App\UI\Rest\DTO\CategoryDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class GetCategoryAction
{
    public function __construct(
        private readonly SerializerInterface $serializer
    )
    {
    }

    #[ParamConverter(
        'category',
        class: Category::class,
        options: ['id' => 'categoryId', 'repository_method' => 'findById']
    )]
    public function __invoke(Category $category): JsonResponse
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(CategoryDTO::fromCategory($category), JsonEncoder::FORMAT)
        );
    }
}