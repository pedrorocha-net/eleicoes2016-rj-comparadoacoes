"use strict"

@App = angular.module("app", ['templates'])


@App.controller 'PageController', ($scope, $http) ->
  $http.get('https://raw.githubusercontent.com/pedrorocha-net/' +
      'eleicoes2016-rj-comparadoacoes/master/data/' +
      'candidatos_dados_processados.json'
  ).then (result) ->
    $scope.candidatos = result.data
    $scope.selecao1 = null
    $scope.selecao2 = null
    $scope.selecao3 = null

    $scope.selecionar = (candidato) ->
      if $scope.selecao1?.id == candidato.id
        $scope.selecao1 = null
        return
      if $scope.selecao2?.id == candidato.id
        $scope.selecao2 = null
        return
      if $scope.selecao3?.id == candidato.id
        $scope.selecao3 = null
        return

      unless $scope?.selecao1
        $scope.selecao1 = candidato
        return
      unless $scope?.selecao1 && $scope?.selecao2
        $scope.selecao2 = candidato
        return
      unless $scope?.selecao1 && $scope?.selecao2 && $scope?.selecao3
        $scope.selecao3 = candidato
        return


@App.directive 'card', () ->
  restrict: 'A'
  scope: {
    ngCandidato: '='
  }
  templateUrl: 'assets/js/card.html'

  link: ($scope, element, attrs)->