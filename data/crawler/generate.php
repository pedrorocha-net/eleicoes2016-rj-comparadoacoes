<?php

include_once './Utils.php';
include_once './Candidato.php';

$doacoes = [];

$candidatos = json_decode(file_get_contents('../candidatos.json'));

foreach ($candidatos as $candidato_obj) {
  $Candidato = new Candidato($candidato_obj->id);

  $receitas = $Candidato->getReceitas();
  foreach ($receitas as $receita) {
    $doacao = [];
    $doacao['candidato_id'] = $candidato_obj->id;
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