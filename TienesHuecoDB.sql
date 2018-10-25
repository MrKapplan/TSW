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
('ivan', 'ivan'),
('admin', 'admin');

INSERT INTO POLL (id, title, ubication, author, link) VALUES
(1, 'Reunión de desarrolladores', 'Despacho 23', 'mpegea', 'localhost/TSW/'),
(2, 'Camino de Santiago', 'Santiago de Compostela', 'albovy', 'https://midominio.com/poll/c81e728d9d4c2f636f067f89cc14862c'),
(3, 'Trail Ribeira Sacra', 'Galiza', 'mpegea', 'https://midominio.com/poll/eccbc87e4b5ce2fe28308fd9f2a7baf3'),
(4, 'Entrenamientos semana 12', 'Campo de O Couto', 'ivan', 'https://midominio.com/poll/a87ff679a2f3e71d9181a67b7542122c'),
(5, 'Quedada graduados 2014/15', 'Bar Graduado', 'ivan', 'https://midominio.com/poll/e4da3b7fbbce2345d7772b0674a318d5'),
(6, 'Magostos 2018', 'Finca de Javier', 'mpegea', 'https://midominio.com/poll/1679091c5a880faf6fb5e6087eb1b2dc');

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
('ivan', 1, 1),
('ivan', 3, 1);
