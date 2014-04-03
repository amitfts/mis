@extends(Config::get('mis::views.master'))

@section('content')

<script src="{{ asset('packages/efusionsoft/mis/assets/js/dashboard/user.js') }}"></script>
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-8">
            <section class="module">
                <div class="module-head">
                    <b>{{ $user->getId() }} - {{ $user->username }}</b>
                </div>
                <div class="module-body">
                    <form class="form-horizontal" id="edit-user-form" method="PUT">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('mis::users.username') }}</label>
                                <input class="col-lg-12 form-control" type="text" id="username" name="username" value="{{ $user->username}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{ trans('mis::all.email') }}</label>
                                <input class="col-lg-12 form-control" type="text" id="email" name="email" value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{ trans('mis::all.password') }}</label>
                                <input class="col-lg-12 form-control" type="password" placeholder="{{ trans('mis::all.password') }}" id="pass" name="pass" >
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{ trans('mis::users.last-name') }}</label>
                                <input class="col-lg-12 form-control" type="text" id="last_name" name="last_name" value="{{ $user->last_name  }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{ trans('mis::users.first-name') }}</label>
                                <input class="col-lg-12 form-control" type="text" id="first_name" name="first_name" value="{{ $user->first_name }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('mis::users.groups') }}</label>
                            </div>
                            <div class="form-group">

                            @foreach($groups as $group)
                            <label class="checkbox-inline">
                                @if($currentUser->hasAccess('user-group-management'))
                                <input type="checkbox" id="groups[{{ $group->getId() }}]" name="groups[]" value="{{ $group->getId() }}" {{ ($user->inGroup($group)) ? 'checked="checked"' : ''}}>
                                @endif
                                {{ $group->getName() }}
                            </label>
                            @endforeach
                            </div>
                        </div>
                        <div class="col-lg-5">
                            @if($currentUser->hasAccess('permissions-management'))
                                @include('mis::layouts.dashboard.permissions-select', array('permissions'=> $permissions))
                            @endif
                        </div>
                        @if($user->getId() !== $currentUser->getId())
                        <div class="col-lg-2">
                            <label>{{ trans('mis::users.banned') }}</label>
                            <div class="switch-toggle well">
                                <input id="no" name="banned" type="radio" value="no" {{ ($throttle->isBanned() === false) ? 'checked' : '' }}>
                                <label for="no" onclick="">{{ trans('mis::all.no') }}</label>

                                <input id="yes" name="banned" type="radio" value="yes" {{ ($throttle->isBanned() === true) ? 'checked' : '' }}>
                                <label for="yes" onclick="">{{ trans('mis::all.yes') }}</label>

                                <a class="btn btn-primary"></a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <br>
                            <div class="form-group">
                                <button id="update-user" class="btn btn-primary">{{ trans('mis::all.update') }}</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </section>
        </div>
        <div class="col-lg-4">
            <section class="module">
            <div class="module-head">
                <b>{{ trans('mis::users.information') }}</b>
            </div>
            <div class="module-body ajax-content">
                @include('mis::user.user-informations')
            </div>
        </div>
    </div>
</div>
@stop