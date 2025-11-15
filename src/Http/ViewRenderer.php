<?php

declare(strict_types=1);

namespace Pobj\Api\Http;

use Pobj\Api\Http\Helpers\ViewHelperRegistry;

class ViewRenderer
{
    private string $projectRoot;

    public function __construct(string $projectRoot)
    {
        $this->projectRoot = $projectRoot;
    }

    public function render(string $viewName, array $data = []): string
    {
        $viewPath = $this->projectRoot . '/resources/views/' . $viewName . '.html';
        
        if (!is_file($viewPath)) {
            throw new \RuntimeException("View não encontrada: {$viewName}");
        }

        $content = file_get_contents($viewPath);
        
        // Processa helpers/funções primeiro
        $content = $this->processHelpers($content, $data);
        
        // Processa includes de componentes e layouts
        $content = $this->processIncludes($content, $data);
        
        // Aplica substituições de caminhos para assets públicos
        $content = $this->processAssetPaths($content);
        
        // Aplica variáveis se houver
        $content = $this->replaceVariables($content, $data);
        
        return $content;
    }

    private function processHelpers(string $content, array $data): string
    {
        // Suporta @helper('nome') ou @helper('nome', 'arg1', 'arg2') ou @helper('nome', {{variavel}})
        $pattern = '/@helper\([\'"]([^\'"]+)[\'"](?:,\s*((?:[^)]|\([^)]*\))*))?\)/';
        
        return preg_replace_callback($pattern, function ($matches) use ($data) {
            $helperName = $matches[1];
            $argsString = trim($matches[2] ?? '');
            
            // Parse dos argumentos
            $args = [];
            if (!empty($argsString)) {
                // Tenta parsear como JSON array primeiro
                if (preg_match('/^\[.*\]$/', $argsString)) {
                    $parsed = json_decode($argsString, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $args = $parsed;
                    }
                } else {
                    // Parse manual de argumentos separados por vírgula
                    // Suporta strings com aspas simples ou duplas, e variáveis {{variavel}}
                    $rawArgs = [];
                    $currentArg = '';
                    $inQuotes = false;
                    $quoteChar = '';
                    
                    for ($i = 0; $i < strlen($argsString); $i++) {
                        $char = $argsString[$i];
                        
                        if (!$inQuotes && ($char === '"' || $char === "'")) {
                            $inQuotes = true;
                            $quoteChar = $char;
                            $currentArg .= $char;
                        } elseif ($inQuotes && $char === $quoteChar) {
                            $inQuotes = false;
                            $quoteChar = '';
                            $currentArg .= $char;
                        } elseif (!$inQuotes && $char === ',') {
                            $rawArgs[] = trim($currentArg);
                            $currentArg = '';
                        } else {
                            $currentArg .= $char;
                        }
                    }
                    if (!empty($currentArg)) {
                        $rawArgs[] = trim($currentArg);
                    }
                    
                    foreach ($rawArgs as $arg) {
                        $arg = trim($arg);
                        // Remove aspas externas
                        if ((str_starts_with($arg, '"') && str_ends_with($arg, '"')) ||
                            (str_starts_with($arg, "'") && str_ends_with($arg, "'"))) {
                            $arg = substr($arg, 1, -1);
                        }
                        
                        // Tenta converter variáveis da view {{variavel}}
                        if (preg_match('/^\{\{(\w+)\}\}$/', $arg, $varMatch)) {
                            $varName = $varMatch[1];
                            $args[] = $data[$varName] ?? null;
                        } elseif (is_numeric($arg)) {
                            // Converte números
                            $args[] = strpos($arg, '.') !== false ? (float) $arg : (int) $arg;
                        } elseif ($arg === 'true' || $arg === 'false') {
                            // Converte booleanos
                            $args[] = $arg === 'true';
                        } elseif ($arg === 'null') {
                            $args[] = null;
                        } else {
                            $args[] = $arg;
                        }
                    }
                }
            }
            
            try {
                $result = ViewHelperRegistry::call($helperName, ...$args);
                return is_string($result) ? $result : (string) $result;
            } catch (\RuntimeException $e) {
                return ''; // Retorna vazio se helper não existir
            }
        }, $content);
    }

    private function processIncludes(string $content, array $data): string
    {
        // Suporta @include('componente') ou @include('pasta/componente')
        $pattern = '/@include\([\'"]([^\'"]+)[\'"]\)/';
        
        return preg_replace_callback($pattern, function ($matches) use ($data) {
            $includeName = $matches[1];
            
            // Lista de diretórios para buscar (em ordem de prioridade)
            $searchPaths = [
                'layouts',
                'components/modals',
                'components/filters',
                'components/sections',
                'assets',
                'components', // Fallback para compatibilidade
            ];
            
            // Se já tem caminho explícito (ex: layouts/meta), usa diretamente
            if (strpos($includeName, '/') !== false) {
                $componentPath = $this->projectRoot . '/resources/views/' . $includeName . '.html';
                if (is_file($componentPath)) {
                    $includeContent = file_get_contents($componentPath);
                    return $this->processIncludes($includeContent, $data);
                }
            }
            
            // Busca em todas as pastas
            foreach ($searchPaths as $path) {
                $componentPath = $this->projectRoot . '/resources/views/' . $path . '/' . $includeName . '.html';
                if (is_file($componentPath)) {
                    $includeContent = file_get_contents($componentPath);
                    // Processa recursivamente includes dentro do componente
                    return $this->processIncludes($includeContent, $data);
                }
            }
            
            return ''; // Retorna vazio se não encontrar
        }, $content);
    }

    private function replaceVariables(string $content, array $data): string
    {
        foreach ($data as $key => $value) {
            $placeholder = '{{' . $key . '}}';
            
            if (is_array($value) || is_object($value)) {
                // Para arrays e objetos, converte para JSON
                $replacement = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            } elseif (is_bool($value)) {
                $replacement = $value ? 'true' : 'false';
            } elseif (is_null($value)) {
                $replacement = '';
            } else {
                $replacement = htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
            }
            
            $content = str_replace($placeholder, $replacement, $content);
        }
        
        return $content;
    }

    public function exists(string $viewName): bool
    {
        $viewPath = $this->projectRoot . '/resources/views/' . $viewName . '.html';
        return is_file($viewPath);
    }

    private function processAssetPaths(string $content): string
    {
        $replacements = [
            // Arquivos JS na raiz -> public/js/
            '/(href|src)="(?!public\/|https?:\/\/)((?:script|leads|omega)\.js)"/' => '$1="public/js/$2"',
            // Arquivos CSS na raiz -> public/css/
            '/(href|src)="(?!public\/|https?:\/\/)((?:style|leads|omega)\.css)"/' => '$1="public/css/$2"',
            // Imagens -> public/img/
            '/(href|src)="(?!public\/|https?:\/\/)(img\/[^"]+)"/' => '$1="public/$2"',
        ];
        
        return preg_replace(
            array_keys($replacements),
            array_values($replacements),
            $content
        );
    }
}

