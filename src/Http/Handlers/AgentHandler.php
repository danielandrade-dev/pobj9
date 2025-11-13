<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Handlers;

use Pobj\Api\Ai\KnowledgeHelper;
use Pobj\Api\Response\ResponseHelper;

class AgentHandler
{
    public function handle(array $payload): void
    {
        $question = trim((string) ($payload['question'] ?? ''));
        if ($question === '') {
            ResponseHelper::error('Campo "question" é obrigatório.', 422);
        }

        try {
            $apiKey = KnowledgeHelper::env('OPENAI_API_KEY', '');
            if ($apiKey === '') {
                ResponseHelper::error('OPENAI_API_KEY não configurada', 500);
            }
            $model = KnowledgeHelper::env('OPENAI_MODEL', 'gpt-5-mini');

            $dir = __DIR__ . '/../../../../docs/knowledge';
            $indexPath = __DIR__ . '/../../../../docs/knowledge.index.json';
            $index = KnowledgeHelper::buildOrLoadIndex($dir, $indexPath);

            $top = KnowledgeHelper::retrieveTopK($question, $index, 6);
            $context = '';
            $sources = [];
            foreach ($top as $i => $hit) {
                $n = $i + 1;
                $context .= "[$n] (" . $hit['name'] . " #" . $hit['chunk_id'] . ")\n" . $hit['text'] . "\n\n";
                $sources[] = [
                    'rank' => $n,
                    'file' => $hit['name'],
                    'path' => $hit['source'],
                    'chunk' => $hit['chunk_id'],
                    'score' => round($hit['score'], 4),
                ];
            }
            if ($context === '') {
                $context = "Nenhum documento disponível em docs/knowledge.";
            }

            $userName = '';
            if (!empty($payload['user_name'])) {
                $parts = preg_split('/\s+/', trim((string) $payload['user_name']));
                $userName = $parts ? $parts[0] : '';
            }

            $system = <<<SYS
Você é o **Assistente POBJ & Campanhas** para agências no Brasil.
REGRAS OBRIGATÓRIAS:
1) ESCOPO FECHADO: responda **somente** com base no conteúdo dos manuais do **POBJ** e de **Campanhas** fornecidos no *Contexto*. 
   • Se a pergunta estiver fora do escopo ou o contexto não trouxer evidência suficiente, responda **em 1 linha**:
     "Posso ajudar apenas com o POBJ e as Campanhas. Isso não está no manual. 🙂"
2) ESTILO: seja **direto ao ponto**, **nada verboso**. No máximo **2–3 frases curtas** ou **até 3 bullets** (curtos).
   • Tom simpático e animado; use **1 emoji** pertinente (no início ou fim). Evite vários emojis.
3) CITAÇÕES: quando afirmar uma regra/dado, referencie o trecho como **[arquivo #chunk]** quando isso ajudar.
4) AMBIGUIDADE: se faltar um detalhe essencial, faça **no máximo 1** pergunta de esclarecimento em 1 linha.
5) PERSONALIZAÇÃO: se for informado "Usuário: NOME", **cumprimente pelo primeiro nome** no início (ex.: "Oi, Ana!").
6) Português do Brasil, claro e profissional.
SYS;

            $saud = $userName ? "Usuário: {$userName}" : "Usuário: (não informado)";
            $user = "{$saud}\n" .
                "Pergunta: {$question}\n\n" .
                "Contexto (trechos recuperados dos manuais):\n{$context}";

            $supportsTemp = !preg_match('/\b(gpt-5-mini|gpt-5-nano)\b/i', $model);
            $payloadOpenAI = [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => $system],
                    ['role' => 'user', 'content' => $user],
                ],
            ];
            if ($supportsTemp) {
                $payloadOpenAI['temperature'] = 0.2;
            }

            $resp = KnowledgeHelper::httpPostJson(
                'https://api.openai.com/v1/chat/completions',
                ['Authorization: Bearer ' . $apiKey],
                $payloadOpenAI
            );

            $answer = trim((string) ($resp['choices'][0]['message']['content'] ?? ''));

            ResponseHelper::json([
                'answer' => $answer,
                'sources' => $sources,
                'model' => $model,
            ]);
        } catch (\Throwable $err) {
            http_response_code(500);
            $message = trim($err->getMessage()) ?: 'Falha interna ao processar a pergunta.';
            ResponseHelper::error($message, 500);
        }
    }
}
