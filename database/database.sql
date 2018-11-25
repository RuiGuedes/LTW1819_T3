PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Channel;
DROP TABLE IF EXISTS Subscription;
DROP TABLE IF EXISTS Story;
DROP TABLE IF EXISTS Comment;

----- User 

CREATE TABLE User(
    username TEXT NOT NULL PRIMARY KEY,
    password TEXT NOT NULL,
    email TEXT NOT NULL,
    biography TEXT,
    userPic TEXT
);

----- Channel 

CREATE TABLE Channel(
    name TEXT NOT NULL PRIMARY KEY,
    owner TEXT NOT NULL REFERENCES User(username),
    description TEXT,
    channelPic TEXT        
    --channel_bar_color TEXT NOT NULL,
    --channel_bg_color TEXT NOT NULL
);

----- Subscription

CREATE TABLE Subscription(
    username TEXT NOT NULL REFERENCES User(username),
    channelName TEXT NOT NULL REFERENCES Channel(name),
    CONSTRAINT Subscription PRIMARY KEY (username, channelName)
);

----- Story 

CREATE TABLE Story(
    storyID INTEGER NOT NULL PRIMARY KEY,
    title TEXT NOT NULL,
    storyContent TEXT NOT NULL,
    storyPoints INTEGER NOT NULL,
    storyAuthor TEXT NOT NULL REFERENCES User(username),
    channelName TEXT NOT NULL REFERENCES Channel(name),
    storyPic TEXT        
);

----- Comment 

CREATE TABLE Comment(
    commentID INTEGER PRIMARY KEY,
    commentContent TEXT NOT NULL,
    commentPoints INTEGER NOT NULL,
    commentAuthor TEXT NOT NULL REFERENCES User(username),
    storyID INTEGER REFERENCES Story,
    parentID INTEGER REFERENCES Comment(commentID)
);

