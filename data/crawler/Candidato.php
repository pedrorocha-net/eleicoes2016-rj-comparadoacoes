<?php

class Candidato {

  public $id,
    $detalhes,
    $candidatura,
    $url_base = 'http://divulgacandcontas.tse.jus.br/divulga/rest/v1';

  public function __construct($id) {
    $this->id = $id;
    $this->detalhes = $this->getDetalhes();
    $this->candidatura = $this->getCandidatura();
  }

  public function getDetalhes() {
    $path = "$this->url_base/candidatura/buscar/2016/60011/2/candidato/";
    $json = file_get_contents($path . $this->id);
    return json_decode($json);
  }

  public function getCandidatura() {
    $cargo = 11; //Prefeito
    $path = "$this->url_base/prestador/consulta/2/2016/60011/$cargo/";
    $path .= $this->detalhes->partido->numero . '/';
    $path .= $this->detalhes->partido->numero . '/';
    $path .= $this->id;
    $json = file_get_contents($path);
    return json_decode($json);
  }

  public function getReceitas() {
    $path = "$this->url_base/prestador/consulta/receitas/2/";
    $path .= $this->candidatura->dadosConsolidados->sqPrestadorConta . '/';
    $path .= $this->candidatura->dadosConsolidados->sqEntregaPrestacao;
    $json = file_get_contents($path);
    return json_decode($json);
  }

  public function getFotoUrl() {
    $path = "$this->url_base/candidatura/buscar/foto/2/" . $this->id;
    return $path;
  }

}

?>