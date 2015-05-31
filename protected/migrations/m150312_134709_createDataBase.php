<?php

class m150312_134709_createDataBase extends CDbMigration
{
	public function up()
	{
            $c = Yii::app()->db;
        
            $c->createCommand("
                CREATE TABLE IF NOT EXISTS {{user}} (
                    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    name VARCHAR(100) NOT NULL,
                    password VARCHAR(100) NOT NULL,
                    firstname VARCHAR(100) DEFAULT NULL,
                    surname VARCHAR(100) DEFAULT NULL,
                    patronymic VARCHAR(100) DEFAULT NULL,
                    role VARCHAR(10) NOT NULL DEFAULT 'operator',  
                    enabled BOOLEAN NOT NULL DEFAULT TRUE,
                    CONSTRAINT UNIQUE(name)
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;"
            )->execute();
            
            
            // Создаём пользователя admin.
            $c->createCommand("
                    INSERT INTO {{user}}(name, password, surname, firstname, patronymic, role, enabled)
                        VALUES('admin', 'admin', '', '', '', 'admin', true);"
            )->execute();
            
            
            $c->createCommand("
                CREATE TABLE IF NOT EXISTS {{group}} (
                    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    name VARCHAR(255) NOT NULL,
                    enabled BOOLEAN NOT NULL DEFAULT TRUE,
                    CONSTRAINT UNIQUE(name)
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;"      
            )->execute();
            
            $c->createCommand("
                CREATE TABLE IF NOT EXISTS {{specialization}} (
                    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    name VARCHAR(255) NOT NULL,
                    additional VARCHAR(255) NOT NULL DEFAULT '',
                    enabled BOOLEAN NOT NULL DEFAULT TRUE,
                    needDoctor BOOLEAN NOT NULL DEFAULT TRUE,
                    recordOnTime BOOLEAN NOT NULL DEFAULT TRUE,
                    provisionalRecord BOOLEAN NOT NULL DEFAULT FALSE,
                    idGroup INTEGER DEFAULT NULL,
                    FOREIGN KEY (idGroup) REFERENCES rcptn_group(id),
                    CONSTRAINT UNIQUE(name, additional)
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;"
            )->execute();
            
            $c->createCommand("
                CREATE TABLE IF NOT EXISTS {{doctor}} (
                        id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        firstname VARCHAR(100) NOT NULL,
                        surname VARCHAR(100) NOT NULL DEFAULT '',
                        patronymic VARCHAR(100) NOT NULL DEFAULT '',
                        additional VARCHAR(255) NOT NULL DEFAULT '',
                        enabled BOOLEAN NOT NULL DEFAULT TRUE,
                        speciality VARCHAR(255) DEFAULT NULL,
                        info TEXT,
                        CONSTRAINT UNIQUE(firstname, surname, patronymic, additional)
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;"
            )->execute();
            
            $c->createCommand("
                CREATE TABLE IF NOT EXISTS {{specializationDoctor}} (
                    idSpecialization INTEGER NOT NULL,
                    idDoctor INTEGER NOT NULL,
                    FOREIGN KEY (idSpecialization) REFERENCES rcptn_specialization(id),
                    FOREIGN KEY (idDoctor) REFERENCES rcptn_doctor(id),
                    CONSTRAINT UNIQUE(idSpecialization, idDoctor)
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;"
            )->execute();
            
            $c->createCommand("
                CREATE TABLE IF NOT EXISTS {{workDay}} (
                    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    date DATE NOT NULL,
                    published BOOLEAN NOT NULL DEFAULT TRUE,
                    idSpecialization INTEGER NOT NULL,
                    idDoctor INTEGER DEFAULT NULL,
                    FOREIGN KEY (idSpecialization) REFERENCES rcptn_specialization(id),
                    FOREIGN KEY (idDoctor) REFERENCES rcptn_doctor(id),
                    CONSTRAINT UNIQUE(date, idSpecialization, idDoctor)
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;"
            )->execute();
            
            $c->createCommand("
               CREATE TABLE IF NOT EXISTS {{workTime}} (
                    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    time TIME NOT NULL,
                    state VARCHAR(20) NOT NULL DEFAULT 'free',
                    idWorkDay INTEGER NOT NULL,
                    FOREIGN KEY (idWorkDay) REFERENCES rcptn_workDay(id),
                    CONSTRAINT UNIQUE(time, idWorkDay)
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;"
            )->execute();
 
            $c->createCommand("
               CREATE TABLE IF NOT EXISTS {{templateWorkDay}} (
                    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    name VARCHAR(255) NOT NULL,
                    CONSTRAINT UNIQUE(name)
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;"
            )->execute();
            
            $c->createCommand("
               CREATE TABLE IF NOT EXISTS {{templateWorkTime}} (
                    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    time TIME NOT NULL,
                    state VARCHAR(20) NOT NULL DEFAULT 'free',
                    idTemplateWorkDay INTEGER NOT NULL,
                    FOREIGN KEY (idTemplateWorkDay) REFERENCES rcptn_templateWorkDay(id),
                    CONSTRAINT UNIQUE(time, idTemplateWorkDay)
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;"
            )->execute();
            
            $c->createCommand("
                CREATE TABLE IF NOT EXISTS {{order}} (
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
                    FOREIGN KEY (idSpecialization) REFERENCES rcptn_specialization(id),
                    FOREIGN KEY (idDoctor) REFERENCES rcptn_doctor(id)
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;"
            )->execute();
            
	}

	public function down()
	{
            $c = Yii::app()->db;
            
            $c->createCommand("DROP TABLE IF EXISTS {{user}};")->execute();
            $c->createCommand("DROP TABLE IF EXISTS {{order}};")->execute();
            $c->createCommand("DROP TABLE IF EXISTS {{workTime}};")->execute();
            $c->createCommand("DROP TABLE IF EXISTS {{workDay}};")->execute();
            $c->createCommand("DROP TABLE IF EXISTS {{templateWorkTime}};")->execute();
            $c->createCommand("DROP TABLE IF EXISTS {{templateWorkDay}};")->execute();
            $c->createCommand("DROP TABLE IF EXISTS {{specializationDoctor}};")->execute();
            $c->createCommand("DROP TABLE IF EXISTS {{doctor}};")->execute();
            $c->createCommand("DROP TABLE IF EXISTS {{specialization}};")->execute();
            $c->createCommand("DROP TABLE IF EXISTS {{group}};")->execute();
	}
}