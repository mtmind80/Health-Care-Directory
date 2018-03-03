<span class="form-field-label">{!! !empty($params['label']) ? $params['label'] : 'Image' !!}: {!! !empty($params['hint']) ? '<em class="hint">'.$params['hint'].'</em>' : '' !!} {!! !empty($params['required']) ? '<i class="field-required fa fa-asterisk" data-toggle="tooltip" title="'. (!empty($params['title']) ? $params['title'] : 'this field is required') .'"></i>' : '' !!}</span>
<div class="dropzone field {!! !empty($params['class']) ? $params['class'] : 'user' !!}"
     {!! !empty($params['image']) ? 'data-image="'.$params['image'].'"' : '' !!}
     {!! !empty($params['id']) ? 'data-id="'.$params['id'].'"' : '' !!}
     data-width="{!! !empty($params['width']) ? $params['width'] : '250' !!}"
     data-height="{!! !empty($params['height']) ? $params['height'] : '250' !!}"
     data-originalsize="{!! !empty($params['originalSize']) ? $params['originalSize'] : 'false' !!}"
     data-resize="{!! !empty($params['resize']) ? $params['resize'] : 'true' !!}"
     data-url="{{ $uploadUrl }}"
     data-removeurl="{{ $removeUrl }}"
     data-token="{{ $token }}">
    <input type="file" name="{!! !empty($params['name']) ? $params['name'] : 'thumb' !!}" id="{{ $id }}"{!! !empty($params['required']) ? ' required="required"' : '' !!} />
</div>