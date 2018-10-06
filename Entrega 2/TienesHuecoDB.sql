DROP DATABASE IF EXISTS TSW;
CREATE DATABASE IF NOT EXISTS TSW;
USE TSW;

CREATE TABLE IF NOT EXISTS USER(
  username varchar(25) NOT NULL,
  passwd varchar(50) NOT NULL,
  PRIMARY KEY(username)
);

CREATE TABLE IF NOT EXISTS POLL(
  id int(225) AUTO_INCREMENT NOT NULL ,
  title varchar(225) NOT NULL,
  ubication varchar(225),
  author varchar(25) NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (author) REFERENCES USER (username)
);

CREATE TABLE IF NOT EXISTS GAP(
  id int(225) AUTO_INCREMENT NOT NULL,
  -- BEGIN date
  -- END date
  poll_id int(225) NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (poll_id) REFERENCES POLL (id)

);

CREATE TABLE IF NOT EXISTS USER_SELECTS_GAP(
  username varchar(25) NOT NULL,
  gap_id int(225) NOT NULL,
  PRIMARY KEY(username, gap_id),
  FOREIGN KEY (username) REFERENCES USER (username),
  FOREIGN KEY (gap_id) REFERENCES GAP (id)
);

INSERT INTO USER (username, passwd) VALUES
('mpegea', 'pimpam'),
('albovy', 'redteamwins'),
('ivandd', 'soyidiota');

INSERT INTO POLL (id, title, ubication, author) VALUES
(1, 'Ir a comprar el pan', 'Continente', 'mpegea'),
(2, 'Comida de "ingenieros"', 'Infra', 'albovy'),
(3, 'Trail Ribeira Sacra', 'Galiza', 'mpegea'),
(4, 'Entrenamiento', 'Estadio Santiago Bernabeu', 'ivandd');

INSERT INTO GAP (id, poll_id) VALUES
(1,1),
(2,1),
(3,1),
(4,1),
(5,1);

INSERT INTO USER_SELECTS_GAP (username, gap_id) VALUES
('albovy',1),
('albovy',3),
('albovy',4),
('ivandd',2),
('mpegea',2),
('mpegea',3),
('mpegea',4);
