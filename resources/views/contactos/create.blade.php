@extends('layouts.app')

@section('content')
<div class="container">

<form action="{{ url('/contactos')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
@include('contactos.form',['Modo'=>'crear'])



</form>
</div>
@endsection