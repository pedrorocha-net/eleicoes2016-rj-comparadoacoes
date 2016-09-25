# Sobre o projeto

O TSE(Tribunal Superior Eleitoral) libera dados sobre todas as candidaturas no Brasil, sendo que uma em particular
é muito interessante, a de doações, onde podemos ver quem são aqueles que financiam os políticos.

Partindo desse ponto, esse projeto é para fornecer um comparador de doações de campanha entre candidatos a prefeito
do Rio de Janeiro, facilitando visualizar diferenças na forma como cada um está bancando sua campanha.

# Requerimentos

- PHP 5.4 ou mais novo.

# Detalhes técnicos para quem quiser ajudar ou forkar para outra cidade

## Preparar ambiente
- Rode `npm install` na pasta do projeto

## Como encontrar o ID da sua cidade?

- Accesse a URL `http://divulgacandcontas.tse.jus.br/divulga/rest/v1/eleicao/buscar/{SIGLA}/2/municipios` após substituir sigla pelo seu município (RJ para Rio de Janeiro, SP para São Paulo...)
- Na lista JSON que for retornada, procure pela sua cidade e use o ID;
- Antes de rodar o crawler, procure ela variável `$cidade_id` e atribua o ID da sua cidade.

## Portando para minha cidade

- Substitua o ID da sua cidade como explicado acima;
- Rode o Crawler(veja abaixo);
- Substitua a URL em `$http.get` no arquivo `src/assets/app.coffee`  para apontar para o seu Javascript

## Como rodar o crawler
Estando na pasta `/data/crawler`, execute `php generate.php` e o arquivo `/data/candidatos_dados_processados.json` será atualizado.


## Como executar?
- Abra `dist/index.html` no seu navegador.


## Como subir as mudanças para o Github Pages?
- Na pasta raiz do projeto, rode `gulp deploy`
