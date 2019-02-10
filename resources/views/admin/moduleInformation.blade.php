<div class="row module-information">
	<div class="col s4">
		<img src="https://raw.githubusercontent.com/laravel/art/master/legacy/laravel-four-icon.png" class="module-picture">
	</div>

	<div class="col s8 information-grid">
		<div class="row">
			<div class="col s4 key">@lang('installer.module_name')</div>
			<div class="col s8 value">{{ $moduleInfo->name }}</div>
		</div>

		<div class="row">
			<div class="col s4 key">@lang('installer.version')</div>
			<div class="col s8 value">{{ $moduleInfo->version }}</div>
		</div>

		<div class="row">
			<div class="col s4 key">@lang('installer.cycle')</div>
			<div class="col s8 value">{{ $moduleInfo->cycle }}</div>
		</div>

		<div class="row">
			<div class="col s4 key">@lang('installer.type')</div>
			<div class="col s8 value">{{ $moduleInfo->type }}</div>
		</div>

		<div class="row">
			<div class="col s4 key">@lang('installer.author')</div>
			<div class="col s8 value">{{ $moduleInfo->author }}</div>
		</div>

		<div class="row">
			<div class="col s4 key">@lang('installer.website')</div>
			<div class="col s8 value">
				<a href="{{ $moduleInfo->website }}" target="_blank">
					{{ $moduleInfo->website }} <i class="fas fa-external-link-alt"></i>
				</a>
			</div>
		</div>

		<div class="row module-changes">
			<div class="col s12">
				<div class="window-toggler" id="changes_toggler">
					<i class="icon fas fa-angle-down"></i> @lang('installer.module_changes')
				</div>
				<div class="changes-window" id="changes_window" @if (count($diff['panic']) < 1 && count($diff['conflict']) < 1)style="display: none;"@endif>
					@foreach ($diff AS $diffType => $lines)
						@php
							$size = count($lines);
						@endphp

						@if ($size > 0)
							<div class="section">
								<h4>
									@if ($diffType == 'panic')
										<i class="icon panic fas fa-exclamation-triangle"></i>
									@elseif($diffType == 'conflict')
										<i class="icon conflict fas fa-exclamation-circle"></i>
									@else
										<i class="icon ok fas fa-check-circle"></i>
									@endif
									{{ __('installer.type_'. $diffType) }}
									({{ $size }})
								</h4>

								<p>@lang('installer.desc_'. $diffType)</p>

								<ol>
								@foreach ($lines AS $line)
									<li>{{ $line }}</li>
								@endforeach
								</ol>
							</div>
						@endif
					@endforeach
				</div>
			</div>
		</div>

		<div class="row installer-butttons">
			<div class="col s12">
				<button class="btn waves-effect waves-dark @if (count($diff['conflict']) > 0)conflict-install @endif" id="install_module" data-m="{{ $moduleName }}">
					@lang('installer.install_module')
				</button>

				<button class="btn-flat waves-effect waves-red" id="remove_module" data-m="{{ $moduleName }}">
					@lang('installer.remove_module')
				</button>
			</div>
		</div>
	</div>
</div>