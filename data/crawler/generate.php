<?php

include_once './Utils.php';
include_once './Cidade.php';
include_once './Candidato.php';
include_once './Doacao.php';

$config = json_decode(file_get_contents('../config.json'));

foreach ($config->cidades as $cidade) {

  $Cidade = new Cidade($config->ano, $cidade->id, $config->eleicao_id, $config->cargo_id);

  print "## " . $cidade->nome . " - Iniciando\n";

  $id_json = $config->ano . $config->eleicao_id . $cidade->id . $config->cargo_id;
  $arquivo_processado = 'candidatos_dados_processados_' . $id_json . '.json';

  // Apagar conteúdo sobre candidatos
  file_put_contents('../' . $arquivo_processado, '');

  $candidatos_novo = [];

  foreach ($Cidade->candidatos as $candidato_obj) {
    $Candidato = new Candidato($config->ano, $cidade->id, $config->eleicao_id, $candidato_obj->id);

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

  print "## " . $cidade->nome . " - Concluída\n";
}

?>