<?php
    $u = 1;
?>
<h1>A lista de prioridades de {{$user->name}} foi alterada. A nova ordem é:</h1>
@foreach($user->projetos as $i => $projeto)
    @if($projeto->estadoProjeto->id == 1)
        <h2>{{$projeto->nome}} -> {{$u++}}</h2>
    @endif
@endforeach