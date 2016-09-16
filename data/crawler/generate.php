<?php

include_once './Utils.php';
include_once './Candidato.php';

$doacoes = [];

foreach (Utils::getCandidatos() as $candidato) {
  $Candidato = new Candidato($candidato['id']);

  $receitas = $Candidato->getReceitas();
  foreach ($receitas as $receita) {
    $doacao = [];
    $doacao['candidato_id'] = $candidato['id'];
    $doacao['candidato_nome'] = $Candidato->detalhes->nomeUrna;
    $doacao['partido_id'] = $Candidato->candidatura->nrCandidato;
    $doacao['partido_nome'] = $Candidato->candidatura->siglaPartido;
    foreach (Utils::getItensDoacao() as $item) {
      $doacao[$item['id']] = $receita->{$item['id']};
    }
    $doacoes[] = $doacao;
  }
}

$json_code = json_encode($doacoes);

file_put_contents('../doacoes_geral.json', $json_code);

?>