<?php

include_once './Utils.php';
include_once './Cidade.php';
include_once './Candidato.php';

$arquivo_processado = 'candidatos_dados_processados.json';

/**
 * Códigos das cidades podem ser vistos na URL abaixo(atenção ao código do
 * estado):
 * http://divulgacandcontas.tse.jus.br/divulga/rest/v1/eleicao/buscar/RJ/2/municipios
 */
$codigo_cidade = 60011; // Rio de Janeiro - RJ
$Cidade = new Cidade($codigo_cidade);

// Apagar conteúdo sobre candidatos
file_put_contents('../' . $arquivo_processado, '');

$candidatos_novo = [];

foreach ($Cidade->candidatos as $candidato_obj) {
  $Candidato = new Candidato($candidato_obj->id);

  $item = [];
  $item['id'] = $candidato_obj->id;
  $item['nome'] = $candidato_obj->nomeUrna;
  $item['numero'] = $candidato_obj->numero;
  $item['partido'] = $candidato_obj->partido;
  $item['slogan'] = $candidato_obj->nomeColigacao;
  $item['totalArrecadado'] = $Candidato->getDadosConsolidados()->totalRecebido;
  $item['fundoPartidario'] = $Candidato->getDadosConsolidados()->totalPartidos;
  $item['pessoasFisicas'] = $Candidato->getDadosConsolidados()->totalReceitaPF;
  $item['numeroDoadores'] = $Candidato->getDadosConsolidados()->qtdRecebido;
  $item['apoioMedio'] = $item['totalArrecadado'] / $item['numeroDoadores'];
  $receitas = $Candidato->getReceitas();

  $doacoes = [];
  foreach ($receitas as $receita) {
    $doacao = [];
    $doacao['nrReciboEleitoral'] = $receita->nrReciboEleitoral;
    $doacao['dtReceita'] = $receita->dtReceita;
    $doacao['nomeDoador'] = $receita->nomeDoador;
    $doacao['valorReceita'] = $receita->valorReceita;
    $doacoes[] = $doacao;
  }

  usort($doacoes, function ($a, $b) {
    return $b['valorReceita'] - $a['valorReceita'];
  });

  $item['maioresApoiadores'] = array_slice($doacoes, 0, 10);
  $candidatos_novo[] = $item;
}

$json_code = json_encode($candidatos_novo);

file_put_contents('../' . $arquivo_processado, $json_code);

?>