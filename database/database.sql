PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Channel;
DROP TABLE IF EXISTS Story;
DROP TABLE IF EXISTS Comment;

----- User 

CREATE TABLE User(
    username TEXT NOT NULL PRIMARY KEY,
    password TEXT NOT NULL,
    email TEXT NOT NULL
    -- channels REFERENCES Channel
    -- Ainda faltam algumas foreign keys
);

----- Channel 

CREATE TABLE Channel(
    channel_id INTEGER PRIMARY KEY, -- Poderá ser mudado mas integer poderá dar jeito
    channel_name TEXT NOT NULL,
    channel_owner TEXT NOT NULL,
    channel_bar_color TEXT NOT NULL,
    channel_bg_color TEXT NOT NULL
);

----- Story 

CREATE TABLE Story(
    story_id INTEGER PRIMARY KEY,
    story_title TEXT NOT NULL,
    story_content TEXT NOT NULL,
    story_points INTEGER NOT NULL
);

----- Comment 

CREATE TABLE Comment(
    comment_id INTEGER PRIMARY KEY,
    comment_content TEXT NOT NULL,
    comment_points INTEGER NOT NULL
);