-- 1. Listar todos os livros disponíveis, ordenados por título
SELECT * 
FROM livro 
WHERE estado = 'Disponivel' 
ORDER BY titulo ASC;

-- 3. Obter o título e o autor dos livros reservados por leitores com estado 'Ativo' (Subquery)
SELECT l.titulo, l.autor
FROM livro l
WHERE l.id_livro IN (
    SELECT r.id_livro
    FROM reserva r
    JOIN utilizador u ON r.id_utilizador = u.id_utilizador
    WHERE u.estado = 'Ativo' AND r.estado = 'Confirmada'
);

-- 4. Listar os leitores que possuem empréstimos ativos, ordenados pelo nome (ORDER BY)
SELECT DISTINCT u.nome
FROM utilizador u
JOIN emprestimo e ON u.id_utilizador = e.id_utilizador
WHERE e.estado = 'Ativo'
ORDER BY u.nome;

-- 5. Contar o número total de cópias disponíveis por gênero de livros (GROUP BY)
SELECT genero, SUM(numeroCopias) AS total_disponiveis
FROM livro
WHERE estado = 'Disponivel'
GROUP BY genero;

-- 7. Listar os empréstimos atrasados e o nome dos leitores responsáveis
SELECT e.id_emprestimo, l.titulo, u.nome, e.dataEmprestimo, e.estado
FROM emprestimo e
JOIN livro l ON e.id_livro = l.id_livro
JOIN utilizador u ON e.id_utilizador = u.id_utilizador
WHERE e.estado = 'Atrasado';

-- 8. Obter multas pendentes aplicadas nos últimos 7 dias, agrupadas por usuário (GROUP BY)
SELECT u.nome, COUNT(m.id_multa) AS qtd_multas, SUM(m.valor) AS total_valor
FROM multa m
JOIN utilizador u ON m.id_utilizador = u.id_utilizador
WHERE m.estado = 'Pendente' AND m.data_aplicacao >= SYSDATE - 7
GROUP BY u.nome;

-- 9. Listar os livros emprestados, incluindo o estado de devolução e ordenados pela data de empréstimo (ORDER BY)
SELECT l.titulo, e.dataEmprestimo, e.dataDevolucao, e.estado
FROM emprestimo e
JOIN livro l ON e.id_livro = l.id_livro
ORDER BY e.dataEmprestimo DESC;

-- 10. Verificar o estado do livro mais reservado pelos leitores (Subquery com ORDER BY)
SELECT l.titulo, l.estado, total_reservas
FROM (
    SELECT r.id_livro, COUNT(*) AS total_reservas
    FROM reserva r
    GROUP BY r.id_livro
    ORDER BY total_reservas DESC
    FETCH FIRST 1 ROWS ONLY
) top_reserva
JOIN livro l ON l.id_livro = top_reserva.id_livro;

-- 11 EXTRA subqueries
-- A primeira subconsulta pode ser usada para encontrar todos os livros que não estão emprestados, ou seja, que não estão presentes na tabela emprestimo com estado "Ativo".
SELECT titulo, autor, estado
FROM livro
WHERE id_livro NOT IN (
    SELECT id_livro
    FROM emprestimo
    WHERE estado = 'Ativo'
);


-- verifica de todos os livros, os livros que estao emprestados e que nao tem mais copias disponiveis
SELECT id_livro, titulo, numeroCopias
FROM livro
WHERE id_livro IN (
    SELECT id_livro
    FROM emprestimo
    WHERE estado = 'Ativo'
)
AND numeroCopias <= 0;



