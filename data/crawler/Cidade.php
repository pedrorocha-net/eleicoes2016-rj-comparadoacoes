<?php

class Cidade {

  public $id,
    $detalhes,
    $candidatos,
    $url_base = 'http://divulgacandcontas.tse.jus.br/divulga/rest/v1';

  public function __construct($ano, $id, $eleicao_id, $cargo_id) {
    $this->id = $id;
    $dados = $this->getDetalhes($cargo_id, $ano, $eleicao_id);
    $this->detalhes = $dados->unidadeEleitoral;
    $this->candidatos = $dados->candidatos;
  }

  /**
   * Por padrão, busca candidatos a prefeito
   * @param int $cargo_id
   * @param int $ano
   * @param int $eleicao_id
   * @return mixed
   */
  public function getDetalhes($cargo_id, $ano, $eleicao_id) {
    $path = "$this->url_base/candidatura/listar/";
    $path .= "$ano/$this->id/$eleicao_id/$cargo_id/candidatos";

    $json = file_get_contents($path);
    return json_decode($json);
  }
}

?>