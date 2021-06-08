@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fas fa-fw fa-user-edit"></i> @lang('Authors')
@endsection

<?php /** @var  Arcanesoft\Blog\Models\Author  $author */ ?>

@section('content')
    {{ form()->open(['route' => ['admin::blog.authors.update', $author], 'method' => 'PUT']) }}
    <div class="row">
        <div class="col-md-6">
            <div class="card card-borderless shadow-sm mb-3">
                <div class="card-header">@lang('Author')</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="username" class="control-label">@lang('Username') :</label>
                        {{ form()->text('username', old('username', $author->username), ['class' => 'form-control'.$errors->first('username', ' is-invalid'), 'placeholder' => __('Username'), 'required']) }}
                        @error('username')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug" class="control-label">@lang('Slug') :</label>
                        {{ form()->text('slug', old('slug', $author->slug), ['class' => 'form-control'.$errors->first('slug', ' is-invalid'), 'placeholder' => __('Slug')]) }}
                        @error('slug')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="bio" class="control-label">@lang('Bio') :</label>
                        {{ form()->textarea('bio', old('bio', $author->bio), ['class' => 'form-control'.$errors->first('bio', ' is-invalid'), 'placeholder' => __('Bio'), 'required']) }}
                        @error('bio')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    {{ arcanesoft\ui\action_link('cancel', route('admin::blog.authors.index'))->size('sm') }}
                    {{ arcanesoft\ui\action_button('update')->size('sm')->submit() }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-borderless shadow-sm mb-3">
                <div class="card-header">@lang('User Account')</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="first_name" class="control-label">@lang('First Name') :</label>
                        {{ form()->text('first_name', old('first_name', $author->first_name), ['class' => 'form-control'.$errors->first('first_name', ' is-invalid'), 'placeholder' => __('First Name'), 'required']) }}
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="control-label">@lang('Last Name') :</label>
                        {{ form()->text('last_name', old('last_name', $author->last_name), ['class' => 'form-control'.$errors->first('last_name', ' is-invalid'), 'placeholder' => __('Last Name'), 'required']) }}
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label">@lang('Email') :</label>
                        {{ form()->email('email', old('email', $author->email), ['class' => 'form-control'.$errors->first('email', ' is-invalid'), 'placeholder' => __('Email'), 'required']) }}
                        @error('email')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="control-label">@lang('Password') :</label>
                        {{ form()->password('password', ['class' => 'form-control'.$errors->first('password', ' is-invalid'), 'placeholder' => __('Password')]) }}
                        @error('password')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label for="password_confirmation" class="control-label">@lang('Confirm Password') :</label>
                        {{ form()->password('password_confirmation', ['class' => 'form-control'.$errors->first('password_confirmation', ' is-invalid'), 'placeholder' => __('Confirm Password')]) }}
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ form()->close() }}
@endsection
