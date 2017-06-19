<?php
$selectedLocale = isset($selectedLocale) ? $selectedLocale : app()->getLocale();
?>

<div class="form-group {{ $errors->first('locale', 'has-error') }}">
    {{ Form::label('locale', trans('blog::posts.attributes.locale').' :') }}
    {{ Form::select('locale', $supportedLocales, old('locale', $selectedLocale), ['class' => 'form-control select-2-fw']) }}
    @if ($errors->has('locale'))
        <span class="text-red">{!! $errors->first('locale') !!}</span>
    @endif
</div>
