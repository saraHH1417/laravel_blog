<p class="text-muted">
    {{ empty(trim($slot)) ? 'Added' : $slot }} {{ ucwords($date) }}
    @if( isset($name))
       By {{ $name }}
    @endif
</p>
