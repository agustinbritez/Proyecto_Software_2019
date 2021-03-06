<span id="alert-aviso">

</span>
@if ($message = Session::get('success'))

<div class="alert alert-success alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>

	<strong>{{ $message }}</strong>

</div>

@endif


@if ($message = Session::get('error'))

<div class="alert alert-danger alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>

	<strong>{{ $message }}</strong>

</div>

@endif


@if ($message = Session::get('warning'))

<div class="alert alert-warning alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>

	<strong>{{ $message }}</strong>

</div>

@endif


@if ($message = Session::get('pedidos'))

<div class="alert alert-info alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>

	<strong>{{ $message }}</strong>

</div>

@endif


@if ($errors->any())

<div class="alert alert-danger">

	<button type="button" class="close" data-dismiss="alert">×</button>

	<p>Corrige los siguientes errores:</p>
	<ul>
		@foreach ($errors->all() as $message)
		<li>{{ $message }}</li>
		@endforeach
	</ul>

</div>

@endif