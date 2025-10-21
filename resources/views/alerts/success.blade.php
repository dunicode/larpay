@if(Session::has('message'))
	<div class="row ml-auto pull-right" style="position:absolute; top: 10px !important; right: 25px !important;">
		<div class="alert-group" style="width:100%">
            <div class="alert alert-success alert-dismissable">
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{Session::get('message')}}
            </div>
        </div>
	</div>
@endif