@extends ('admin.layout')

@section ('content')
	
	@if (!empty($modules))
		<div class="module-list">
			@foreach($modules AS $module)
				
				<div class="row module-holder">
					<div class="col s2">
						<img src="{{ $module->picture }}" class="module-picture" alt="module-image">
					</div>

					<div class="col s9 module-info">
						<h4>{{ $module->name }}</h4>
						<p><strong>@lang('modules.version'):</strong> {{ $module->version }} ({{ $module->cycle }})</p>
						<p><strong>@lang('modules.type'):</strong> {{ $module->type }}</p>
						<p>
							<strong>@lang('modules.install_date'):</strong> {{ formatStamp($module->installed_on) }}
							|
							<strong>@lang('modules.last_update'):</strong> {{ formatStamp($module->updated_on) }}
						</p>
						<p>
							<strong>@lang('modules.author'):</strong> {{ $module->author }}
							|
							<strong>@lang('modules.website'):</strong>
							<a href="{{ $module->website }}" target="_blank">
								{{ $module->website }}
								<i class="fas fa-external-link-alt"></i>
							</a>
						</p>
					</div>

					<div class="col s1 options">
						<i class="icon fas fa-ellipsis-h"></i>
					</div>
				</div>
			@endforeach
		</div>
	@endif
@endsection