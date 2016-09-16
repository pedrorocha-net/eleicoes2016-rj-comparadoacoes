<?php

include_once './Utils.php';
include_once './Candidato.php';

$doacoes = [];

$candidatos = json_decode(file_get_contents('../candidatos.json'));

// Apagar conteúdo sobre candidatos
file_put_contents('../candidatos.json', '');

$candidatos_novo = [];

foreach ($candidatos as $candidato_obj) {
  $Candidato = new Candidato($candidato_obj->id);

  $item = [];
  $item['id'] = $candidato_obj->id;
  $item['nome'] = $candidato_obj->nome;
  $item['numero'] = $candidato_obj->numero;
  $item['partido'] = $candidato_obj->partido;
  $item['slogan'] = $candidato_obj->slogan;
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

  $item['maioresApoiadores'] = array_slice($doacoes, 0, 5);
  $candidatos_novo[] = $item;
}

$json_code = json_encode($candidatos_novo);

file_put_contents('../candidatos.json', $json_code);

?>