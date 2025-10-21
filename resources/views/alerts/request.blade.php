@if(count($errors) > 0)
	

	<div class="row ml-auto pull-right" style="position:absolute; top: 10px !important; right: 25px !important;">
		<div class="alert-group" style="width:100%">
			@foreach($errors->all() as $error)
				<div class="alert alert-warning alert-dismissable">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					{!!$error!!}
				</div>
			@endforeach
        </div>
	</div>

@endif