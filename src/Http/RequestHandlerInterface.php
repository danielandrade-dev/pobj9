<?php

declare(strict_types=1);

namespace Pobj\Api\Http;

interface RequestHandlerInterface
{
    public function handle(string $projectRoot): void;
}

