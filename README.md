# Sobre o projeto
O TSE(Tribunal Superior Eleitoral) libera dados sobre todas as candidaturas no Brasil, sendo que uma em particular
é muito interessante, a de doações, onde podemos ver quem são aqueles que financiam os políticos.

Partindo desse ponto, esse projeto é para fornecer um comparador de doações de campanha entre candidatos a prefeito
do Rio de Janeiro, facilitando visualizar diferenças na forma como cada um está bancando sua campanha.

Você pode acessar o projeto em http://pedrorocha-net.github.io/eleicoes2016-rj-comparadoacoes/

# Requerimentos
- PHP 5.4 ou mais novo.
- Node.JS

# Detalhes técnicos para quem quiser ajudar ou forkar para outra cidade

## Preparar ambiente
- Instalar NPM(Node Package Manager - https://docs.npmjs.com/cli/install) em sua máquina
- Rodar `npm install` na pasta do projeto
- Rodar `gulp build` na pasta do projeto, para gerar a pasta `dist`
- Se quiser alterar algo, rode `gulp` somente, que ele ficará observando as mudanças na pasta `src` (tanto HTML quanto Coffescript e SASS) e atualizará a `dist`

## Como ter minha cidade também?
- Crie uma issue aqui no Github(https://github.com/pedrorocha-net/eleicoes2016-rj-comparadoacoes/issues/new)

## Como encontrar o ID da sua cidade?
- Accesse a URL `http://divulgacandcontas.tse.jus.br/divulga/rest/v1/eleicao/buscar/{SIGLA}/2/municipios` após substituir sigla pelo seu município (RJ para Rio de Janeiro, SP para São Paulo...)
- Na lista JSON que for retornada, procure pela sua cidade e seu codigo

## Como rodar o crawler
Estando na pasta `/data/crawler`, execute `php generate.php`, que serão atualizados os arquivos de todas as cidades listadas no arquivo `config.json`.

## Como executar?
- Abra `dist/index.html` no seu navegador.
