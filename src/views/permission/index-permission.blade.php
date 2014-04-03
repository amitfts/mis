@extends(Config::get('mis::views.master'))

@section('content')
<script src="{{ asset('packages/efusionsoft\mis/assets/js/dashboard/permission.js') }}"></script>
@include('mis::layouts.dashboard.confirmation-modal',  array('title' => trans('mis::all.confirm-delete-title'), 'content' => trans('mis::all.confirm-delete-message'), 'type' => 'delete-permission'))
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-10">
            <section class="module">
                <div class="module-head">
                    <b>{{ trans('mis::permissions.all') }}</b>
                </div>
                <div class="module-body ajax-content">
                    @include('mis::permission.list-permissions')
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
                            <label for="permissionIdSearch">{{ trans('mis::permissions.id') }}</label>
                            <input type="text" class="form-control" id="permissionIdSearch" name="permissionIdSearch">
                        </div>
                        <div class="form-group">
                            <label for="permissionNameSearch">{{ trans('mis::all.name') }}</label>
                            <input type="text" class="form-control" id="permissionNameSearch" name="permissionNameSearch">
                        </div>
                        <div class="form-group">
                            <label for="permissionValueSearch">{{ trans('mis::permissions.value') }}</label>
                            <input type="text" class="form-control" id="permissionValueSearch" name="permissionValueSearch">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('mis::all.search') }}</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
@stop