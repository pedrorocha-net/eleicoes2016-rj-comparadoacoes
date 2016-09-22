<?php

include_once './Utils.php';
include_once './Cidade.php';
include_once './Candidato.php';
include_once './Doacao.php';

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
  $item['contribuicoesFinanceirasTotal'] = 0;
  $item['contribuicoesFinanceirasQtd'] = 0;
  $item['fundoPartidario'] = 0;
  $item['fundoPartidarioQtd'] = 0;
  $item['pessoasFisicas'] = $Candidato->getDadosConsolidados()->totalReceitaPF + $Candidato->getDadosConsolidados()->totalInternet;
  $item['pessoasFisicasQtd'] = $Candidato->getDadosConsolidados()->qtdReceitaPF + $Candidato->getDadosConsolidados()->qtdInternet;
  $receitas = $Candidato->getReceitas();

  $doacoes = [];
  foreach ($receitas as $receita) {
    $Doacao = new Doacao($receita);
    $doacao_formatada = $Doacao->formatar();
    if ($doacao_formatada['especieRecurso'] != 'Estimado') {
      if ($doacao_formatada['fonteOrigem'] == 'Fundo Partidário') {
        $item['fundoPartidario'] += $doacao_formatada['valorReceita'];
        $item['fundoPartidarioQtd']++;
      }
      else {
        $item['contribuicoesFinanceirasQtd']++;
        $item['contribuicoesFinanceirasTotal'] += $doacao_formatada['valorReceita'];

        if (isset($doacoes[$doacao_formatada['nomeDoador']])) {
          $doacoes[$doacao_formatada['nomeDoador']]['valorReceita'] += $doacao_formatada['valorReceita'];
        }
        else {
          $doacoes[$doacao_formatada['nomeDoador']] = $doacao_formatada;
        }
      }
    }
  }
  $item['apoioMedio'] = $item['contribuicoesFinanceirasTotal'] / $item['contribuicoesFinanceirasQtd'];
  $doacoes = array_values($doacoes);

  usort($doacoes, function ($a, $b) {
    return $b['valorReceita'] - $a['valorReceita'];
  });

  $item['maioresApoiadores'] = array_slice($doacoes, 0, 10);
  $candidatos_novo[] = $item;
}

$json_code = json_encode($candidatos_novo);

file_put_contents('../' . $arquivo_processado, $json_code);

?>