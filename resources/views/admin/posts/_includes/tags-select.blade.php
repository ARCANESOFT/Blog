<?php
$selectedTags = isset($selectedTags) ? $selectedTags : collect();
?>

<div class="form-group {{ $errors->first('tags', 'has-error') }}">
    {{ Form::label('tags[]', trans('blog::posts.attributes.tags').' :') }}
    {{ Form::select('tags[]', $tags, old('tags', $selectedTags), ['class' => 'form-control select-2', 'multiple' => 'multiple', 'data-placeholder' => 'Select a tag', 'style' => 'width: 100%;']) }}
    @if ($errors->has('tags'))
        <span class="text-red">{!! $errors->first('tags') !!}</span>
    @endif
</div>
