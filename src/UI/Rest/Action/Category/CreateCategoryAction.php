<?php

declare(strict_types=1);

namespace App\UI\Rest\Action\Category;

use App\Application\Command\Category\CreateCategoryCommand;
use App\Application\Command\Category\CreateCategoryCommandHandler;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\InfraExceptionInterface;
use App\Domain\Exception\InvalidArgumentException;
use App\Infrastructure\Exception\ApiResponseProblem;
use App\UI\Rest\DTO\SavedCategoryDTO;
use App\UI\Rest\Exception\RestException;
use App\UI\Rest\Exception\ServerErrorException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class CreateCategoryAction
{
    public function __construct(
        private readonly CreateCategoryCommandHandler $handler,
        private readonly SerializerInterface $serializer
    )
    {
    }

    /**
     * @throws RestException|InfraExceptionInterface
     */
    public function __invoke(CreateCategoryCommand $command): JsonResponse
    {
        try {
            $category = $this->handler->handle($command);
        } catch (InvalidArgumentException $e) {
            throw new RestException($e->getMessage(), Response::HTTP_BAD_REQUEST, [], [], $e);
        } catch (ApiResponseProblem $e) {
            throw new RestException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, [], [], $e->getPrevious());
        } catch (DomainException $e) {
            throw RestException::fromDomainException($e, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            throw ServerErrorException::fromThrowable($e);
        }

        return JsonResponse::fromJsonString(
            $this->serializer->serialize(SavedCategoryDTO::fromSavedCategory($category), JsonEncoder::FORMAT),
            Response::HTTP_CREATED
        );
    }
}