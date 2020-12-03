@if($name !== 'notify')
<system-notify-container
    @if(!empty($class))
    class="{{ $class }}"
    @endif
    name="{{ $name }}"
    stack="{{ $stack ?? config('system-notify.stack') }}"
    :config="{{ $config ?? config('system-notify.config') }}"
    @if(Session::has("notify.$name"))
    :notify='{!! Notify::extract($name) !!}'
    @endif>
        @isset($slot){!! $slot !!}@endisset
    </system-notify-container>
@else
    <script type="application/javascript">
        console.log('config',{{$name}});
    </script>
@endif

