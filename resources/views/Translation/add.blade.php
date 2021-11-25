@extends('master')
@section('contents')
	<?php
		$langs	=	Config::get('app.locales');
	?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card m-b-30">
						<div class="card-body">
							<h4 class="mt-0 header-title">Add Lang Key :: {{Request()->file}}</h4>
							<form action="{{ route('Lang.addKeyData') }}" method="POST">
								@csrf
								<input class="form-control" type="hidden" name="file" value="{{Request()->file}}">
								<div class="form-group row">
									<label for="key" class="col-sm-2 col-form-label">Key</label>
									<div class="col-sm-10">
										<textarea class="form-control" type="text" id="key" name="key" placeholder="Enter Key Name"></textarea>
									</div>
								</div>
								@foreach($langs as $lang)
									<?php $language	=	in_array($lang,['en','hi','mr']) ? Locale::getDisplayLanguage($lang, $lang) : Locale::getDisplayLanguage($lang, 'en'); ?>
									<div class="form-group row">
										<label for="value_{{$lang}}" class="col-sm-2 col-form-label">Value {{$language}}</label>
										<div class="col-sm-10">
											<textarea class="form-control @error('value_'.$lang) has-danger @enderror" type="text" id="value_{{$lang}}" name="value_{{$lang}}" placeholder="Enter Key Value {{$language}}"></textarea>
											<span class="text-danger">{{$errors->first('value_'.$lang)}}</span>
										</div>
									</div>
								@endforeach
								<div class="form-group row text-center">
									<div class="col-sm-12">
										<button type="submit" class="btn btn-success waves-effect waves-light">Add Key</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div> <!-- end col -->
			</div> <!-- end row -->      
		</div>
	</div>
@endsection
@section('javascript')
	<script>
	</script>
@endsection