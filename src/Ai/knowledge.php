<?php
declare(strict_types=1);

use Pobj\Api\Ai\KnowledgeHelper;

/**
 * RAG simples para o POBJ.
 * - Varre docs/knowledge/ por .txt, .pdf, .csv, .json
 * - Converte conteúdo em texto (PDF via 'pdftotext' se disponível)
 * - Quebra em chunks, gera embeddings (OpenAI), salva índice JSON
 * - Recupera top-K trechos por similaridade cosseno
 *
 * Este arquivo mantém funções globais para compatibilidade com código legado.
 * Novas implementações devem usar KnowledgeHelper diretamente.
 */

function ai_env(string $key, ?string $default = null): ?string
{
    return KnowledgeHelper::env($key, $default);
}

function ai_http_post_json(string $url, array $headers, array $payload): array
{
    return KnowledgeHelper::httpPostJson($url, $headers, $payload);
}

/* ---------- Conversores de arquivo -> texto ---------- */

function ai_has_pdftotext(): bool
{
    return KnowledgeHelper::hasPdfToText();
}

function ai_pdf_to_text(string $path): string
{
    return KnowledgeHelper::pdfToText($path);
}

function ai_csv_to_text(string $path): string
{
    return KnowledgeHelper::csvToText($path);
}

function ai_json_to_text(string $path): string
{
    return KnowledgeHelper::jsonToText($path);
}

function ai_txt_to_text(string $path): string
{
    return KnowledgeHelper::txtToText($path);
}

function ai_file_to_text(string $path): string
{
    return KnowledgeHelper::fileToText($path);
}

function ai_scan_knowledge(string $dir): array
{
    return KnowledgeHelper::scanKnowledge($dir);
}

/* ---------- Chunking / Embeddings / Index ---------- */

function ai_chunk_text(string $text, int $chunkSize = 1600, int $overlap = 200): array
{
    return KnowledgeHelper::chunkText($text, $chunkSize, $overlap);
}

function ai_embed(array $texts): array
{
    return KnowledgeHelper::embed($texts);
}

function ai_build_or_load_index(string $dir, string $indexPath): array {
    $files = ai_scan_knowledge($dir);
    $sig = [];
    foreach ($files as $f) $sig[$f['path']] = $f['mtime'];

    // Carrega índice existente se assinatura confere
    if (is_file($indexPath)) {
        $idx = json_decode((string)file_get_contents($indexPath), true);
        if (is_array($idx) && ($idx['signature'] ?? null) === $sig) return $idx;
    }

    // (Re)constrói índice
    $items = [];  // cada item = ['source'=>path, 'name'=>name, 'chunk_id'=>X, 'text'=>...]
    foreach ($files as $f) {
        $chunks = ai_chunk_text($f['text']);
        foreach ($chunks as $c) {
            $items[] = [
                'source'   => $f['path'],
                'name'     => $f['name'],
                'chunk_id' => $c['id'],
                'text'     => $c['text'],
            ];
        }
    }
    if (empty($items)) {
        $idx = ['items'=>[], 'embeddings'=>[], 'signature'=>$sig, 'built_at'=>time()];
        @file_put_contents($indexPath, json_encode($idx, JSON_UNESCAPED_UNICODE));
        return $idx;
    }

    $inputs = [];
    foreach ($items as $i) {
        $inputs[] = $i['text'];
    }
    $emb    = ai_embed($inputs);

    $idx = ['items'=>$items, 'embeddings'=>$emb, 'signature'=>$sig, 'built_at'=>time()];
    @file_put_contents($indexPath, json_encode($idx, JSON_UNESCAPED_UNICODE));
    return $idx;
}

function ai_cosine(array $a, array $b): float
{
    return KnowledgeHelper::cosine($a, $b);
}

function ai_retrieve_topk(string $query, array $index, int $k=6): array {
    if ($query==='' || empty($index['items'])) return [];
    $qEmbeds = ai_embed([$query]);
    $q = isset($qEmbeds[0]) ? $qEmbeds[0] : [];
    $scored = [];
    foreach ($index['items'] as $i=>$it) {
        $e = isset($index['embeddings'][$i]) ? $index['embeddings'][$i] : null;
        if (!is_array($e)) continue;
        $scored[] = [
            'score'=>ai_cosine($q,$e),
            'source'=>$it['source'],
            'name'=>$it['name'],
            'chunk_id'=>$it['chunk_id'],
            'text'=>$it['text']
        ];
    }
    usort($scored, function($a,$b){ return ($a['score']<$b['score']) ? 1 : -1; });
    return array_slice($scored, 0, max(1,$k));
}
