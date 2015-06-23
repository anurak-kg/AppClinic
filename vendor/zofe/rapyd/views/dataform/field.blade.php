@if (in_array($field->type, array('hidden','auto')))

    {!! $field->output !!}

    @if ($field->message!='')
    <span class="help-block">
        <span class="glyphicon glyphicon-warning-sign"></span>
        {!! $field->message !!}
    </span>
    @endif

@else
    <div class="form-group{!!$field->has_error!!}">
        <label for="{!! $field->name !!}" class="{!! $field->req !!}">{!! $field->label !!}</label>
            {!! $field->output !!}
            @if(count($field->messages))
                @foreach ($field->messages as $message)
                    <span class="help-block">
                        <span class="glyphicon glyphicon-warning-sign"></span>
                        {!! $message !!}
                    </span>
                @endforeach
            @endif
    </div>
@endif
