@extends(Config::get('mis::views.master'))

@section('content')
<script src="{{ asset('packages/efusionsoft/mis/assets/js/dashboard/user.js') }}"></script>

<div class="container" id="main-container">
    @include('mis::layouts.dashboard.confirmation-modal', array('title' => trans('mis::all.confirm-delete-title'), 'content' => trans('mis::all.confirm-delete-message'), 'type' => 'delete-user'))
    <div class="row">
        <div class="col-lg-10">
            <section class="module">
                <div class="module-head">
                    <b>{{ trans('mis::users.all') }}</b>
                </div>
                <div class="module-body ajax-content">
                    @include('mis::user.list-users')
                </div>
            </section>
        </div>
        <div class="col-lg-2">
            <section class="module">
                <div class="module-head">
                    <b>{{ trans('mis::all.search') }}</b>
                </div>
                <div class="module-body">
                    <form id="search-form" onsubmit="return false;">
                        <div class="form-group">
                            <label for="userIdSearch">{{ trans('mis::users.id') }}</label>
                            <input type="text" class="form-control" id="userIdSearch" name="userIdSearch">
                        </div>
                        <div class="form-group">
                            <label for="usernameSearch">{{ trans('mis::users.username') }}</label>
                            <input type="text" class="form-control" id="usernameSearch" name="usernameSearch">
                        </div>
                        <div class="form-group">
                            <label for="emailSearch">{{ trans('mis::all.email') }}</label>
                            <input type="email" class="form-control" id="emailSearch" name="emailSearch">
                        </div>
                        <div class="form-group">
                            <label for="bannedSearch">{{ trans('mis::users.banned') }}</label>
                            <select class="form-control" id="bannedSearch" name="bannedSearch">
                                <option>--</option>
                                <option value="0">{{ trans('mis::all.no') }}</option>
                                <option value="1">{{ trans('mis::all.yes') }}</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('mis::all.search') }}</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
@stop