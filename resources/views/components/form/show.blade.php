<div class="show-container{{ !empty($params['class']) ? ' '.$params['class'] : '' }}">
    @if (!empty($params['label']))
        <span class="form-field-label">{{ $params['label']}}:</span>
    @endif
    <div class="form-field-value">{!! $value !!}</div>
</div>