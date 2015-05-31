CREATE TABLE IF NOT EXISTS rgstr_user (
	id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL,
        password VARCHAR(100) NOT NULL,
        firstname VARCHAR(100) DEFAULT NULL,
        surname VARCHAR(100) DEFAULT NULL,
        patronymic VARCHAR(100) DEFAULT NULL,
        role VARCHAR(10) NOT NULL DEFAULT 'operator',  
        enabled BOOLEAN NOT NULL DEFAULT TRUE,
	CONSTRAINT UNIQUE(name)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS rgstr_group (
        id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        enabled BOOLEAN NOT NULL DEFAULT TRUE,
        CONSTRAINT UNIQUE(name)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS rgstr_specialization (
	id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
        additional VARCHAR(255) NOT NULL DEFAULT '',
        enabled BOOLEAN NOT NULL DEFAULT TRUE,
        needDoctor BOOLEAN NOT NULL DEFAULT TRUE,
        recordOnTime BOOLEAN NOT NULL DEFAULT TRUE,
        provisionalRecord BOOLEAN NOT NULL DEFAULT FALSE,
        idGroup INTEGER DEFAULT NULL,
        FOREIGN KEY (idGroup) REFERENCES rgstr_group(id),
	CONSTRAINT UNIQUE(name, additional)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS rgstr_doctor (
        id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        firstname VARCHAR(100) NOT NULL,
        surname VARCHAR(100) NOT NULL DEFAULT '',
        patronymic VARCHAR(100) NOT NULL DEFAULT '',
        additional VARCHAR(255) NOT NULL DEFAULT '',
        enabled BOOLEAN NOT NULL DEFAULT TRUE,
        speciality VARCHAR(255) DEFAULT NULL,
        info TEXT,
        CONSTRAINT UNIQUE(firstname, surname, patronymic, additional)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS rgstr_specializationDoctor (
    idSpecialization INTEGER NOT NULL,
    idDoctor INTEGER NOT NULL,
    FOREIGN KEY (idSpecialization) REFERENCES rgstr_specialization(id),
    FOREIGN KEY (idDoctor) REFERENCES rgstr_doctor(id),
    CONSTRAINT UNIQUE(idSpecialization, idDoctor)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS rgstr_workDay (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    date DATE NOT NULL,
    published BOOLEAN NOT NULL DEFAULT TRUE,
    idSpecialization INTEGER NOT NULL,
    idDoctor INTEGER DEFAULT NULL,
    FOREIGN KEY (idSpecialization) REFERENCES rgstr_specialization(id),
    FOREIGN KEY (idDoctor) REFERENCES rgstr_doctor(id),
    CONSTRAINT UNIQUE(date, idSpecialization, idDoctor)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS rgstr_workTime (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    time TIME NOT NULL,
    state VARCHAR(20) NOT NULL DEFAULT 'free',
    idWorkDay INTEGER NOT NULL,
    FOREIGN KEY (idWorkDay) REFERENCES rgstr_workDay(id),
    CONSTRAINT UNIQUE(time, idWorkDay)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS rgstr_templateWorkDay (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    CONSTRAINT UNIQUE(name)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS rgstr_templateWorkTime (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    time TIME NOT NULL,
    state VARCHAR(20) NOT NULL DEFAULT 'free',
    idTemplateWorkDay INTEGER NOT NULL,
    FOREIGN KEY (idTemplateWorkDay) REFERENCES rgstr_templateWorkDay(id),
    CONSTRAINT UNIQUE(time, idTemplateWorkDay)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS rgstr_order (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idSpecialization INTEGER NOT NULL,
    idDoctor INTEGER,
    date DATE NOT NULL,
    time TIME NOT NULL,
    firstname VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL DEFAULT '',
    patronymic VARCHAR(100) NOT NULL DEFAULT '',
    phone VARCHAR(255) NOT NULL,
    processed BOOLEAN NOT NULL DEFAULT FALSE,
    state VARCHAR(20) NOT NULL DEFAULT 'notDefined',
    orderDateTime DATETIME NOT NULL,
    FOREIGN KEY (idSpecialization) REFERENCES rgstr_specialization(id),
    FOREIGN KEY (idDoctor) REFERENCES rgstr_doctor(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

INSERT INTO rgstr_user(name, password, surname, firstname, patronymic, role, enabled)
    VALUES('admin', 'pass', '', '', '', 'admin', true);
