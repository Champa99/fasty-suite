@extends ('admin.layout')

@section ('content')

	<div class="row">
		<div class="col s8">
			<div class="widget-container news-widget">
				<div class="title">Fasty news</div>

				<div class="content">
					@foreach(\App\Packages\Transport\LoadNews::try() AS $article)
						
						<article id="news_{{ $article['id'] }}" class="news">
							<h4>
								@if ($article['urgent'])<i class="fas fa-exclamation-triangle urgent"></i>@endif
								{{ $article['title'] }}
							</h4>

							<div class="under-title-holder">
								<p class="time-and-date">{{ formatStamp($article['timestamp']) }}</p>
								<div class="dash"></div>
							</div>

							<p>
								{{ $article['content'] }}
								<a href="#" target="_blank">Read more <i class="fas fa-external-link-alt"></i></a>
							</p>
						</article>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection