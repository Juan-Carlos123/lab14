@extends('layouts.app')

@section('content')
<div class="container">


@if(Session::has('Mensaje'))

<div class="alert alert-success" role="alert">
{{
    Session::get('Mensaje')
    
}}
</div>
@endif
<a href="{{url('contactos/create')}}" class="btn btn-danger">Registrar Contacto</a>
<br/>
<br/>

<table border="10" class="table table-light table-hover">

    <thead class="thead-light">
        <tr>
            <th>Id</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Fecha de Nacimiento</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
    @foreach($contactos as $contacto)
        <tr>
            <td>{{$loop->iteration}}</td>

            <td>

            <img src="{{$contacto->Foto}}" class="img-thumbnail img-fluid" alt="" width="100">
        
            
            </td>
            <td>{{$contacto->Nombre}}</td>
            <td>{{$contacto->Apellido}}</td>
            <td>{{$contacto->Correo}}</td>
            <td>{{$contacto->Fecha}}</td>
            <td>
            
            <a class="btn btn-secondary" href="{{ url('/contactos/'.$contacto->id.'/edit')}}">
            Editar
            </a>            
            <form method="post" action="{{ url('/contactos/'.$contacto->id)}}" style="display:inline">
            {{csrf_field()}}
            {{ method_field('DELETE')}}
            <button class="btn btn-dark" type="submit" onclick="return confirm('¿Borrar?');">Borrar</button>

            </form>
            
            </td>
        </tr>
    @endforeach
    </tbody>

</table>

{{ $contactos->links() }}
</div>
@endsection