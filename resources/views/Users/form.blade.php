{{--<div class="panel-body">--}}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<fieldset>
	<!-- Name input-->
		<div class="form-group">
			<label class="col-md-3 control-label" for="name">Nombre Completo *</label>
			<div class="col-md-3">
				<input class="form-control" type="text" name="name" value="{{ $user->name ?? old('name')}}" placeholder="Nombre">
				{!! $errors->first('name', '<small class="help-block text-danger">:message</small>') !!}
			</div>
			<div class="col-md-3">
				<input class="form-control" type="text" name="paterno" value="{{ $user->paterno ?? old('paterno')}}" placeholder="Paterno">
				{!! $errors->first('paterno', '<small class="help-block text-danger">:message</small>') !!}
			</div>
			<div class="col-md-3">
				<input class="form-control" type="text" name="materno" value="{{ $user->materno ?? old('materno')}}" placeholder="Materno">
				{!! $errors->first('materno', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="phone">Número Telefonico*</label>
			<div class="col-md-4">
				<input class="form-control" type="text" name="phone" value="{{ $user->phone ?? old('phone')}}" placeholder="Telefono">
				{!! $errors->first('phone', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="name">IMEI*</label>
			<div class="col-md-4">
				<input class="form-control" type="text" name="imei" value="{{ $user->imei ?? old('imei')}}" placeholder="IMEI">
				{!! $errors->first('imei', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div>
	<!-- email input-->
		<div class="form-group">
			<label class="col-md-3 control-label" for="email">Correo Personal *</label>
			<div class="col-md-9">
				<input class="form-control" type="email" name="email" value="{{ $user->email ?? old('email')}}" placeholder="Correo Electrónico Personal">
				{!! $errors->first('email', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="email_confirmation">Confirmar Correo Personal *</label>
			<div class="col-md-9">
				<input class="form-control" type="email" name="email_confirmation" value="{{ $user->email ?? old('email_confirmation') }}" placeholder="Confirmar Correo Electrónico Personal">
				{!! $errors->first('email_confirmation', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div>
	<!-- password input-->

	@if(auth()->user()->hasRole(['Administrador','Admin Proveedor']) || auth()->user()->id == $user->id || Session::has('Current.user.new'))
		<div class="form-group">
			<label class="col-md-3 control-label" for="name">Contraseña *</label>
			<div class="col-md-9">
				<input class="form-control" type="password" name="password" placeholder="**********">
				{!! $errors->first('password', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="password_confirmation">Confirmación de Contraseña *</label>
			<div class="col-md-9">
				<input class="form-control" type="password" name="password_confirmation" placeholder="**********">
				{!! $errors->first('password_confirmation', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div>
	@endif
	<input type="hidden" name="auth" value="{{ auth()->user()->id }}">
	<input type="hidden" name="user_id" value="{{ $user->id }}">

	<!-- role input-->
		<div class="form-group">
			<label class="col-md-3 control-label" for="roles">Rol Asignado *</label>
			<div class="col-md-9">
				@foreach($roles as $id => $name)
					@php($check = str_random(5))
					<div class="checkbox">
						<input id="{{ $check }}" class="magic-radio" type="radio" name="roles[]" value="{{ $id }}"
							@if(isset($default))
								{{ ($id == 5) ? 'checked' : '' }}
							@else
								{{ $user->roles->pluck('name')->contains($id) ? 'checked' : ''}}
							@endif
						>
				        <label for="{{ $check }}">{{ $name }}</label>
					</div>
				@endforeach
				{!! $errors->first('roles', '<small class="help-block text-danger">:message</small>') !!}
				<hr>
			</div>
		</div>

	<!-- Form actions -->
		<div class="form-group">
			<div class="col-md-12 widget-right">
				<button type="submit" class="btn btn-primary btn-md pull-right">{{ isset($btnText) ? $btnText : 'Guardar' }}</button>
			</div>
		</div>
	</fieldset>
{{--</div>--}}
