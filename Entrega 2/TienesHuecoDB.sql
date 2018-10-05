DROP DATABASE IF EXISTS TSW;

CREATE DATABASE IF NOT EXISTS TSW;

USE TSW;

CREATE TABLE IF NOT EXISTS USER(
  ID varchar(25) NOT NULL,
  PASSWORD varchar(50) NOT NULL,
  PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS POLL(
  ID int(225) AUTO_INCREMENT NOT NULL ,
  NAME varchar(225) NOT NULL,
  UBICATION varchar(225),
  USER_ID varchar(25) NOT NULL,
  PRIMARY KEY(ID),
  FOREIGN KEY (USER_ID) REFERENCES USER (ID)
);

CREATE TABLE IF NOT EXISTS GAP(
  ID int(225) AUTO_INCREMENT NOT NULL,
  -- BEGIN date
  -- END date
  POLL_ID int(225) NOT NULL,
  PRIMARY KEY(ID),
  FOREIGN KEY (POLL_ID) REFERENCES POLL (ID)

);

CREATE TABLE IF NOT EXISTS USER_SELECTS_GAP(
  USER_ID varchar(25) NOT NULL,
  GAP_ID int(225) NOT NULL,
  PRIMARY KEY(USER_ID, GAP_ID),
  FOREIGN KEY (USER_ID) REFERENCES USER (ID),
  FOREIGN KEY (GAP_ID) REFERENCES GAP (ID)
);

INSERT INTO USER (ID, PASSWORD) VALUES
('mpegea', 'pimpam'),
('albovy', 'redteamwins'),
('ivandd', 'soyidiota');

INSERT INTO POLL (ID, NAME, UBICATION, USER_ID) VALUES
(1, 'Ir a comprar el pan', 'Continente', 'mpegea'),
(2, 'Comida de "ingenieros"', 'Infra', 'albovy'),
(3, 'Trail Ribeira Sacra', 'Galiza', 'mpegea'),
(4, 'Entrenamiento', 'Estadio Santiago Bernabeu', 'ivandd');

INSERT INTO GAP (ID, POLL_ID) VALUES
(1,1),
(2,1),
(3,1),
(4,1),
(5,1);

INSERT INTO USER_SELECTS_GAP (USER_ID, GAP_ID) VALUES
('albovy',1),
('albovy',3),
('albovy',4),
('ivandd',2),
('mpegea',2),
('mpegea',3),
('mpegea',4);
