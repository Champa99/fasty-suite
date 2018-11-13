@extends ('admin.layout')

@section ('content')

	<div class="row">
		<div class="col s8">
			<div class="widget-container news-box">
				<div class="title">Fasty news</div>

				<div class="content">
					@foreach(\App\Packages\Transport\LoadNews::try() AS $article)
						
						<article id="news_{{ $article['id'] }}" class="news">
							<h4>{{ $article['title'] }}</h4>
							<p>{{ $article['content'] }}</p>
						</article>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection