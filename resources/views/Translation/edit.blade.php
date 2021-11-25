@extends('master')
@section('contents')
	<?php
		$language	=	in_array(Config::get('app.locale'),['en','hi','mr']) ? Config::get('app.locale') : 'en';
		$langs		=	Config::get('app.locales');
		$langs		=	array_reverse($langs);
		$langs		=	array_diff( $langs, [Config::get('app.locale')] );
	?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card m-b-30">
						<div class="card-body">
							<h4 class="mt-0 header-title mb-4">
								Edit Lang File : {{$file}} :: {{ Locale::getDisplayLanguage(Config::get('app.locale'), $language) }} :: {{count($data)}} Keys
								<a class="btn btn-success waves-effect waves-light rounded-pill float-right" href="{{route('Lang.addKey',['file' => $file])}}"><i class="fas fa-plus"></i> Add</a>
								@foreach($langs as $lang)
									<?php $bLanguage	=	in_array($lang,['en','hi','mr']) ? $lang : 'en'; ?>
									<a href="/{{$lang}}/lang/edit/{{$file}}" class="btn btn-primary waves-effect waves-light rounded-pill float-right mr-2"><i class="fas fa-edit"></i> {{ Locale::getDisplayLanguage($lang, $bLanguage) }}</a>
								@endforeach
							</h4>
							<div class="card-body">
								<form>
									<div class="form-row">
										<div class="col">
											<input type="text" id="pagename" class="form-control" name="pageName"  placeholder="Enter Language Key">
											<span id="page_name"></span>
										</div>
									</div>
								</form>
							</div>
							<div class="table-responsive mt-2">
								<table class="table table-hover">
									<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Key</th>
											<th scope="col" style="width:100%;">Value</th>
											<th scope="col">Edit</th>
											@if(Request()->has('lang') && Request()->lang == 'en')
												<th scope="col">Action</th>
											@endif
										</tr>
									</thead>
									<tbody id="mypageTable">
										<?php $i	=	0; ?>
										@foreach($data as $key => $value)
											<tr id="row{{++$i}}">
												<td>{{$i}}</td>
												<td>{{$key}}</td>
												<td><textarea type="text" class="form-control row{{$i}}" name="row{{$i}}">{{$value}}</textarea></td>
												<td><div><a href="javascript:void(0);" class="btn btn-primary btn-sm" onClick="updateRow('{{$file}}','{{$key}}',{{$i}});"><i class="mdi mdi-send noti-icon"></i></a></div></td>
												@if(Request()->has('lang') && Request()->lang == 'en')
													<td><div><a href="javascript:void(0);" class="btn btn-danger btn-sm" onClick="deleteRow('{{$file}}','{{$key}}',{{$i}});">Delete</a></div></td>
												@endif
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
		$(document).ready(function(){
			$("#pagename").on("keyup", function() {
				var value	=	$(this).val().toLowerCase();
				$("#mypageTable tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});
		});
		
		updateRow = (file,key,index) => {
			var value	=	$(`textarea[name="row${index}"]`).val()
			var _token	=	"{{csrf_token()}}"
			
			$.post("{{route('Lang.editFileData')}}", {_token,file,key,value}, function(resp) {
				if(resp.success)
					$.notify(resp.message, "success");
			});
		}
		
		deleteRow = (file,key,index) => {
			var _token	=	"{{csrf_token()}}"
			
			Swal.fire({
				title: 'Are you sure?',
				text: "You are deleting this key!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes!'
			}).then((result) => {
				if (result.value) {
					$.post("{{route('Lang.deleteKey')}}", {_token,file,key},function(resp){
						if(resp.success) {
							// Swal.fire( 'Updated!','Harvester Updated', 'success' )
							$(`#row${index}`).remove();
							$.notify(resp.message, "success")
						}
					});
				}
			});
		}
	</script>
@endsection