CREATE OR REPLACE TRIGGER update_estado_apos_emprestimo 
BEFORE INSERT ON emprestimo 
FOR EACH ROW 
BEGIN 
    UPDATE livro 
    SET estado = CASE 
                     WHEN numeroCopias - 1 = 0 THEN 'Emprestado'
                     ELSE estado
                 END,
        numeroCopias = numeroCopias - 1 
    WHERE id_livro = :NEW.id_livro AND numeroCopias > 0;
    IF SQL%ROWCOUNT = 0 THEN 
        RAISE_APPLICATION_ERROR(-20003, 'Livro não disponível para empréstimo.');
    END IF; 
END;
/

CREATE OR REPLACE TRIGGER update_estado_apos_devolucao 
BEFORE UPDATE ON emprestimo 
FOR EACH ROW 
WHEN (NEW.estado = 'Devolvido') 
BEGIN 
    UPDATE livro  
    SET estado = 'Disponivel', numeroCopias = numeroCopias + 1 
    WHERE id_livro = :NEW.id_livro;
    IF SQL%ROWCOUNT = 0 THEN 
        RAISE_APPLICATION_ERROR(-20004, 'Erro ao atualizar o estado do livro.');
END IF; 
END;
/

CREATE OR REPLACE TRIGGER aplicar_multa_atraso 
AFTER UPDATE ON emprestimo 
FOR EACH ROW 
WHEN (NEW.estado = 'Atrasado' AND NEW.dataDevolucao IS NOT NULL) 
DECLARE 
    valorMulta NUMBER := 0.50; 
    diasAtraso NUMBER; 
BEGIN 
    diasAtraso := TRUNC(:NEW.dataDevolucao - :NEW.dataEmprestimo) - 10;
    IF diasAtraso > 0 THEN 
        INSERT INTO multa (id_multa, id_utilizador, valor)  
        VALUES (seq_multa.NEXTVAL, :NEW.id_utilizador, valorMulta * diasAtraso); 
    END IF; 
END;
/

CREATE OR REPLACE TRIGGER calcelar_reservas_apos_entrada_stock 
AFTER UPDATE ON emprestimo 
FOR EACH ROW 
WHEN (NEW.estado = 'Devolvido') 
BEGIN 
    UPDATE reserva  
    SET estado = 'Cancelada' 
    WHERE id_livro = :NEW.id_livro AND estado = 'Pendente'; 
END;
/


CREATE OR REPLACE TRIGGER prevenir_reserva_livros_danificados 
BEFORE INSERT ON reserva 
FOR EACH ROW 
DECLARE 
    estadoLivro VARCHAR2(20); 
BEGIN 
    SELECT estado INTO estadoLivro FROM livro WHERE id_livro = :NEW.id_livro; 
    IF estadoLivro = 'Danificado' THEN 
        RAISE_APPLICATION_ERROR(-20001, 'Não é possível reservar um livro danificado.'); 
    END IF; 
END;
/

CREATE OR REPLACE TRIGGER suspender_utilizador_com_multas
BEFORE INSERT ON multa
FOR EACH ROW
DECLARE
    numeroMultas NUMBER;
BEGIN
    SELECT COUNT(*)
    INTO numeroMultas
    FROM multa
    WHERE id_utilizador = :NEW.id_utilizador
      AND estado = 'Pendente';
    IF :NEW.estado = 'Pendente' THEN
        numeroMultas := numeroMultas + 1;
    END IF;
    IF numeroMultas >= 3 THEN
        UPDATE utilizador
        SET estado = 'Suspenso'
        WHERE id_utilizador = :NEW.id_utilizador;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER previnir_emprestimos_multiplos 
BEFORE INSERT ON emprestimo 
FOR EACH ROW 
DECLARE 
    emprestimosAtivos NUMBER; 
BEGIN 
    SELECT COUNT(*) INTO emprestimosAtivos 
    FROM emprestimo  
    WHERE id_utilizador = :NEW.id_utilizador AND estado = 'Ativo';
    IF emprestimosAtivos > 0 THEN 
        RAISE_APPLICATION_ERROR(-20002, 'O utilizador já possui um empréstimo ativo.');
    END IF; 
END;
/

COMMIT;


