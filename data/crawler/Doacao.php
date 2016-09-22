<?php

class Doacao {

  public $id,
    $detalhes,
    $candidatos,
    $url_base = 'http://divulgacandcontas.tse.jus.br/divulga/rest/v1';

  public function __construct($obj) {
    $this->obj = $obj;
  }

  /**
   * Por padrão, busca candidatos a prefeito
   * @param int $cargo
   * @param int $ano
   * @return mixed
   */
  public function formatar() {
    $item = [];
    if ($this->obj->nomeDoadorOriginario) {
      $nome_doador = $this->obj->nomeDoadorOriginario;
    }
    else {
      $nome_doador = $this->obj->nomeDoador;
    }
    $item['nomeDoador'] = $nome_doador;
    $item['valorReceita'] = $this->obj->valorReceita;
    return $item;
  }
}

?>