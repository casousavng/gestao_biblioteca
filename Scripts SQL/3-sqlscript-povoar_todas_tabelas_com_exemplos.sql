-- Populando tabela "livro"
INSERT INTO livro (id_livro, titulo, autor, editora, anoPublicacao, isbn, numeroCopias, genero, estado) 
VALUES (seq_livro.NEXTVAL, 'O Alquimista', 'Paulo Coelho', 'Rocco', 1988, '9788579800245', 3, 'Ficção Científica', 'Disponivel');

INSERT INTO livro (id_livro, titulo, autor, editora, anoPublicacao, isbn, numeroCopias, genero, estado) 
VALUES (seq_livro.NEXTVAL, '1984', 'George Orwell', 'Companhia das Letras', 1949, '9788535908478', 2, 'Ficção Científica', 'Disponivel');

INSERT INTO livro (id_livro, titulo, autor, editora, anoPublicacao, isbn, numeroCopias, genero, estado) 
VALUES (seq_livro.NEXTVAL, 'O Pequeno Príncipe', 'Antoine de Saint-Exupéry', 'Agir', 1943, '9788522005230', 5, 'Infantil', 'Disponivel');

INSERT INTO livro (id_livro, titulo, autor, editora, anoPublicacao, isbn, numeroCopias, genero, estado) 
VALUES (seq_livro.NEXTVAL, 'A Arte da Guerra', 'Sun Tzu', 'Martin Claret', 1772, '9788572329408', 1, 'História', 'Disponivel');

INSERT INTO livro (id_livro, titulo, autor, editora, anoPublicacao, isbn, numeroCopias, genero, estado) 
VALUES (seq_livro.NEXTVAL, 'Dom Quixote', 'Miguel de Cervantes', 'Edições Loyola', 1605, '9788511056451', 0, 'Fantasia', 'Emprestado');

INSERT INTO livro (id_livro, titulo, autor, editora, anoPublicacao, isbn, numeroCopias, genero, estado) 
VALUES (seq_livro.NEXTVAL, 'O Teste', 'Paulo com Ácento', 'Rocco', 1988, '9788579800455', 3, 'Ficção Científica', 'Disponivel');


-- Populando tabela "utilizador"
INSERT INTO utilizador (id_utilizador, nome, tipo, contacto, morada, numeroCC, estado) 
VALUES (seq_utilizador.NEXTVAL, 'Carlos Sousa', 'Leitor', '911654987', 'Rua A, 123', '12345', 'Ativo');

INSERT INTO utilizador (id_utilizador, nome, tipo, contacto, morada, numeroCC, estado) 
VALUES (seq_utilizador.NEXTVAL, 'Maria Oliveira', 'Leitor', '927654321', 'Rua B, 456', '222222222', 'Suspenso');

INSERT INTO utilizador (id_utilizador, nome, tipo, contacto, morada, numeroCC, estado) 
VALUES (seq_utilizador.NEXTVAL, 'Ana Costa', 'Leitor', '936789123', 'Rua C, 789', '333333333', 'Inativo');

INSERT INTO utilizador (id_utilizador, nome, tipo, contacto, morada, numeroCC, estado) 
VALUES (seq_utilizador.NEXTVAL, 'Pedro Santos', 'Leitor', '949123456', 'Rua D, 012', '444444444', 'Ativo');

INSERT INTO utilizador (id_utilizador, nome, tipo, contacto, morada, numeroCC, estado) 
VALUES (seq_utilizador.NEXTVAL, 'Gestor Biblioteca', 'Bibliotecário', '953456789', 'Rua E, 345', '54321', 'Ativo');



-- Populando tabela "emprestimo"
INSERT INTO emprestimo (id_emprestimo, id_livro, id_utilizador, dataEmprestimo, dataDevolucao, estado) 
VALUES (seq_emprestimo.NEXTVAL, 1, 1, SYSDATE - 10, SYSDATE - 2, 'Devolvido');

INSERT INTO emprestimo (id_emprestimo, id_livro, id_utilizador, dataEmprestimo, dataDevolucao, estado) 
VALUES (seq_emprestimo.NEXTVAL, 2, 2, SYSDATE - 8, NULL, 'Ativo');

INSERT INTO emprestimo (id_emprestimo, id_livro, id_utilizador, dataEmprestimo, dataDevolucao, estado) 
VALUES (seq_emprestimo.NEXTVAL, 3, 3, SYSDATE - 15, SYSDATE - 1, 'Devolvido');

INSERT INTO emprestimo (id_emprestimo, id_livro, id_utilizador, dataEmprestimo, dataDevolucao, estado) 
VALUES (seq_emprestimo.NEXTVAL, 3, 4, SYSDATE - 5, NULL, 'Atrasado');

INSERT INTO emprestimo (id_emprestimo, id_livro, id_utilizador, dataEmprestimo, dataDevolucao, estado) 
VALUES (seq_emprestimo.NEXTVAL, 4, 1, SYSDATE - 3, NULL, 'Ativo');



-- Populando tabela "reserva"
INSERT INTO reserva (id_reserva, id_livro, id_utilizador, data_reserva, estado) 
VALUES (seq_reserva.NEXTVAL, 1, 2, SYSDATE - 5, 'Confirmada');

INSERT INTO reserva (id_reserva, id_livro, id_utilizador, data_reserva, estado) 
VALUES (seq_reserva.NEXTVAL, 2, 3, SYSDATE - 6, 'Pendente');

INSERT INTO reserva (id_reserva, id_livro, id_utilizador, data_reserva, estado) 
VALUES (seq_reserva.NEXTVAL, 3, 5, SYSDATE - 7, 'Cancelada');

INSERT INTO reserva (id_reserva, id_livro, id_utilizador, data_reserva, estado) 
VALUES (seq_reserva.NEXTVAL, 5, 4, SYSDATE - 8, 'Confirmada');

INSERT INTO reserva (id_reserva, id_livro, id_utilizador, data_reserva, estado) 
VALUES (seq_reserva.NEXTVAL, 4, 1, SYSDATE - 9, 'Pendente');


-- Populando tabela "multa"
INSERT INTO multa (id_multa, id_utilizador, valor, data_aplicacao, estado) 
VALUES (seq_multa.NEXTVAL, 1, 2.50, SYSDATE - 2, 'Pendente');

INSERT INTO multa (id_multa, id_utilizador, valor, data_aplicacao, estado) 
VALUES (seq_multa.NEXTVAL, 2, 5.00, SYSDATE - 1, 'Pago');

INSERT INTO multa (id_multa, id_utilizador, valor, data_aplicacao, estado) 
VALUES (seq_multa.NEXTVAL, 3, 1.50, SYSDATE - 10, 'Pago');

INSERT INTO multa (id_multa, id_utilizador, valor, data_aplicacao, estado) 
VALUES (seq_multa.NEXTVAL, 4, 2.00, SYSDATE - 3, 'Pendente');

INSERT INTO multa (id_multa, id_utilizador, valor, data_aplicacao, estado) 
VALUES (seq_multa.NEXTVAL, 5, 3.00, SYSDATE - 4, 'Pendente');

COMMIT;