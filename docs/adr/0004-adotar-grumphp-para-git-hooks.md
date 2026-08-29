Titulo: Definir GitHook
Status: Aceito
Contexto: Perigo de esquecer de rodar os testes antes do commit e o risco do código ir quebrado para o repositório principal
Decisão: Escolhemos GrumPHP por ser o foco principal em QA
Consequência: A partir de agora, qualquer commit que falhe no PHPUnit será bloqueado localmente.
Alternativas: CaptainHook
