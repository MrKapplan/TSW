DROP DATABASE IF EXISTS TSW;
CREATE DATABASE IF NOT EXISTS TSW;
USE TSW;

CREATE TABLE IF NOT EXISTS USER(
  username varchar(25) NOT NULL,
  passwd varchar(50) NOT NULL,
  PRIMARY KEY(username)
);

CREATE TABLE IF NOT EXISTS POLL(
  id int AUTO_INCREMENT NOT NULL ,
  title varchar(225) NOT NULL,
  ubication varchar(225),
  author varchar(25) NOT NULL,
  link varchar(125) UNIQUE NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (author) REFERENCES USER (username)
);

CREATE TABLE IF NOT EXISTS GAP(
  id int AUTO_INCREMENT NOT NULL,
  date date NOT NULL,
  timeStart time NOT NULL,
  timeEnd time NOT NULL,
  poll_id int(225) NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (poll_id) REFERENCES POLL (id) 

);

CREATE TABLE IF NOT EXISTS USER_SELECTS_GAP(
  username varchar(25) NOT NULL,
  gap_id int(225) NOT NULL,
  poll_id int(225) NOT NULL,
  PRIMARY KEY(username, gap_id),
  FOREIGN KEY (username) REFERENCES USER (username),
  FOREIGN KEY (gap_id) REFERENCES GAP (id),
  FOREIGN KEY (poll_id) REFERENCES POLL (id)
);

INSERT INTO USER (username, passwd) VALUES
('mpegea', 'pimpam'),
('albovy', 'redteamwins'),
('ivandd', 'ivan');

INSERT INTO POLL (id, title, ubication, author, link) VALUES
(1, 'Reunión Desarrolladores', 'Despacho 23', 'mpegea', 'https://midominio.com/poll/f1290186a5d0b1ceab27'),
(2, 'Comida de "ingenieros"', 'Infra', 'albovy', 'https://midominio.com/poll/jklpde3g4n9do3ertghn'),
(3, 'Trail Ribeira Sacra', 'Galiza', 'mpegea', 'https://midominio.com/poll/asdfezhttlkca4rgbnkl'),
(4, 'Entrenamiento', 'Estadio Santiago Bernabeu', 'ivandd', 'https://midominio.com/poll/2bd4ezhtqn9caiuhjkm2');

INSERT INTO GAP (id, poll_id, date, timeStart, timeEnd) VALUES
(1, 1,'2018-09-27', '10:00', '11:00'),
(2, 1,'2018-09-28', '15:00',' 16:00'),
(3, 1,'2018-09-29', '16:00', '17:00'),
(4, 1,'2018-10-01', '09:00', '10:00');

INSERT INTO USER_SELECTS_GAP (username, gap_id, poll_id) VALUES
('albovy', 1, 1),
('albovy', 2, 1),
('albovy', 3, 1),
('albovy', 4, 1),
('mpegea', 1, 1),
('mpegea', 2, 1),
('ivandd', 1, 1),
('ivandd', 3, 1);
