@extends ('admin.layout')

@section ('scripts')
	{!! jsComponent('js/admin/module-installer') !!}
@endsection

@section ('content')
	<div id="module_installer">
		<div class="file-field input-field">
			<div class="btn">
				<span>File</span>
				<input type="file" class="module-input">
			</div>
			<div class="file-path-wrapper">
				<input class="file-path validate" id="module_input_fname" type="text">
			</div>
		</div>
	</div>

	<div id="module_loader" class="module-loader-holder" style="display: none;">
		<div class="module-loader">
			<div class="preloader-wrapper big active">
				<div class="spinner-layer spinner-blue">
					<div class="circle-clipper left">
					<div class="circle"></div>
					</div><div class="gap-patch">
					<div class="circle"></div>
					</div><div class="circle-clipper right">
					<div class="circle"></div>
					</div>
				</div>

				<div class="spinner-layer spinner-red">
					<div class="circle-clipper left">
					<div class="circle"></div>
					</div><div class="gap-patch">
					<div class="circle"></div>
					</div><div class="circle-clipper right">
					<div class="circle"></div>
					</div>
				</div>

				<div class="spinner-layer spinner-yellow">
					<div class="circle-clipper left">
					<div class="circle"></div>
					</div><div class="gap-patch">
					<div class="circle"></div>
					</div><div class="circle-clipper right">
					<div class="circle"></div>
					</div>
				</div>

				<div class="spinner-layer spinner-green">
					<div class="circle-clipper left">
					<div class="circle"></div>
					</div><div class="gap-patch">
					<div class="circle"></div>
					</div><div class="circle-clipper right">
					<div class="circle"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="text" id="module_loader_status">Uploading the module...</div>
	</div>
	<div id="module_information" style="display: none;"></div>
	<div id="module_install_status" style="display: none;"></div>
@endsection