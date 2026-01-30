<?php

use App\Models\Round;
use App\Models\TournamentMatch;
use App\Utils\Request;
use App\Utils\Response;
use App\Database\DB;
use Pecee\SimpleRouter\SimpleRouter as Router;

/**
 * GET /api/rounds/{id} - Dettaglio round con match
 */
Router::get('/rounds/{id}', function($id) {
    try {
        $r = DB::select('SELECT * FROM rounds WHERE id = :id', ['id' => (int)$id]);
        if (empty($r)) {
            Response::error('Round non trovato', Response::HTTP_NOT_FOUND)->send();
            return;
        }
        $round = $r[0];
        $matches = DB::select('SELECT * FROM matches WHERE round_id = :rid ORDER BY match_order', ['rid' => $round['id']]);
        $round['matches'] = $matches;
        Response::success($round)->send();
    } catch (\Exception $e) {
        Response::error('Errore nel recupero del round: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR)->send();
    }
});

/**
 * PATCH /api/rounds/{id} - Aggiorna data del round
 * body: { date: 'YYYY-MM-DD' }
 */
Router::match(['patch','put'], '/rounds/{id}', function($id) {
    try {
        $request = new Request();
        $data = $request->json();

        $date = $data['date'] ?? null;
        if ($date === null) {
            Response::error('Campo date obbligatorio', Response::HTTP_BAD_REQUEST)->send();
            return;
        }

        DB::update('UPDATE rounds SET date = :date WHERE id = :id', ['date' => $date, 'id' => (int)$id]);
        $r = DB::select('SELECT * FROM rounds WHERE id = :id', ['id' => (int)$id]);
        Response::success($r[0])->send();
    } catch (\Exception $e) {
        Response::error('Errore durante l\'aggiornamento del round: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR)->send();
    }
});
