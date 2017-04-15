<?php  /** @var  \Illuminate\Support\Collection  $selectedTags */ ?>

<div class="form-group {{ $errors->first('tags', 'has-error') }}">
    {{ Form::label('tags[]', trans('blog::posts.attributes.tags').' :') }}
    {{ Form::select('tags[]', $tags, old('tags', isset($selectedTags) ? $selectedTags : collect()), ['class' => 'form-control select-2', 'multiple' => 'multiple', 'data-placeholder' => trans('blog::tags.select-tag'), 'style' => 'width: 100%;']) }}
    @if ($errors->has('tags'))
        <span class="text-red">{!! $errors->first('tags') !!}</span>
    @endif
</div>
