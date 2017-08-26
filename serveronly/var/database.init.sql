CREATE TABLE users (
    userid SERIAL NOT NULL,
    username VARCHAR(32) NOT NULL,
    passwordhash VARCHAR(128) NOT NULL,
    email VARCHAR(48) NOT NULL,
    verified INTEGER DEFAULT 0,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_users PRIMARY KEY (userid),
    CONSTRAINT uc_users_username UNIQUE (username)
);

CREATE TABLE profiles (
    profileid SERIAL,
    userid INTEGER NOT NULL,
    firstname VARCHAR(32) DEFAULT '',
    lastname VARCHAR(32) DEFAULT '',
    ismale INTEGER DEFAULT 0,
    dayofbirth DATE,
    infotext TEXT DEFAULT '',
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_profiles PRIMARY KEY (profileid),
    CONSTRAINT fk_profiles_users FOREIGN KEY (userid) REFERENCES users(userid)
);

CREATE TABLE verifications (
    verifyid VARCHAR(128) NOT NULL,
    username VARCHAR(32) NOT NULL,
    passwordhash VARCHAR(128) NOT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(48) NOT NULL,
    CONSTRAINT pk_verifications PRIMARY KEY (verifyid),
    CONSTRAINT uc_verifications_email UNIQUE (email),
    CONSTRAINT uc_verifications_username UNIQUE (username)
);

,CREATE TABLE locations (
    locationid SERIAL,
    name VARCHAR(64) NOT NULL,
    longitude DOUBLE,
    latitude DOUBLE,
    altitude DOUBLE DEFAULT 0,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_locations PRIMARY KEY (locationid)
);

CREATE TABLE jobrequests (
    requestid SERIAL,
    requestor INTEGER NOT NULL,
    type INTEGER DEFAULT 1,
    title VARCHAR(128) DEFAULT '',
    description TEXT DEFAULT '',
    appointmenttime TIMESTAMP NOT NULL,
    locationid INTEGER NOT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_jobrequests PRIMARY KEY (requestid),
    CONSTRAINT fk_jobrequests_users FOREIGN KEY (requestor) REFERENCES users(userid),
    CONSTRAINT fk_jobrequests_locations FOREIGN KEY (locationid) REFERENCES locations(locationid)
);
