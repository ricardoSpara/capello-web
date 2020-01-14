<?php

namespace Capello\Http\Controllers;

use Capello;
use Capello\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // App::setLocale('pt-BR');
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::where('status', '0')
            ->with('courses')
            ->with('tags')
            ->where('private', '0')
            ->leftJoin('project_likes', function($join) {
                $join->on('project_likes.project_id', '=', 'projects.id');
                $join->where('project_likes.user_id', '=', Auth::user()->id);
            })->select('projects.*', 'project_likes.id as like', DB::raw('(SELECT COUNT(*) FROM project_likes WHERE project_likes.project_id = projects.id) as count_likes'))->orderBy('count_likes', 'desc')->paginate(10);
        return view('home', compact('projects'));
    }
}
