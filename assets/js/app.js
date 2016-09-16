"use strict";
this.App = angular.module("app", []);

this.App.controller('PageController', function($scope, $http) {
  return $http.get('https://raw.githubusercontent.com/pedrorocha-net/' + 'eleicoes2016-rj-comparadoacoes/master/data/candidatos.json').then(function(result) {
    $scope.candidatos = result.data;
    return console.log($scope.candidatos);
  });
});
