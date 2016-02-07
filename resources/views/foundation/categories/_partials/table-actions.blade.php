<a href="{{ route('blog::foundation.categories.show', [$category->id]) }}" class="btn btn-xs btn-info">
    <i class="fa fa-fw fa-search"></i>
</a>
<a href="{{ route('blog::foundation.categories.edit', [$category->id]) }}" class="btn btn-xs btn-warning">
    <i class="fa fa-fw fa-pencil"></i>
</a>
<a href="#deleteCategoryModal" class="btn btn-xs btn-danger" data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}">
    <i class="fa fa-fw fa-trash"></i>
</a>
