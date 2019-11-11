<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="panel-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
            	<label class="control-label">Nombre*</label>
            	<input class="form-control" type="text" name="name" value="{{ $permission->name ?? old('name')}}">
                {!! $errors->first('name', '<small class="help-block text-danger">:message</small>')!!}
            </div>
      	</div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ isset($btnText) ? $btnText : 'Guardar'}}</button>
        </div>
      	<div class="col-sm-12">
            <div class="form-group">
            	<label class="control-label">Lista de Permisos</label>
            	<div class="list-group">
      					@foreach($permissions as $permission)
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">{{$permission->name}}</h5>
                      <small class="text-muted">{{$permission->created_at}}</small>
                    </div>
                    <p class="mb-1">{{$permission->description}}</p>
                    <small class="text-muted">{{$permission->slug}}</small>
                  </a>
      					@endforeach
      				</div>
            </div>
      	</div>
    </div>
</div>
