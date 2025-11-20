<?php

declare(strict_types=1);

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\CliDumper;

if (!function_exists('dd')) {
    /**
     * Dump and die - exibe variáveis e para a execução
     * Visual idêntico ao Laravel usando Symfony VarDumper
     * 
     * @param mixed ...$vars Variáveis para exibir
     */
    function dd(...$vars): void
    {
        $isCli = php_sapi_name() === 'cli';
        
        // Limpa qualquer output buffer ANTES de qualquer coisa
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        // Se não for CLI, tenta definir o header correto
        if (!$isCli) {
            // Tenta remover o header JSON se ainda não foi enviado
            if (!headers_sent()) {
                header_remove('Content-Type');
                header('Content-Type: text/html; charset=utf-8', true);
            } else {
                // Se o header já foi enviado, força o HTML mesmo assim
                // O navegador ainda vai renderizar o HTML corretamente
                header('Content-Type: text/html; charset=utf-8', true);
            }
        }
        
        // Configura o dumper apropriado
        if ($isCli) {
            $dumper = new CliDumper();
        } else {
            $dumper = new HtmlDumper();
            // Usa o tema padrão do Laravel (escuro)
        }
        
        $cloner = new VarCloner();
        
        // Exibe cada variável
        foreach ($vars as $var) {
            $dumper->dump($cloner->cloneVar($var));
        }
        
        // Força o envio imediato do output
        if (ob_get_level() > 0) {
            ob_end_flush();
        }
        flush();
        
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
        
        // Para a execução imediatamente - sem chance de continuar
        // Usa exit com código 1 para garantir que pare completamente
        exit(1);
    }
}

