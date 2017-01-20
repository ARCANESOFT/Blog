<?php
$selectedCategory = isset($selectedCategory) ? $selectedCategory : 0;
?>

<div class="form-group {{ $errors->first('category', 'has-error') }}">
    {{ Form::label('category', 'Category :') }}
    {{ Form::select('category', $categories, old('category', $selectedCategory), ['class' => 'form-control select-2-fw']) }}
    @if ($errors->has('category'))
        <span class="text-red">{!! $errors->first('category') !!}</span>
    @endif
</div>
