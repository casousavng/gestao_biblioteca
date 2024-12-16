CREATE SEQUENCE seq_livro START WITH 1 INCREMENT BY 1;

CREATE TABLE livro ( 
    id_livro NUMBER PRIMARY KEY, 
    titulo VARCHAR2(255) NOT NULL, 
    autor VARCHAR2(255) NOT NULL, 
    editora VARCHAR2(255), 
    anoPublicacao NUMBER CHECK(anoPublicacao > 1500), 
    isbn VARCHAR2(20) UNIQUE, 
    numeroCopias NUMBER DEFAULT 1 CHECK(numeroCopias >= 0), 
    genero VARCHAR2(100), 
    estado VARCHAR2(20) CHECK(estado IN ('Disponivel', 'Emprestado', 'Reservado', 'Danificado')) NOT NULL 
);

CREATE SEQUENCE seq_utilizador START WITH 1 INCREMENT BY 1;

CREATE TABLE utilizador ( 
    id_utilizador NUMBER PRIMARY KEY, 
    nome VARCHAR2(255) NOT NULL, 
    tipo VARCHAR2(20) CHECK(tipo IN ('Leitor', 'Bibliotecário')) NOT NULL, 
    contacto VARCHAR2(20), 
    morada VARCHAR2(255), 
    numeroCC VARCHAR2(20) UNIQUE, 
    estado VARCHAR2(20) DEFAULT 'Ativo' CHECK(estado IN ('Ativo', 'Inativo', 'Suspenso')) 
);

CREATE SEQUENCE seq_emprestimo START WITH 1 INCREMENT BY 1;

CREATE TABLE emprestimo ( 
    id_emprestimo NUMBER PRIMARY KEY, 
    id_livro NUMBER, 
    id_utilizador NUMBER, 
    dataEmprestimo DATE NOT NULL, 
    dataDevolucao DATE, 
    estado VARCHAR2(20) CHECK(estado IN ('Ativo', 'Devolvido', 'Atrasado')) NOT NULL, 
    FOREIGN KEY (id_livro) REFERENCES livro(id_livro) ON DELETE CASCADE, 
    FOREIGN KEY (id_utilizador) REFERENCES utilizador(id_utilizador) ON DELETE CASCADE 
);

CREATE SEQUENCE seq_reserva START WITH 1 INCREMENT BY 1;

CREATE TABLE reserva ( 
    id_reserva NUMBER PRIMARY KEY, 
    id_livro NUMBER, 
    id_utilizador NUMBER, 
    data_reserva DATE NOT NULL, 
    estado VARCHAR2(20) CHECK(estado IN ('Pendente', 'Confirmada', 'Cancelada')) NOT NULL, 
    FOREIGN KEY (id_livro) REFERENCES livro(id_livro) ON DELETE CASCADE, 
    FOREIGN KEY (id_utilizador) REFERENCES utilizador(id_utilizador) ON DELETE CASCADE 
);

CREATE SEQUENCE seq_multa START WITH 1 INCREMENT BY 1;

CREATE TABLE multa ( 
    id_multa NUMBER PRIMARY KEY, 
    id_utilizador NUMBER, 
    valor NUMBER CHECK(valor >= 0), 
    data_aplicacao DATE DEFAULT SYSDATE, 
    estado VARCHAR2(20) DEFAULT 'Pendente' CHECK(estado IN ('Pendente', 'Pago')) NOT NULL, 
    FOREIGN KEY (id_utilizador) REFERENCES utilizador(id_utilizador) ON DELETE CASCADE 
);

COMMIT;