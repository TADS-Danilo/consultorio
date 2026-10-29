# consultorio
TADS - Projeto Integrado Interdisciplinar

# comandos executados dentro do banco de dados
CREATE DATABASE consultorio;
USE consultorio;
CREATE USER 'consultorio'@'%' IDENTIFIED BY '123456';
GRANT SELECT, INSERT, UPDATE, DELETE ON *.* TO 'consultorio'@'%';

CREATE TABLE perfil(
	id INT AUTO_INCREMENT,
    nome VARCHAR(20) NOT NULL,
    PRIMARY KEY(id)
);
INSERT INTO perfil(nome) VALUES("Assistente"),("Dentista");

CREATE TABLE usuario(
	id INT AUTO_INCREMENT,
    nome VARCHAR(250) NOT NULL,
    perfil_id INT NOT NULL,
    email VARCHAR(250) NOT NULL,
    login VARCHAR(20) NOT NULL,
    senha VARCHAR(250) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(perfil_id) REFERENCES perfil(id)
);
INSERT INTO usuario(nome, perfil_id, email, login, senha) VALUES('Dentista 1',1,'dentista1@consultorio.com.br','dentista1','e10adc3949ba59abbe56e057f20f883e');

CREATE TABLE paciente(
	id INT AUTO_INCREMENT,
    nome VARCHAR(250) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    data_nascimento DATE NOT NULL,
    sexo VARCHAR(15) NOT NULL,
    email VARCHAR(250) NOT NULL,
    telefone VARCHAR(50),
    celular VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE agendamento(
    id INT AUTO_INCREMENT,
    paciente_id INT NOT NULL,
    usuario_id INT NOT NULL,
    data_agendamento DATE NOT NULL,
    horario TIME NOT NULL,
    observacoes TEXT,
    situacao VARCHAR(20) NOT NULL DEFAULT 'Agendado',
    PRIMARY KEY(id),
    FOREIGN KEY (paciente_id) REFERENCES paciente(id),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);