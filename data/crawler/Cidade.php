<?php

class Cidade {

  public $id,
    $detalhes,
    $candidatos,
    $url_base = 'http://divulgacandcontas.tse.jus.br/divulga/rest/v1';

  public function __construct($id) {
    $this->id = $id;
    $dados = $this->getDetalhes(11, 2016);
    $this->detalhes = $dados->unidadeEleitoral;
    $this->candidatos = $dados->candidatos;
  }

  /**
   * Por padrão, busca candidatos a prefeito
   * @param int $cargo
   * @param int $ano
   * @return mixed
   */
  public function getDetalhes($cargo = 11, $ano = 2016) {
    $path = $this->url_base
      . "/candidatura/listar/$ano/$this->id/2/$cargo/candidatos";
    $json = file_get_contents($path);
    return json_decode($json);
  }
}

?>