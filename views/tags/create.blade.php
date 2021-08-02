<x-arc:layout>
    @section('page-title')
        <i class="fas fa-fw fa-tag"></i> @lang('New Tag')
    @endsection

    <x-arc:form action="{{ route('admin::blog.tags.store') }}">
        <div class="row">
            <div class="col-md-6">
                <x-arc:card>
                    <x-arc:card-header>@lang('Tag')</x-arc:card-header>
                    <x-arc:card-body>
                        <div class="row row-cols-1 g-3">
                            <div class="col">
                                {{-- NAME --}}
                                <x-arc:input-control type="text" name="name" label="Name" required/>
                            </div>
                            <div class="col">
                                {{-- SLUG --}}
                                <x-arc:input-control type="text" name="slug" label="Slug" required/>
                            </div>
                        </div>
                    </x-arc:card-body>
                    <x-arc:card-footer class="d-flex justify-content-between">
                        <x-arc:form-cancel-button to="{{ route('admin::blog.tags.index') }}"/>
                        <x-arc:form-submit-button type="save"/>
                    </x-arc:card-footer>
                </x-arc:card>
            </div>
        </div>
    </x-arc:form>
</x-arc:layout>
