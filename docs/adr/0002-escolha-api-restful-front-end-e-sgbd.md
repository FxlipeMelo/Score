Titulo: Definir Stack Base e Banco de dados.
Status: Aceito.
Contexto: Precisávamos escolher uma ferramenta de SGBD e qual caminho seguir se seria com Twig ou API + framework de front-end.
Decisão: Escolhemos MySQL como SGBD por ser uma Curva de aprendizado reduzida, Integração nativa com o ORM Doctrine do Symfony e Suporte a integridade referencial para modelagem. E vamos seguir o caminho de API + framework de front-end por ser o padrão de ouro no mercado atualmente.
Consequências: Ganhamos com API + framework de front-end nós ganhamos uma experiência de usuário incrível e um Swagger documentado e o contra exige mais maturidade de infraestrutura. Ganhamos com o MySQL facilidade por já conhecer a ferramenta e o contra é que exige Schemas rígidos.
Alternativas: MongoDB e PostgreSQL.