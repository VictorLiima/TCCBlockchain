/* MR: */

CREATE TABLE eleicao (
    id INT PRIMARY KEY,
    ano INT
);

CREATE TABLE candidato (
    nome VARCHAR(255),
    id INT PRIMARY KEY
);

CREATE TABLE usuario (
    id INT PRIMARY KEY,
    email VARCHAR(255),
    senha VARCHAR(255),
    administrador BOOLEAN,
    voto BOOLEAN
);

CREATE TABLE _candidato_eleicao (
    total_votos INT,
    fk_candidato_id INT,
    fk_eleicao_id INT
);

CREATE TABLE eleicao_usuario (
    fk_eleicao_id INT,
    fk_usuario_id INT
);
 
ALTER TABLE _candidato_eleicao ADD CONSTRAINT FK__candidato_eleicao_1
    FOREIGN KEY (fk_candidato_id)
    REFERENCES candidato (id);
 
ALTER TABLE _candidato_eleicao ADD CONSTRAINT FK__candidato_eleicao_2
    FOREIGN KEY (fk_eleicao_id)
    REFERENCES eleicao (id);
 
ALTER TABLE eleicao_usuario ADD CONSTRAINT FK_eleicao_usuario_1
    FOREIGN KEY (fk_eleicao_id)
    REFERENCES eleicao (id)
    ON DELETE SET NULL;
 
ALTER TABLE eleicao_usuario ADD CONSTRAINT FK_eleicao_usuario_2
    FOREIGN KEY (fk_usuario_id)
    REFERENCES usuario (id)
    ON DELETE SET NULL;