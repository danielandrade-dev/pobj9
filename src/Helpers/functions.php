<?php

declare(strict_types=1);

namespace Pobj\Api\Helpers;

/**
 * Função helper global para compatibilidade com código legado
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function pobj_env(string $key, $default = null)
{
    return EnvHelper::get($key, $default);
}

