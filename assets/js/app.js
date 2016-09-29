"use strict";
this.App = angular.module("app", ['templates']);

this.App.controller('PageController', function($scope, $http) {
  var base_url, data_url, repo_url, url_json_config;
  base_url = 'https://raw.githubusercontent.com';
  repo_url = 'pedrorocha-net/eleicoes2016-rj-comparadoacoes';
  data_url = base_url + "/" + repo_url + "/master/data";
  url_json_config = data_url + "/config.json";
  $http.get(url_json_config).then(function(configResult) {
    return $scope.config = configResult.data;
  });
  return $scope.$watch('cidade', function(newValue, oldValue) {
    var id_json, url_json_dados;
    if (newValue !== void 0) {
      id_json = ("" + $scope.config.ano + $scope.config.eleicao_id + newValue) + $scope.config.cargo_id;
      url_json_dados = data_url + "/candidatos_dados_processados_" + id_json + ".json";
      return $http.get(url_json_dados).then(function(result) {
        $scope.candidatos = result.data;
        $scope.selecao1 = null;
        $scope.selecao2 = null;
        $scope.selecao3 = null;
        return $scope.selecionar = function(candidato) {
          var ref, ref1, ref2;
          if (((ref = $scope.selecao1) != null ? ref.id : void 0) === candidato.id) {
            $scope.selecao1 = null;
            return;
          }
          if (((ref1 = $scope.selecao2) != null ? ref1.id : void 0) === candidato.id) {
            $scope.selecao2 = null;
            return;
          }
          if (((ref2 = $scope.selecao3) != null ? ref2.id : void 0) === candidato.id) {
            $scope.selecao3 = null;
            return;
          }
          if (!($scope != null ? $scope.selecao1 : void 0)) {
            $scope.selecao1 = candidato;
            return;
          }
          if (!(($scope != null ? $scope.selecao1 : void 0) && ($scope != null ? $scope.selecao2 : void 0))) {
            $scope.selecao2 = candidato;
            return;
          }
          if (!(($scope != null ? $scope.selecao1 : void 0) && ($scope != null ? $scope.selecao2 : void 0) && ($scope != null ? $scope.selecao3 : void 0))) {
            $scope.selecao3 = candidato;
          }
        };
      });
    }
  });
});

this.App.directive('card', function() {
  return {
    restrict: 'A',
    scope: {
      ngCandidato: '='
    },
    templateUrl: 'assets/js/card.html',
    link: function($scope, element, attrs) {}
  };
});
