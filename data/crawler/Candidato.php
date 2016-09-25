<?php

class Candidato {

  public $id,
    $ano,
    $cidade,
    $eleicao_id,
    $detalhes,
    $candidatura,
    $url_base = 'http://divulgacandcontas.tse.jus.br/divulga/rest/v1';

  public function __construct($ano, $cidade, $eleicao_id, $candidato_id) {
    $this->id = $candidato_id;
    $this->ano = $ano;
    $this->cidade = $cidade;
    $this->eleicao_id = $eleicao_id;
    $this->detalhes = $this->getDetalhes();
    $this->candidatura = $this->getCandidatura();
  }

  public function getDetalhes() {
    $path = "$this->url_base/candidatura/buscar";
    $path .= "/$this->ano/$this->cidade/$this->eleicao_id/candidato/$this->id";

    $json = file_get_contents($path);
    return json_decode($json);
  }

  public function getCandidatura() {
    $cargo = $this->detalhes->cargo->codigo;
    $partido_num = $this->detalhes->partido->numero;
    $path = "$this->url_base/prestador/consulta/";
    $path .= "$this->eleicao_id/$this->ano/$this->cidade/$cargo";
    $path .= "/$partido_num/$partido_num/$this->id";

    $json = file_get_contents($path);
    return json_decode($json);
  }

  public function getReceitas() {
    $path = "$this->url_base/prestador/consulta/receitas/$this->eleicao_id";
    $path .= "/" . $this->candidatura->dadosConsolidados->sqPrestadorConta;
    $path .= "/" . $this->candidatura->dadosConsolidados->sqEntregaPrestacao;

    $json = file_get_contents($path);
    return json_decode($json);
  }

  public function getFotoUrl() {
    $path = "$this->url_base/candidatura/buscar/foto";
    $path .= "/$this->eleicao_id/$this->id";
    return $path;
  }

  public function getDadosConsolidados() {
    return $this->candidatura->dadosConsolidados;
  }

}

?>