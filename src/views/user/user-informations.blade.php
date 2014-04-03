<label>{{ trans('mis::users.registration') }}</label><p>{{ $user->created_at }}</p>
<label>{{ trans('mis::users.last-update') }}</label><p>{{ $user->updated_at }}</p>
<label>{{ trans('mis::users.last-login') }}</label><p>{{ $user->last_login }}</p>
<label>{{ trans('mis::users.ip') }}</label><p>{{ $throttle->ip_address }}</p>
<label>{{ trans('mis::users.banned-at') }}</label><p>{{ isset($throttle->banned_at) ? $throttle->banned_at : 'none' }}</p>