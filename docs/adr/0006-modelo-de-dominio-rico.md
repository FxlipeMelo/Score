Titulo: Modelo de Domínio Rico.
Status: Aceito.
Contexto: Não podíamos deixar a classe instanciar com seus atributos nulos, então precisamos usar o __construct para inicializar todos os atributos.
Decisão: Decidimos excluir todos os setters que não possuíam regras de negócios.
Consequência: Com isso não tem como alterar um dados sem querer ou deixar o encapsulamento com a privacidade errada.
Alternativa: Não deletar e continuar como código morto.