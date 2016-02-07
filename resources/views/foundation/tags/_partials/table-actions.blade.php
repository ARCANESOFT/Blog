<a href="{{ route('blog::foundation.tags.show', [$tag->id]) }}" class="btn btn-xs btn-info">
    <i class="fa fa-fw fa-search"></i>
</a>
<a href="{{ route('blog::foundation.tags.edit', [$tag->id]) }}" class="btn btn-xs btn-warning">
    <i class="fa fa-fw fa-pencil"></i>
</a>
<a href="#deleteTagModal" class="btn btn-xs btn-danger" data-tag-id="{{ $tag->id }}" data-tag-name="{{ $tag->name }}">
    <i class="fa fa-fw fa-trash"></i>
</a>
