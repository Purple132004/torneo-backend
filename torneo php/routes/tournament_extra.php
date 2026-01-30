<?php

use App\Models\Tournament;
use App\Models\Team;
use App\Utils\Response;
use App\Database\DB;
use Pecee\SimpleRouter\SimpleRouter as Router;

/**
 * GET /api/tournaments/{id}/matches - Lista tutti i match di un torneo (ordinati per round e ordine)
 */
Router::get('/tournaments/{id}/matches', function($id) {
    try {
        $rows = DB::select(
            'SELECT m.* FROM matches m INNER JOIN rounds r ON m.round_id = r.id WHERE r.tournament_id = :tid ORDER BY r.round_number, m.match_order',
            ['tid' => (int)$id]
        );

        Response::success($rows)->send();
    } catch (\Exception $e) {
        Response::error('Errore nel recupero dei match: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR)->send();
    }
});


/**
 * GET /api/tournaments/{id}/participants - Lista partecipanti di un torneo
 */
Router::get('/tournaments/{id}/participants', function($id) {
    try {
        $rows = DB::select('SELECT t.* FROM teams t INNER JOIN tournament_participants tp ON t.id = tp.team_id WHERE tp.tournament_id = :tid', ['tid' => (int)$id]);
        Response::success($rows)->send();
    } catch (\Exception $e) {
        Response::error('Errore nel recupero dei partecipanti: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR)->send();
    }
});


/**
 * GET /api/tournaments/{id}/rounds - Lista rounds con match per torneo
 */
Router::get('/tournaments/{id}/rounds', function($id) {
    try {
        $rounds = DB::select('SELECT * FROM rounds WHERE tournament_id = :tid ORDER BY round_number', ['tid' => (int)$id]);
        $payload = [];
        foreach ($rounds as $r) {
            $matches = DB::select('SELECT * FROM matches WHERE round_id = :rid ORDER BY match_order', ['rid' => $r['id']]);
            $payload[] = array_merge($r, ['matches' => $matches]);
        }
        Response::success($payload)->send();
    } catch (\Exception $e) {
        Response::error('Errore nel recupero dei rounds: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR)->send();
    }
});
