"use strict"

@App = angular.module("app", [])

@App.controller 'PageController', ($scope, $http) ->
  $http.get('https://raw.githubusercontent.com/pedrorocha-net/' +
      'eleicoes2016-rj-comparadoacoes/master/data/candidatos.json'
  ).then (result) ->
    $scope.candidatos = result.data