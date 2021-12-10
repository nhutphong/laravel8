<?php

namespace App\Http\View\Composers;

// use App\Repositories\UserRepository;
use Illuminate\View\View;

class SiteNameComposer
{
    /**
     * The user repository implementation.
     *
     * @var \App\Repositories\UserRepository
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  \App\Repositories\UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    // public function va compose name method la bat buoc
    public function compose(View $view)
    {
        $view->with('title', 'composer class');
    }
}