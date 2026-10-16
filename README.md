# consultorio
TADS - Projeto Integrado Interdisciplinar

# comandos executados dentro do banco de dados
CREATE DATABASE consultorio;
USE consultorio;
CREATE USER 'consultorio'@'%' IDENTIFIED BY '123456';
GRANT SELECT, INSERT, UPDATE, DELETE ON *.* TO 'consultorio'@'%';

CREATE TABLE usuario(
	id INT AUTO_INCREMENT,
    nome VARCHAR(250) NOT NULL,
    perfil VARCHAR(20) NOT NULL,
    email VARCHAR(250) NOT NULL,
    login VARCHAR(20) NOT NULL,
    senha VARCHAR(250) NOT NULL,
    PRIMARY KEY(id)
);

INSERT INTO usuario(nome, perfil, email, login, senha) VALUES('Dentista 1','Dentista','dentista1@consultorio.com.br','dentista1','e10adc3949ba59abbe56e057f20f883e');