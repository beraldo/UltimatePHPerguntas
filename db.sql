-- Arquivo com os comandos SQL para criar o banco de dados e as tabelas
--
-- Se utilizar esse sistema em produção, não mantenha esse arquivo na pasta pública, para que a estrutura das tabelas não fique visível pelo navegador


-- remove o banco de dados, caso exista
DROP DATABASE IF EXISTS ultimatephperguntas;

-- banco de dados
CREATE DATABASE ultimatephperguntas DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- seleciona o banco de dados
use ultimatephperguntas;

-- tabela de usuários
-- status 1 = inativo, status 2 = ativo
CREATE TABLE users(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) DEFAULT NULL,
    nickname VARCHAR(30) NOT NULL,
    email VARCHAR(80) NOT NULL,
    password CHAR(128) NOT NULL,
    token CHAR(40) DEFAULT NULL,
    status INT NOT NULL DEFAULT 1,
    admin ENUM('1', '0') DEFAULT '0',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (nickname),
    UNIQUE KEY (email)
);


-- tabela de perguntas
CREATE TABLE questions(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(120) NOT NULL,
    description TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON UPDATE CASCADE 
        ON DELETE CASCADE
);


-- tabela de respostas
CREATE TABLE answers(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    question_id INT UNSIGNED NOT NULL,
    description TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON UPDATE CASCADE 
        ON DELETE CASCADE,
    FOREIGN KEY (question_id)
        REFERENCES questions(id)
        ON UPDATE CASCADE 
        ON DELETE CASCADE
);


