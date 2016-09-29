"use strict"

@App = angular.module("app", ['templates'])


@App.controller 'PageController', ($scope, $http) ->
  base_url = 'https://raw.githubusercontent.com/'
  repo_url = 'pedrorocha-net/eleicoes2016-rj-comparadoacoes'
  data_url = "#{base_url}/#{repo_url}/master/data"

  url_json_config = "#{data_url}/config.json"

  $http.get(url_json_config).then (config) ->
    $scope.config = result.data


  $scope.$watch 'cidade', (newValue, oldValue) ->
    url_json_dados = "#{data_url}/candidatos_dados_processados.json"
    $http.get(url_json_dados).then (result) ->
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