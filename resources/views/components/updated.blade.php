<p class="text-muted">
    {{ empty(trim($slot)) ? 'Added' : $slot }} {{ ucwords($date) }}
    @if( isset($name))
        @if(isset($userId))
            By <a href="{{ route('users.show' , ['user' => $userId]) }}">{{ $name }}</a>
        @else
            By {{ $name }}
        @endif
    @endif
</p>
