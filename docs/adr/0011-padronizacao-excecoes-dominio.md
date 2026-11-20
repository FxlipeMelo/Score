Titulo: Alterar exceções do domínio
Status: Aceito.
Contexto: Com o domínio lançando exceção InvalidArgument, estavamos que traduzir a exceção no handler.
Decisão: Decidimos refatorar onde estava essas exceções e padronizamos para a regra do nosso negócio.
Consequência: Remoção de try/catch reduntates deixado de traduzir exceções nos handlers.
Alternativas: Continuar usando a tradução.
