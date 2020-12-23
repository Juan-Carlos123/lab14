<div class="form-group">
<label for="Nombre" class="control-label">{{'Nombre'}}</label>
<input type="text" class="form-control" name="Nombre" id="Nombre" value="{{ isset($contacto->Nombre)?$contacto->Nombre:''}}">
</div>

<div class="form-group">
<label for="Apellido" class="control-label">{{'Apellido'}}</label>
<input type="text" class="form-control" name="Apellido" id="Apellido" value="{{ isset($contacto->Apellido)?$contacto->Apellido:''}}">
</div>

<div class="form-group">
<label for="Correo" class="control-label">{{'Correo'}}</label>
<input type="text" class="form-control" name="Correo" id="Correo" value="{{ isset($contacto->Correo)?$contacto->Correo:''}}">
</div>

<div class="form-group">
<label for="Fecha" class="control-label">{{'Fecha de Nacimiento'}}</label>
<input type="text" class="form-control" name="Fecha" id="Fecha" value="{{ isset($contacto->Fecha)?$contacto->Fecha:''}}">
</div>

<div class="form-group">
<label for="Foto" class="control-label">{{'Foto'}}</label>
@if(isset($contacto))
<br/>
<img src="{{$contacto->Foto}}" class="img-thumbnail img-fluid" alt="" width="100">
<br/>
@endif
<input type="file" class="form-control" name="Foto" id="Foto" value="">
</div>

<input type="submit" class="btn btn-warning" value="{{ $Modo=='crear' ? 'Agregar' :'Modificar'}}">

<a class="btn btn-success" href="{{url('contactos')}}">Regresar</a>

