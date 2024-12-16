-- Querie 1
CREATE INDEX idx_livro_estado_titulo ON livro (estado, titulo);

-- Querie 2
CREATE BITMAP INDEX idx_utilizador_estado ON utilizador (estado);
CREATE INDEX idx_reserva_idLivro_estado ON reserva (id_livro, estado);

-- Querie 3
CREATE INDEX idx_emprestimo_estado_idUtilizador ON emprestimo (estado, id_utilizador);

-- Querie 4
CREATE BITMAP INDEX idx_livro_estado_genero ON livro (estado, genero);

-- Querie 5
CREATE BITMAP INDEX idx_emprestimo_estado ON emprestimo (estado);
CREATE INDEX idx_livro_idTitulo ON livro (id_livro, titulo);

-- Querie 6
CREATE BITMAP INDEX idx_multa_estado ON multa (estado);
CREATE INDEX idx_multa_dataAplicacao ON multa (data_aplicacao);

-- Querie 7
CREATE INDEX idx_emprestimo_dataEmprestimo_idLivro ON emprestimo (dataEmprestimo, id_livro);

-- Querie 8
CREATE INDEX idx_reserva_id_livro ON reserva(id_livro);

-- Querie 9
CREATE INDEX idx_emprestimo_id_livro_estado ON emprestimo(id_livro, estado);

-- Querie 10
CREATE INDEX idx_emprestimo_estado_id_livro ON emprestimo(estado, id_livro);
CREATE INDEX idx_livro_id_livro_numeroCopias ON livro(id_livro, numeroCopias);


