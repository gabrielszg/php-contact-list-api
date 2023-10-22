CREATE DATABASE enterprise;
USE enterprise;

CREATE TABLE company (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255)
);

CREATE TABLE contacts (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  birth_date DATE NOT NULL,
  landline VARCHAR(10) NOT NULL,
  cell_phone VARCHAR(11) NOT NULL,
  email VARCHAR(255) NOT NULL,
  company_id int,
  FOREIGN KEY(company_id) REFERENCES company(id)
);

INSERT INTO company (name)
VALUES ('One Company');

INSERT INTO company (name)
VALUES ('Two Company');

INSERT INTO company (name)
VALUES ('Three Company');


INSERT INTO contacts (name, last_name, birth_date, landline, cell_phone, email, company_id)
VALUES ('Maria', 'Silva', '1999-05-02', '2111111111', '21911111111', 'maria@email.com', 1);

INSERT INTO contacts (name, last_name, birth_date, landline, cell_phone, email, company_id)
VALUES ('Joao', 'Alves', '1992-10-08', '2122222222', '21922222222', 'joao@email.com', 2);

INSERT INTO contacts (name, last_name, birth_date, landline, cell_phone, email, company_id)
VALUES ('Carlos', 'Vieira', '1985-01-20', '2133333333', '21933333333', 'carlos@email.com', 3);

INSERT INTO contacts (name, last_name, birth_date, landline, cell_phone, email, company_id)
VALUES ('Ana', 'Lima', '1972-05-10', '2144444444', '21944444444', 'ana@email.com', 3);