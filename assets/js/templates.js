angular.module("templates", []).run(["$templateCache", function($templateCache) {$templateCache.put("assets/js/card.html","<h2>{{ ngCandidato.nome }}</h2>\n<div>\n  <table class=\"table table-condensed\">\n    <tr>\n      <th>Total arrecadado</th>\n      <td>{{ ngCandidato.totalFinanceiro | currency : \'R$\'}}</td>\n    </tr>\n    <tr>\n      <th>Fundo partidário</th>\n      <td>{{ ngCandidato.fundoPartidario | currency : \'R$\'}}</td>\n    </tr>\n    <tr>\n      <th>Pessoas físicas</th>\n      <td>{{ ngCandidato.pessoasFisicas | currency : \'R$\'}}</td>\n    </tr>\n    <tr>\n      <th>Número de doadores</th>\n      <td>{{ ngCandidato.pessoasFisicasQtd }}</td>\n    </tr>\n    <tr>\n      <th>Apoio médio</th>\n      <td>{{ ngCandidato.apoioMedio | currency : \'R$\'}}</td>\n    </tr>\n  </table>\n  <h3>Maiores apoiadores</h3>\n  <table class=\"table table-condensed\">\n    <tr ng-repeat=\"doacao in ngCandidato.maioresApoiadores\">\n      <td>{{ doacao.nomeDoador }}</td>\n      <td>{{ doacao.valorReceita | currency : \'R$\'}}</td>\n    </tr>\n  </table>\n</div>");}]);