<div class="card {{ $marginTop ?? '' }}" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <p class="card-subtitle mb-2 text-muted">
            {{ $subtitle }}
        </p>
    </div>
    <ul class="list-group list-group-flush">
        @if( is_a($elements , 'Illuminate\Support\Collection'))
            @forelse( $elements as $element )
                <li class="list-group-item">
                    @if( isset($needLink) && $needLink )
                        <a href="{{ route('posts.show' , ['post' => $element->id]) }}">
                            {{ $element->{$elementFeature} }}
                        </a>
                    @else
                        {{ $element->{$elementFeature} }}
                    @endif
                </li>
            @empty
                <p> {{ $noElementDetail }}</p>
            @endforelse
        @else
            {{ $elements }}
        @endif
    </ul>
</div>
