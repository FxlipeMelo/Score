Titulo: Classe associativa TeamRoster
Status: Aceito
Contexto: Precisávamos decidir entre relacionamento many to many entre as classe Team e Player ou uma classe associativa
Decisão: Decidimos classe associativa por pode conter dados que não pertencem a Team e nem Player.
Consequência: Exemplo a numeração da camisa, pertence à relação entre o Player e Team em um momento especifico, porém temos que criar uma tabela a mais no banco de dados.
Alternativas: Relação many to many.