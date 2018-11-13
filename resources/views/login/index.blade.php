@extends ('login.layout')

@section ('scripts')
	{!! jsComponent('js/login/index') !!}
@endsection

@section ('content')

	<div class="loginHolder">

		<h1 class="login-title">{{ readConfig()->community_name }}</h1>

		<div class="login-modul-holder" id="login_modul_holder">
		
			<p class="wrong-credentials" id="wrong_credentials">
				<i class="fas fa-exclamation-circle"></i>
				@lang('login.wrong_credentials')
			</p>

			<div class="loginWindow z-depth-5" id="login_window">
				
				<form id="login_form">
					@csrf

					<div class="row">
						<div class="col s12">
							<h4 class="title">@lang('login.login_title')</h4>
						</div>
					</div>

					<div class="row">
						<div class="col s12">
							<input id="login_id" name="user" type="text" class="normalize_input cred-input" placeholder="@lang('login.name_email')">

							<input id="login_password" name="password" type="password" class="normalize_input cred-input" placeholder="@lang('login.password')">

							<div class="button-holder">
								<button class="button go cred-button" id="login_button">@lang('login.login')</button>
							</div>

							<p class="center-align">
								<label>
									<input type="checkbox" class="filled-in" checked="checked" />
									<span>@lang('login.remember')</span>
								</label>
							</p>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection