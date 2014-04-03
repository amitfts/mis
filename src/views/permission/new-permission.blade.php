@extends(Config::get('mis::views.master'))

@section('content')
<script src="{{ asset('packages/efusionsoft\mis/assets/js/dashboard/permission.js') }}"></script>
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-6">
            <section class="module">
                <div class="module-head">
                    <b>{{ trans('mis::permissions.new') }}</b>
                </div>
                <div class="module-body">
                    <form class="form-horizontal" id="create-permission-form" method="POST">
                        <div class="row">
                            <div class="col-lg-12">
                                 <div class="form-group">
                                    <label class="control-label">{{ trans('mis::all.name') }}</label>
                                    <p><input class="col-lg-12 form-control" type="text" id="name" name="name"></p>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">{{ trans('mis::permissions.value') }}</label>
                                    <p><input class="col-lg-12 form-control" type="text" id="value" name="value"></p>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">{{ trans('mis::permissions.description') }}</label>
                                    <p><input class="col-lg-12 form-control" type="text" id="description" name="description"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <button id="add-permission" class="btn btn-primary" style="margin-top: 15px;">{{ trans('mis::all.create') }}</button>
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