#: {{ $contato->id }}
Data: {{ \Carbon\Carbon::parse($contato->data_mensagem)->format('d/m/Y H:i:s') }}
Nome: {{ $contato->nome }}
E-mail: {{ $contato->email }}
Telefone: {{ $contato->telefone }}
Mensagem: {{ $contato->descricao }}
IP: {{ $contato->ip }}