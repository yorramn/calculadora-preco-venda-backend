<h1>Olá, {{$user->social_name ?? $user->name}}!</h1>
<p>Clique no link a seguir para ser redirecionado para a página de recuperação de senha.</p>
<a href="{{$link}}" target="_blank">Clique aqui</a>
