-- ##############################################
-- KURS: DT161G
-- Projekt
-- Robin Jönsson
-- Create table called xxx
-- Create table called yyy
-- etc...................................
-- ##############################################

DROP SCHEMA IF EXISTS dt161g_project CASCADE;

CREATE SCHEMA dt161g_project;

DROP TABLE IF EXISTS dt161g_project.members;

CREATE TABLE dt161g_project.members
(
    id       SERIAL PRIMARY KEY,
    username text NOT NULL CHECK (username <> ''),
    password text NOT NULL CHECK (password <> ''),
    CONSTRAINT unique_user UNIQUE (username)
)
    WITHOUT OIDS;
INSERT INTO dt161g_project.members (username, password)
VALUES ('m', 'm');
INSERT INTO dt161g_project.members (username, password)
VALUES ('a', 'a');

DROP TABLE IF EXISTS dt161g_project.paths;

CREATE TABLE dt161g_project.paths
(
    path    text PRIMARY KEY,
    name    text    NOT NULL,
    parent  text REFERENCES dt161g_project.paths (path),
    isImage BOOLEAN NOT NULL
)
    WITHOUT OIDS;
INSERT INTO dt161g_project.paths (path, isImage, name)
VALUES ('../../writeable/dt161g_project/', 'FALSE', 'root');

DROP TABLE IF EXISTS dt161g_project.user_paths;

CREATE TABLE dt161g_project.user_paths
(
    id        SERIAL PRIMARY KEY,
    member_id integer REFERENCES dt161g_project.members (id),
    path      text REFERENCES dt161g_project.paths (path)
)
    WITHOUT OIDS;



