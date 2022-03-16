<?php

declare(strict_types=1);

namespace App\Infra\Request\ParamConverter;

namespace App\Infrastructure\Request\ParamConverter;

use App\Domain\Entity\Category;
use App\Domain\Exception\Category\CategoryNotFoundException;
use App\Domain\Exception\InvalidArgumentException;
use App\Domain\Repository\CategoryRepository;
use App\UI\Rest\Exception\RestException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

class CategoryConverter implements ParamConverterInterface
{
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $options = $configuration->getOptions();
        $repositoryMethod = $options['repository_method'] ?? 'findById';
        if (!method_exists($this->categoryRepository, $repositoryMethod)) {
            throw new InvalidArgumentException(sprintf(
                'Method "%s" does not exists in "%s"',
                $repositoryMethod,
                $this->categoryRepository::class
            ));
        }

        try {
            $categoryId = $request->attributes->get(
                'id',
                $request->attributes->get($configuration->getOptions()['id'])
            );
            $categoryId = \is_string($categoryId) ? (int)$categoryId : $categoryId;
            Assert::integer($categoryId);
            $category = $this->categoryRepository->$repositoryMethod($categoryId);
        } catch (CategoryNotFoundException $exception) {
            throw RestException::fromDomainException($exception, Response::HTTP_NOT_FOUND);
        }

        $request->attributes->set($configuration->getName(), $category);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return Category::class === $configuration->getClass();
    }
}
