<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureMiddleware(MiddlewareBuilder $middleware): void
    {
        $redisClient = RedisAdapter::createConnection('redis://localhost');
        $cache = new RedisAdapter($redisClient);

        $middleware->prepend(new IdempotencyMiddleware($middleware->getKernel(), $cache));

        // Остальные middleware...
    }
}
