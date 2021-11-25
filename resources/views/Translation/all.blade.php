@extends('master')
@section('contents')
	<?php $langs	=	Config::get('app.locales'); ?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card m-b-30">
						<div class="card-body">
							<h4 class="mt-0 header-title mb-4">All Lang Files ({{count($files)}})<a class="btn btn-success waves-effect waves-light rounded-pill float-right" href="{{route('Lang.createFile')}}"><i class="fas fa-file"></i> Create</a></h4>
							<div class="table-responsive mt-2">
								<table class="table table-hover">
									<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">File Name</th>
											<th scope="col" colspan="5" class="text-center">Action</th>
										</tr>
									</thead>
									<tbody id="mypageTable">
										@foreach($files as $key => $file)
											<tr>
												<td>{{++$key}}</td>
												<td>{{$file}}</td>
												@foreach($langs as $lang)
													<?php $language	=	in_array($lang,['en','hi','mr']) ? $lang : 'en'; ?>
													<td>
														<div>
															<a href="/{{$lang}}/lang/edit/{{$file}}" class="btn btn-primary waves-effect waves-light rounded-pill"><i class="fas fa-edit"></i> {{ Locale::getDisplayLanguage($lang, $language) }}</a>
														</div>
													</td>
												@endforeach
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
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