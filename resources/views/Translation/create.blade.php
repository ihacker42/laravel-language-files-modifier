@extends('master')
@section('contents')
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card m-b-30">
						<div class="card-body">
							<h4 class="mt-0 header-title">Create Lang File ( English Only )<a class="btn btn-success waves-effect waves-light rounded-pill float-right" href="{{route('Lang.getFiles')}}"><i class="fas fa-file"></i> All</a></h4>
							<div class="form-group row mt-4">
								<label for="file" class="col-sm-2 col-form-label">File Name</label>
								<div class="col-sm-9">
									<input class="form-control @error('file') has-danger @enderror" type="text" id="file" name="file" value="{{old('file')}}" placeholder="Enter File Name" >
									<span class="text-danger">{{$errors->first('file')}}</span>
								</div>
							</div>
							<div class="form-group row row0">
								<label for="key0" class="col-sm-2 col-form-label">Key</label>
								<div class="col-sm-3">
									<textarea class="form-control" type="text" id="key0" name="key0" placeholder="Enter Key Name"></textarea>
								</div>
								<label for="value0" class="col-sm-2 col-form-label">Value</label>
								<div class="col-sm-4">
									<textarea class="form-control" type="text" id="value0" name="value0" placeholder="Enter Key Value"></textarea>
								</div>
							</div>
							<div class="form-group row FileContent">
								<div class="col text-center">
									<a href="javascript:void(0);" class="btn btn-primary btn-sm" onClick="addRow();">Add</a>
								</div>
							</div>
							<div class="form-group row text-center">
								<div class="col-sm-12">
									<button type="button" class="btn btn-success waves-effect waves-light" onClick="createFile();">Create File</button>
								</div>
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
		var index	=	1
		var indexs	=	[0]
		addRow = () => {
			var row	=	`<div class="form-group row row${index}">
						<label for="key${index}" class="col-sm-2 col-form-label">Key</label>
						<div class="col-sm-3">
							<textarea class="form-control" type="text" id="key${index}" name="key${index}" placeholder="Enter Key Name"></textarea>
						</div>
						<label for="value${index}" class="col-sm-2 col-form-label">Value</label>
						<div class="col-sm-4">
							<textarea class="form-control" type="text" id="value${index}" name="value${index}" placeholder="Enter Key Value"></textarea>
						</div>
						<div class="col text-center mt-3">
							<a href="javascript:void(0);" class="btn btn-primary btn-sm" onClick="deleteRow(${index});">Remove</a>
						</div>
						</div>`
			
			$(row).insertBefore(".FileContent")
			indexs.push(index)
			index++
		}
		
		deleteRow = (index) => {
			$(`.row${index}`).remove()
			indexs.splice($.inArray(index,indexs), 1);
		}
		
		createFile = () => {
			var file	=	$(`input[name=file]`).val()
			if(file == "") {
				$.notify("Please Fill File Name!!", "error")
				return false
			}
			
			var arrayLang	=	{}
			var flag		=	1
			indexs.map((item,index) => {
				var key		=	$(`textarea[name="key${item}"]`).val()
				var value	=	$(`textarea[name="value${item}"]`).val()
				if(key == "")
					flag	=	0
				
				if(value == "")
					flag	=	0
				
				arrayLang[key] = value
			});
			
			if(flag == 0) {
				$.notify("Please Fill All Fields!!", "error")
				return false
			}
			
			var _token	=	"{{csrf_token()}}"
			
			$.post("{{route('Lang.createFileData')}}", {_token,file,arrayLang}, function(resp) {
				if(resp.success) {
					$.notify(resp.message, "success");
					window.location.reload()
				}
				else
					$.notify(resp.message, "error");
			});
		}
	</script>
@endsection