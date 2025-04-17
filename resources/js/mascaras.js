$(document).ready(function() {
    $(['#codigo_pesquisa', '#codigo_cnae']).mask('0000-0/00');
    $('#telefone').mask('00 0.0000-0000');
    $(['#cnpj', '#cnpj_pesquisa']).mask('00.000.000/0000-00');
});