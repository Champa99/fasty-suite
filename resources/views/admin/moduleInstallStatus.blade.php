<div class="module-install-status">
	@if ($code === 0)
		<h4>{{ $moduleName }} @lang('installer.install_success')</h4>

		<p>@lang('installer.changes_made') (@lang('installer.total') {{ count($status['updates']) }})</p>

		<div class="status-list">
			<ol>
				@foreach ($status['updates'] as $change)
					<li><i class="addition fas fa-plus-circle"></i> {{ $change }}</li>
				@endforeach
			</ol>
		</div>

		<a href="/admin/module" class="btn waves-effect waves-dark">@lang('installer.go_to_modules')</a>
	@else
	
	@endif
</div>