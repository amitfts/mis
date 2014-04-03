@extends(Config::get('mis::views.master'))

@section('content')
<script src="{{ asset('packages/efusionsoft\mis/assets/js/dashboard/user.js') }}"></script>
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-12">
            <section class="module">
                <div class="module-head">
                    <b>{{ trans('mis::users.new') }}</b>
                </div>
                <div class="module-body">
                    <form class="form-horizontal" id="create-user-form" method="POST">
                        <div class="row">
                            <div class="col-lg-6">
                                 <div class="form-group">
                                    <label class="control-label">{{ trans('mis::users.username') }}</label>
                                    <p><input class="col-lg-12 form-control" type="text" placeholder="{{ trans('mis::users.username') }}" id="username" name="username"></p>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">{{ trans('mis::all.email') }}</label>
                                    <p><input class="col-lg-12 form-control" type="text" placeholder="{{ trans('mis::all.email') }}" id="email" name="email"></p>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">{{ trans('mis::all.password') }}</label>
                                    <p><input class="col-lg-12 form-control" type="password" placeholder="{{ trans('mis::all.password') }}" id="pass" name="pass"></p>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">{{ trans('mis::users.last-name') }}</label>
                                    <p><input class="col-lg-12 form-control" type="text" placeholder="{{ trans('mis::users.last-name') }}" id="last_name" name="last_name"></p>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">{{ trans('mis::users.first-name') }}</label>
                                    <p><input class="col-lg-12 form-control" type="text" placeholder="{{ trans('mis::users.first-name') }}" id="first_name" name="first_name"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                            @if($currentUser->hasAccess('user-group-management'))
                                <label class="control-label">{{ trans('mis::users.groups') }}</label>
                                <div class="form-group">
                                @foreach($groups as $group)
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="groups[{{ $group->getId() }}]" name="groups[]" value="{{ $group->getId() }}">{{ $group->getName() }}
                                </label>
                                @endforeach
                                </div>
                            @endif
                                <div class="form-group">
                                @if($currentUser->hasAccess('permissions-management'))
                                    @include('mis::layouts.dashboard.permissions-select', array('permissions'=> $permissions))
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <button id="add-user" class="btn btn-primary" style="margin-top: 15px;">{{ trans('mis::all.create') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
@stop