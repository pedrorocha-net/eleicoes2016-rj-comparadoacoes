<?php

class Utils {

  /**
   * Retorna os campos existentes na API do TSE para cada doação
   * @return array
   */
  static public function getItensDoacao() {
    $items_doacao = [];
    $items_doacao[] = ['id' => 'cpfCnpjDoador', 'nome' => 'CPF'];
    $items_doacao[] = ['id' => 'nomeDoador', 'nome' => 'Nome'];
    $items_doacao[] = [
      'id' => 'cpfCnpjDoadorOriginario',
      'nome' => 'CPF/CNPJ Originário'
    ];
    $items_doacao[] = [
      'id' => 'nomeDoadorOriginario',
      'nome' => 'Nome Doador Originário'
    ];
    $items_doacao[] = ['id' => 'nrReciboEleitoral', 'nome' => 'Nr Recibo'];
    $items_doacao[] = ['id' => 'nrDocumento', 'nome' => 'Nr Doc'];
    $items_doacao[] = ['id' => 'dtReceita', 'nome' => 'Data'];
    $items_doacao[] = ['id' => 'valorReceita', 'nome' => 'Valor'];
    $items_doacao[] = ['id' => 'especieRecurso', 'nome' => 'Especie'];
    $items_doacao[] = ['id' => 'fonteOrigem', 'nome' => 'Fonte Origem'];
    return $items_doacao;
  }

}

?>