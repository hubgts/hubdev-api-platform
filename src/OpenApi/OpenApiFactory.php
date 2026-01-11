<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Info;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\OpenApi;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\HttpFoundation\Response;

#[AsDecorator(decorates: 'api_platform.openapi.factory')]
final class OpenApiFactory implements OpenApiFactoryInterface
{
    public function __construct(private OpenApiFactoryInterface $decorated)
    {
    }

    /**
     * @param array<mixed> $context
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);

        $openApi->getPaths()->addPath(
            '/mangas',
            new PathItem(
                get: new Operation(
                    operationId: 'getMangas',
                    tags: ['Manga'],
                    responses: [
                        Response::HTTP_OK => [
                            'description' => 'List of mangas',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'id' => [
                                                    'type' => 'integer',
                                                    'example' => 1,
                                                ],
                                                'title' => [
                                                    'type' => 'string',
                                                    'example' => 'One Piece',
                                                ],
                                                'author' => [
                                                    'type' => 'string',
                                                    'example' => 'Eiichiro Oda',
                                                ],
                                                'volumes' => [
                                                    'type' => 'integer',
                                                    'example' => 107,
                                                ],
                                                'published' => [
                                                    'type' => 'boolean',
                                                    'example' => true,
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    summary: 'Retrieve a list of mangas',
                    description: 'Returns a list of mangas with basic information'
                )
            )
        );

        return $openApi;
    }
}
