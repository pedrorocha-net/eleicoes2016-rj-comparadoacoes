<?php

class Utils {

  /**
   * Lista de candidatos á prefeito do Rio de Janeiro em 2016, com seus dados
   * básicos do sistema do TSE
   * @return array
   */
  static public function getCandidatos() {
    $candidatos = [];
    $candidatos[] = [
      'num' => '18',
      'partido' => 'REDE',
      'slogan' => 'TODOS PELO RIO',
      'nome' => 'ALESSANDRO MOLON',
      'id' => '190000018866',
    ];
    $candidatos[] = [
      'num' => '30',
      'partido' => 'NOVO',
      'slogan' => 'NOVO',
      'nome' => 'CARMEN MIGUELES',
      'id' => '190000007450',
    ];
    $candidatos[] = [
      'num' => '10',
      'partido' => 'PRB',
      'slogan' => 'POR UM RIO MAIS HUMANO',
      'nome' => 'CRIVELLA',
      'id' => '190000017952',
    ];
    $candidatos[] = [
      'num' => '16',
      'partido' => 'PSTU',
      'slogan' => 'PSTU',
      'nome' => 'CYRO GARCIA',
      'id' => '190000019572',
    ];
    $candidatos[] = [
      'num' => '20',
      'partido' => 'PSC',
      'slogan' => 'O RIO PRECISA DE FORÇA PARA MUDAR',
      'nome' => 'FLÁVIO BOLSONARO',
      'id' => '190000011736',
    ];
    $candidatos[] = [
      'num' => '55',
      'partido' => 'PSD',
      'slogan' => 'JUNTOS PELO CARIOCA',
      'nome' => 'INDIO DA COSTA',
      'id' => '190000024651',
    ];
    $candidatos[] = [
      'num' => '65',
      'partido' => 'PC DO B',
      'slogan' => 'RIO EM COMUM',
      'nome' => 'JANDIRA FEGHALI',
      'id' => '190000007222',
    ];
    $candidatos[] = [
      'num' => '50',
      'partido' => 'PSOL',
      'slogan' => 'MUDAR É POSSÍVEL',
      'nome' => 'MARCELO FREIXO',
      'id' => '190000003384',
    ];
    $candidatos[] = [
      'num' => '45',
      'partido' => 'PSDB',
      'slogan' => 'RIO DE OPORTUNIDADES E DIREITOS',
      'nome' => 'OSORIO',
      'id' => '190000011364',
    ];
    $candidatos[] = [
      'num' => '15',
      'partido' => 'PMDB',
      'slogan' => 'JUNTOS PELO RIO',
      'nome' => 'PEDRO PAULO',
      'id' => '190000008414',
    ];
    $candidatos[] = [
      'num' => '29',
      'partido' => 'PCO',
      'slogan' => 'PCO',
      'nome' => 'THELMA BASTOS',
      'id' => '190000024265',
    ];
    return $candidatos;
  }

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