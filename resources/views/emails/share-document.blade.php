@isset($type)

    @if ($type == 'reminder')
        <div class="flex">
            <span class="px-1">Reminder you have not signed the document</span>
            <a href="{{ url('document/' . $id . '/' . $employee_id . '/preview') }}">Click here</a>
            <span class="px-1"> to sign</span>
        </div>
    @else
        <a href="{{ url('document/' . $id . '/' . $employee_id . '/preview') }}">Click me</a>
    @endif

@endisset
