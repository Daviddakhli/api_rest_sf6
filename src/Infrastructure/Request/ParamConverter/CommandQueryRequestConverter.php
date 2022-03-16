<?php

declare(strict_types=1);

namespace App\Infrastructure\Request\ParamConverter;

use App\Application\Command\Command;
use App\Domain\Exception\InvalidArgumentException;
use App\Utils\Exception\ConstraintViolationException;
use App\Utils\Validation\Validator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface as SerializerException;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class CommandQueryRequestConverter implements ParamConverterInterface
{
    private readonly OptionsResolver $optionResolver;

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly Validator $validator
    )
    {
        $this->optionResolver = new OptionsResolver();
    }

    /**
     * Stores the object in the request.
     *
     * @return bool True if the object has been successfully set, else false
     * @throws BadRequestHttpException
     *
     * @throws ConstraintViolationException|\JsonException
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $className = $configuration->getClass();
        $this->configureOptions($this->optionResolver);
        $configuration->setOptions($this->optionResolver->resolve($configuration->getOptions()));
        $serializationOptions = $this->getSerializationOptions($request, $configuration);
        $content = $request->getContent();
        $query = $request->query->all();

        if (empty($content) && empty($query) && empty($serializationOptions['default_constructor_arguments'])) {
            throw new BadRequestHttpException('Unable to extract request information, request is empty');
        }

        try {
            /** @var Command $object */
            $object = $this->serializer->deserialize(
                empty($content) ? json_encode($query, \JSON_THROW_ON_ERROR) : $content,
                $className,
                JsonEncoder::FORMAT,
                $serializationOptions
            );

            $this->validator->validate($object);
        } catch (ExtraAttributesException|\InvalidArgumentException|InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        } catch (SerializerException $e) {
            throw new BadRequestHttpException('Unable to extract request information, please check your payload and the type of the values provided', $e);
        }

        $request->attributes->set($configuration->getName(), $object);

        return true;
    }

    /**
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        return is_a($configuration->getClass(), Command::class, true);
    }

    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'allow_extra_attributes' => false,
                'default_constructor_arguments' => [],
            ]
        );
    }

    private function getSerializationOptions(Request $request, ParamConverter $configuration): array
    {
        $converterOptions = $configuration->getOptions();
        $serializationOptions = [
            'allow_extra_attributes' => $converterOptions['allow_extra_attributes'],
        ];

        if (0 === \count($converterOptions['default_constructor_arguments'])) {
            return $serializationOptions;
        }

        foreach ($converterOptions['default_constructor_arguments'] as $argumentName => $queryParameter) {
            $argumentName = is_numeric($argumentName) ? $queryParameter : $argumentName;
            if (!$request->attributes->has($queryParameter)) {
                throw new \InvalidArgumentException(sprintf('Could not find the "%s" argument in the request in order to construct the "%s" object', $queryParameter, $configuration->getClass()));
            }

            $serializationOptions[AbstractNormalizer::DEFAULT_CONSTRUCTOR_ARGUMENTS][$configuration->getClass()][$argumentName] = $request->attributes->get($queryParameter);
        }

        return $serializationOptions;
    }
}
