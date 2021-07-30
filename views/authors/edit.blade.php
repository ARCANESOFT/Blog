<?php /** @var  Arcanesoft\Blog\Models\Author  $author */ ?>
<x-arc:layout>
    @section('page-title')
        <i class="fas fa-fw fa-user-edit"></i> @lang('Authors')
    @endsection

    <x-arc:form action="{{ route('admin::blog.authors.update', [$author]) }}" method="PUT">
        <div class="row row-cols-md-2">
            <div class="col">
                <x-arc:card>
                    <x-arc:card-header>@lang('Author')</x-arc:card-header>
                    <x-arc:card-body>
                        <div class="row row-cols-1 g-3">
                            <div class="col">
                                {{-- USERNAME --}}
                                <x-arc:input-control
                                    type="text" name="username" :value="$author->username" label="Username" required/>
                            </div>
                            <div class="col">
                                {{-- SLUG --}}
                                <x-arc:input-control
                                    type="text" name="slug" :value="$author->slug" label="Slug" required/>
                            </div>
                            <div class="col">
                                {{-- BIO --}}
                                <x-arc:textarea-control
                                    name="bio" :value="$author->bio" label="Bio" required/>
                            </div>
                        </div>
                    </x-arc:card-body>
                    <x-arc:card-footer class="d-flex justify-content-between">
                        <x-arc:form-cancel-button to="{{ route('admin::blog.authors.index') }}"/>
                        <x-arc:form-submit-button type="save"/>
                    </x-arc:card-footer>
                </x-arc:card>
            </div>
            <div class="col">
                <x-arc:card>
                    <x-arc:card-header>@lang('User Account')</x-arc:card-header>
                    <x-arc:card-body>
                        <div class="row row-cols-1 g-3">
                            <div class="col">
                                {{-- FIRST NAME --}}
                                <x-arc:input-control
                                    type="text" name="first_name" :value="$author->first_name"
                                    label="First Name" required/>
                            </div>
                            <div class="col">
                                {{-- LAST NAME --}}
                                <x-arc:input-control
                                    type="text" name="last_name" :value="$author->last_name"
                                    label="Last Name" required/>
                            </div>
                            <div class="col">
                                {{-- EMAIL --}}
                                <x-arc:input-control
                                    type="email" name="email" :value="$author->email"
                                    label="Email" required/>
                            </div>
                            <div class="col">
                                {{-- PASSWORD --}}
                                <x-arc:password-control
                                    name="password" label="Password" required/>
                            </div>
                            <div class="col">
                                {{-- PASSWORD CONFIRMATION --}}
                                <x-arc:password-control
                                    name="password_confirmation" label="Password Confirmation" required/>
                            </div>
                        </div>
                    </x-arc:card-body>
                </x-arc:card>
            </div>
        </div>
    </x-arc:form>
</x-arc:layout>
