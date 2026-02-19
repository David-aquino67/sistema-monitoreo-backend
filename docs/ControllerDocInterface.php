<?php

namespace Docs;
use OpenApi\Attributes as OA;

#[
	OA\Info(
		version: '1.0.0',
		title: 'MOCACI API'
	),
	OA\Server(
		url: '/',
		description: 'API Server'
	),
	OA\SecurityScheme(
		securityScheme: 'bearerAuth',
		type: 'http',
		scheme: 'bearer',
		bearerFormat: 'JWT'
	),
]
interface ControllerDocInterface
{
}