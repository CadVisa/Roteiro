<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CadVisa</title>
</head>
<body>
    <p>#: {{ $contato->id }}</p>
    <p>Data: {{ \Carbon\Carbon::parse($contato->data_mensagem)->format('d/m/Y H:i:s') }}</p>
    <p>Nome: {{ $contato->nome }}</p>
    <p>E-mail: {{ $contato->email }}</p>
    <p>Telefone: {{ $contato->telefone }}</p>
    <p>Mensagem: {{ $contato->descricao }}</p>
    <p>IP: {{ $contato->ip }}</p>    
</body>
</html>