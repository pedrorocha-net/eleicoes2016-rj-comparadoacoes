<?php

include_once './Utils.php';
include_once './Cidade.php';
include_once './Candidato.php';
include_once './Doacao.php';

$arquivo_processado = 'candidatos_dados_processados.json';

/**
 * Para alterar para outras cidades, leia as intruções em
 * https://github.com/pedrorocha-net/eleicoes2016-rj-comparadoacoes
 */
$ano = 2016;
$cidade_id = 60011; // Rio de Janeiro - RJ
$eleicao_id = 2; // 2016
$cargo_id = 11; // Prefeito
$Cidade = new Cidade($ano, $cidade_id, $eleicao_id, $cargo_id);

// Apagar conteúdo sobre candidatos
file_put_contents('../' . $arquivo_processado, '');

$candidatos_novo = [];

foreach ($Cidade->candidatos as $candidato_obj) {
  $Candidato = new Candidato($ano, $cidade_id, $eleicao_id, $candidato_obj->id);

  $item_candidato = [];
  $item_candidato['id'] = $candidato_obj->id;
  $item_candidato['nome'] = $candidato_obj->nomeUrna;
  $item_candidato['numero'] = $candidato_obj->numero;
  $item_candidato['partido'] = $candidato_obj->partido;
  $item_candidato['slogan'] = $candidato_obj->nomeColigacao;
  $item_candidato['contribuicoesEstimadasTotal'] = 0;
  $item_candidato['contribuicoesEstimadasQtd'] = 0;
  $item_candidato['contribuicoesFinanceirasPFTotal'] = 0;
  $item_candidato['contribuicoesFinanceirasPFQtd'] = 0;
  $item_candidato['fundoPartidario'] = 0;
  $item_candidato['fundoPartidarioQtd'] = 0;
  $receitas = $Candidato->getReceitas();

  $doacoes = [];
  foreach ($receitas as $receita) {
    $Doacao = new Doacao($receita);
    $doacao_formatada = $Doacao->formatar();
    if ($doacao_formatada['especieRecurso'] != 'Estimado') {
      if ($doacao_formatada['fonteOrigem'] == 'Fundo Partidário') {
        $item_candidato['fundoPartidario'] += $doacao_formatada['valorReceita'];
        $item_candidato['fundoPartidarioQtd']++;
      }
      else {
        $item_candidato['contribuicoesFinanceirasPFQtd']++;
        $item_candidato['contribuicoesFinanceirasPFTotal'] += $doacao_formatada['valorReceita'];

        if (isset($doacoes[$doacao_formatada['nomeDoador']])) {
          $doacoes[$doacao_formatada['nomeDoador']]['valorReceita'] += $doacao_formatada['valorReceita'];
        }
        else {
          $doacoes[$doacao_formatada['nomeDoador']] = $doacao_formatada;
        }
      }
    }
    else {
      $item_candidato['contribuicoesEstimadasTotal'] += $doacao_formatada['valorReceita'];
      $item_candidato['contribuicoesEstimadasQtd']++;
    }
  }

  if ($item_candidato['contribuicoesFinanceirasPFQtd'] > 0) {
    $item_candidato['apoioMedio'] = $item_candidato['contribuicoesFinanceirasPFTotal'] / $item_candidato['contribuicoesFinanceirasPFQtd'];
  }
  else {
    $item_candidato['apoioMedio'] = $item_candidato['contribuicoesFinanceirasPFTotal'];
  }

  $doacoes = array_values($doacoes);

  usort($doacoes, function ($a, $b) {
    return $b['valorReceita'] - $a['valorReceita'];
  });

  $item_candidato['maioresApoiadores'] = array_slice($doacoes, 0, 10);
  $candidatos_novo[] = $item_candidato;
}

$json_code = json_encode($candidatos_novo);

file_put_contents('../' . $arquivo_processado, $json_code);

?>