<?php

namespace Efusionsoft\Mis\Controllers;

use Efusionsoft\Mis\Controllers\BaseController;
use Efusionsoft\Mis\Services\Validators\User as UserValidator;
use View;
use Input;
use Sentry;
use Redirect;
use Config;
use Response;

class DashboardController extends BaseController
{
    /**
    * Index loggued page
    */
    public function getIndex()
    {
        $this->layout = View::make(Config::get('mis::views.dashboard-index'));
        $this->layout->title = trans('mis::all.titles.index');
        $this->layout->breadcrumb = Config::get('mis::breadcrumbs.dashboard');
    }

    /**
    * Login page
    */
    public function getLogin()
    {
        $this->layout = View::make(Config::get('mis::views.login'));
        $this->layout->title = trans('mis::all.titles.login');
        $this->layout->breadcrumb = Config::get('mis::breadcrumbs.login');
    }

    /**
    * Login post authentication
    */
    public function postLogin()
    {
        try
        {

            $validator = new UserValidator(Input::all(), 'login');

            if(!$validator->passes())
            {
                 return Response::json(array('logged' => false, 'errorMessages' => $validator->getErrors()));
            }

            $credentials = array(
                'email'    => Input::get('email'),
                'password' => Input::get('pass'),
            );

            // authenticate user
            Sentry::authenticate($credentials, Input::get('remember'));
        }
        catch(\Cartalyst\Sentry\Throttling\UserBannedException $e)
        {
            return Response::json(array('logged' => false, 'errorMessage' => trans('mis::all.messages.banned'), 'errorType' => 'danger'));
        }
        catch (\RuntimeException $e)
        {
            return Response::json(array('logged' => false, 'errorMessage' => trans('mis::all.messages.login-failed'), 'errorType' => 'danger'));
        }

        return Response::json(array('logged' => true));
    }

    /**
    * Logout user
    */
    public function getLogout()
    {
        Sentry::logout();

        return Redirect::route('indexDashboard');
    }

    /**
    * Access denied page
    */
    public function getAccessDenied()
    {
        $this->layout = View::make(Config::get('mis::views.error'), array('message' => trans('mis::all.messages.denied')));
        $this->layout->title = trans('mis::all.titles.error');
        $this->layout->breadcrumb = Config::get('mis::breadcrumbs.dashboard');
    }
}