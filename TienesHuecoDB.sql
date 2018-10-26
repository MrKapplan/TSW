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
  link varchar(225) UNIQUE NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (author) REFERENCES USER (username) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS GAP(
  id int AUTO_INCREMENT NOT NULL,
  date date NOT NULL,
  timeStart time NOT NULL,
  timeEnd time NOT NULL,
  poll_id int(225) NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (poll_id) REFERENCES POLL (id) ON UPDATE CASCADE ON DELETE CASCADE

);

CREATE TABLE IF NOT EXISTS USER_SELECTS_GAP(
  username varchar(25) NOT NULL,
  gap_id int NOT NULL,
  poll_id int NOT NULL,
  PRIMARY KEY(username, gap_id, poll_id),
  FOREIGN KEY (username) REFERENCES USER (username) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (gap_id) REFERENCES GAP (id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (poll_id) REFERENCES POLL (id) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO USER (username, passwd) VALUES
('mpegea', 'pimpam'),
('albovy', 'redteamwins'),
('ivandd', 'ivan'),
('admin', 'admin');

INSERT INTO POLL (id, title, ubication, author, link) VALUES
(1, 'Reunión de desarrolladores', 'Despacho 23', 'mpegea', 'ec819428960921f0cc1ce29022d26862'),
(2, 'Churrasco AMPA', 'Casa de Julián', 'albovy', '208872e6934784b6844c0394eed87e99'),
(3, 'Trail Ribeira Sacra', 'Parada do Sil, Ourense', 'mpegea', 'b7a34489ac1bbb0bfad1a1a46c01ad0f'),
(4, 'Entrenamientos semana 12', 'Campo de O Couto', 'ivandd', '32237d5e7fb42892fd766692010996b4'),
(5, 'Quedada graduados 2014/15', 'Bar Graduado', 'ivandd', '39b656378545d9ff04282e0b7dbe3f12'),
(6, 'Magostos 2018', 'Finca de Javier', 'mpegea', 'f1188203ff33e591ffc4e877ec978682');

INSERT INTO GAP (id, poll_id, date, timeStart, timeEnd) VALUES
(1, 1,'2018-09-27', '10:00', '11:00'),
(2, 1,'2018-09-28', '15:00',' 16:00'),
(3, 1,'2018-09-29', '16:00', '17:00'),
(4, 1,'2018-10-01', '09:00', '10:00'),

(5, 2,'2018-10-11', '13:00', '16:00'),
(6, 2,'2018-10-18', '13:00', '16:00'),
(7, 2,'2018-10-25', '20:00', '22:00'),

(8, 3,'2018-12-01', '10:30', '14:30'),
(9, 3,'2018-12-01', '16:00', '20:00'),

(10, 4,'2018-12-11', '09:00', '10:00'),
(11, 4,'2018-12-21', '09:00', '10:00');


INSERT INTO USER_SELECTS_GAP (username, gap_id, poll_id) VALUES
('albovy', 1, 1),
('albovy', 2, 1),
('albovy', 3, 1),
('albovy', 4, 1),
('mpegea', 1, 1),
('mpegea', 2, 1),
('ivandd', 1, 1),
('ivandd', 3, 1),

('albovy', 5, 2),
('albovy', 6, 2),
('mpegea', 5, 2),
('ivandd', 6, 2),

('albovy', 8, 3),
('albovy', 9, 3),
('mpegea', 8, 3),
('ivandd', 8, 3),
('ivandd', 9, 3);

