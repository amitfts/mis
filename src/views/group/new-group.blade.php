@extends(Config::get('mis::views.master'))

@section('content')
<script src="{{ asset('packages/efusionsoft/mis/assets/js/dashboard/group.js') }}"></script>
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-12">
            <section class="module">
                <div class="module-head">
                    <b>{{ trans('mis::groups.new') }}</b>
                </div>
                <div class="module-body">
                    <form class="form-horizontal" id="create-group-form" method="POST">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">{{ trans('mis::groups.name') }}</label>
                                    <input class="col-lg-12 form-control" type="text" id="groupname" name="groupname">
                               </div>
                            </div>
                            <div class="col-lg-4">
                            @if($currentUser->hasAccess('permissions-management'))
                                @include('mis::layouts.dashboard.permissions-select', array('permissions'=> $permissions))
                            @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="control-group">
                                    <button id="create-group" class="btn btn-primary">{{ trans('mis::all.create') }}</button>
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