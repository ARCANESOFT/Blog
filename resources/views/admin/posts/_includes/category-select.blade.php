<?php
$selectedCategory = isset($selectedCategory) ? $selectedCategory : 0;
?>

<div class="form-group {{ $errors->first('category', 'has-error') }}">
    {{ form()->label('category', trans('blog::posts.attributes.category').' :') }}
    {{ form()->select('category', $categories, old('category', $selectedCategory), ['class' => 'form-control select-2-fw']) }}
    @if ($errors->has('category'))
        <span class="help-block">{{ $errors->first('category') }}</span>
    @endif
</div>
