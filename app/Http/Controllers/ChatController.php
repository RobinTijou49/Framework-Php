<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Film;
use App\Models\Location;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        // 1. Appel Ollama
        $response = Http::timeout(180)->post('http://127.0.0.1:11434/api/generate', [
            "model" => "gemma3:1b",
            "prompt" => $this->buildPrompt($userMessage),
            "stream" => false
        ]);

        $text = $response->json()['response'] ?? '';

        // 2. Extraction JSON du LLM
        $parsed = $this->extractJson($text);

        // 3. Si pas de tool → réponse classique
        if (!$parsed || !isset($parsed['tool'])) {
            return response()->json([
                "response" => $text
            ]);
        }

        $tool = $parsed['tool'];
        $args = $parsed['arguments'] ?? [];

        // 4. 🔥 FIX: sécurité arguments
        if ($tool === 'list_films') {
            $args = []; // force clean (aucun paramètre autorisé)
        }

        if ($tool === 'get_locations_for_film') {

            // force int propre
            $args['id'] = isset($args['id']) ? (int) $args['id'] : null;
        }

        if ($tool === 'get_locations_for_film' && empty($args['id'])) {
            return response()->json([
                "error" => "Missing film id"
            ]);
        }
        // 5. Exécution tool
        $result = $this->executeTool($tool, $args);

        // 6. Retour final MCP
        return response()->json([
            "tool" => $tool,
            "result" => $result
        ]);
    }

    // ------------------------
    // TOOLS MCP
    // ------------------------
    private function executeTool($tool, $args)
    {
        return match ($tool) {

            'list_films' => Film::all(),

            'get_locations_for_film' =>
                Location::where('film_id', (int) $args['id'])->get(),

            default => ["error" => "Tool not found"]
        };
    }

    // ------------------------
    // PROMPT OLLAMA
    // ------------------------
    private function buildPrompt($message)
        {
            return "
        Tu es un routeur d'API Laravel.

        TOOLS :

        1. list_films
        - aucun paramètre

        2. get_locations_for_film
        - paramètre obligatoire : id (ENTIER uniquement)

        RÈGLES ABSOLUES :
        - id doit être un nombre entier uniquement
        - si l'utilisateur dit 'film 1' => id = 1
        - ne jamais écrire 'film 1', 'id: film 1', etc
        - ne jamais inventer de texte

        FORMAT STRICT :
        {
        \"tool\": \"nom\",
        \"arguments\": {
            \"id\": 1
        }
        }

        Utilisateur: $message
        ";
        }

    // ------------------------
    // PARSER JSON ROBUSTE
    // ------------------------
    private function extractJson($text)
    {
        // extrait ```json ... ```
        preg_match('/```json(.*?)```/s', $text, $matches);

        if (isset($matches[1])) {
            return json_decode(trim($matches[1]), true);
        }

        // fallback JSON brut
        return json_decode($text, true);
    }
}
