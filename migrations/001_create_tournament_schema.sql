-- Migration: Create tournament schema (PostgreSQL)
-- Tables: teams, tournaments, tournament_participants, rounds, matches

CREATE TABLE IF NOT EXISTS teams (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    city VARCHAR(100),
    founded_year INTEGER,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT now(),
    updated_at TIMESTAMP WITHOUT TIME ZONE DEFAULT now(),
    deleted_at TIMESTAMP WITHOUT TIME ZONE
);

CREATE TABLE IF NOT EXISTS tournaments (
    id SERIAL PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    date DATE NOT NULL,
    location VARCHAR(200),
    participants_count INTEGER NOT NULL,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT now(),
    updated_at TIMESTAMP WITHOUT TIME ZONE DEFAULT now()
);

CREATE TABLE IF NOT EXISTS tournament_participants (
    id SERIAL PRIMARY KEY,
    tournament_id INTEGER NOT NULL REFERENCES tournaments(id) ON DELETE CASCADE,
    team_id INTEGER NOT NULL REFERENCES teams(id) ON DELETE RESTRICT,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT now()
);

CREATE TABLE IF NOT EXISTS rounds (
    id SERIAL PRIMARY KEY,
    tournament_id INTEGER NOT NULL REFERENCES tournaments(id) ON DELETE CASCADE,
    round_number INTEGER NOT NULL,
    date DATE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT now()
);

CREATE TABLE IF NOT EXISTS matches (
    id SERIAL PRIMARY KEY,
    round_id INTEGER NOT NULL REFERENCES rounds(id) ON DELETE CASCADE,
    home_team_id INTEGER REFERENCES teams(id),
    away_team_id INTEGER REFERENCES teams(id),
    home_goals INTEGER,
    away_goals INTEGER,
    winner_team_id INTEGER REFERENCES teams(id),
    match_order INTEGER DEFAULT 0,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT now(),
    updated_at TIMESTAMP WITHOUT TIME ZONE DEFAULT now()
);

-- Indexes for performance
CREATE INDEX IF NOT EXISTS idx_tournament_participants_tournament ON tournament_participants(tournament_id);
CREATE INDEX IF NOT EXISTS idx_rounds_tournament ON rounds(tournament_id);
CREATE INDEX IF NOT EXISTS idx_matches_round ON matches(round_id);
