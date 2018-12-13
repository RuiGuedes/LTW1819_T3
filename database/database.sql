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
    userPoints INTEGER DEFAULT 0,
    biography TEXT
);

----- Channel 

CREATE TABLE Channel(
    name TEXT NOT NULL PRIMARY KEY,
    owner TEXT NOT NULL REFERENCES User(username),
    description TEXT      
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
    storyTitle TEXT NOT NULL,
    storyContent TEXT NOT NULL,
    storyPoints INTEGER,
    storyAuthor TEXT NOT NULL REFERENCES User(username),
    storyComments INTEGER NOT NULL,
    storyTime TEXT NOT NULL,
    channelName TEXT NOT NULL REFERENCES Channel(name)       
);

----- Story Votes

CREATE TABLE StoryVotes(
    storyID INTEGER NOT NULL,
    username TEXT NOT NULL,
    voteType INTEGER NOT NULL DEFAULT 0,
    CONSTRAINT VoteValue CHECK(voteType = 1 OR voteType = -1),
    CONSTRAINT StoryVotes PRIMARY KEY (storyID, username)
);

----- Comment 

CREATE TABLE Comment(
    commentID INTEGER PRIMARY KEY,
    commentContent TEXT NOT NULL,
    commentPoints INTEGER,
    commentAuthor TEXT NOT NULL REFERENCES User(username),
    commentTime TEXT NOT NULL,
    storyID INTEGER REFERENCES Story,
    parentID INTEGER REFERENCES Comment(commentID)
);

----- CommentVotes

CREATE TABLE CommentVotes(
    commentID INTEGER NOT NULL,
    username TEXT NOT NULL,
    voteType INTEGER NOT NULL DEFAULT 0,
    CONSTRAINT VoteValue CHECK(voteType = 1 OR voteType = -1),
    CONSTRAINT CommentVotes PRIMARY KEY (commentID, username)
);
