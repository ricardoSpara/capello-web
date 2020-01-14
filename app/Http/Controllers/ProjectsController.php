<?php

namespace Capello\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Capello\Http\Requests\StoreProject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Capello\Models\Project;
use Capello\Models\Tag;
use Capello\Models\Course;
use Capello\User;

class ProjectsController extends Controller
{
    private $totalPages = 4;

    public function index() {
        $projects = Project::where('status', '0')
            ->with('courses')
            ->with('tags')
            ->where('private', '0')
            ->leftJoin('project_likes', function($join) {
                $join->on('project_likes.project_id', '=', 'projects.id');
                $join->where('project_likes.user_id', '=', Auth::user()->id);
            })->select('projects.*', 'project_likes.id as like')->get();
        // dd($projects);
        return view('projects.index', compact('projects'));
    }

    public function myProjects() {
        $projects = Project::join('projects_users', 'projects.id', '=', 'projects_users.project_id')
            ->select('projects.*')
            ->where('projects_users.user_id', Auth::user()->id)
            ->leftJoin('project_likes', function($join) {
                $join->on('project_likes.project_id', '=', 'projects.id');
                $join->where('project_likes.user_id', '=', Auth::user()->id);
            })->select('projects.*', 'project_likes.id as like')->get();
        $my = true;
        return view('projects.index', compact('projects', 'my'));
    }

    public function create() {
        $users = User::where('status', '0')->where('access_level', '3')->orWhere('access_level', '4')->get();
        $tags = Tag::all();
        $courses = Course::all();

        return view('projects.create', compact('users', 'tags', 'courses'));
    }

    public function store(StoreProject $request) {
        $dataProject = [
            'title' => $request['title'],
            'description' => $request['description'],
            'started_date' => $request['started_date'],
            'finished_date' => $request['finished_date'],
            'private' => isset($request['private']) ? '1' : '0',
        ];

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $name = str_random(5).kebab_case($request['title']).str_random(5);
            $extension = $request->image->extension();
            $nameFile = "{$name}.{$extension}";
            $dataProject['image'] = $nameFile;
            $upload = $request->image->storeAs('public/projects', $nameFile);
            if(!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload da imagem!');
        }
        
        $project = Project::create($dataProject);

        
        foreach($request['courses'] as $course) {
            DB::insert('INSERT INTO projects_courses (project_id, course_id) VALUES (?, ?)', [$project->id, $course]);
        }
        foreach($request['users'] as $user) {
            DB::insert('INSERT INTO projects_users (project_id, user_id) VALUES (?, ?)', [$project->id, $user]);
        }
        foreach($request['tags'] as $tag) {
            DB::insert('INSERT INTO projects_tags (project_id, tag_id) VALUES (?, ?)', [$project->id, $tag]);
        }

        if($files = $request->file('files')) {
            foreach($files as $file) {
                $name = str_random(5).str_shuffle('abcdefghijklmnopqrstuvwxyz').str_random(5);
                $extension = $file->extension();
                $nameFile = "{$name}.{$extension}";
                $size = $file->getSize();
                
                $upload = $file->storeAs('public/files', $nameFile);
                if(!$upload)
                    return response()->json(['message' => 'Arquivo não pode ser enviado'], 400);
        
                DB::insert("INSERT INTO files (project_id, path, extension, size) VALUES (?,?,?,?)", [$project->id, $nameFile, $extension, $size]);
            }
        }

        return redirect()->action('ProjectsController@index')->with('success', 'Projeto cadastrado com sucesso!');
    }

    public function edit($id) {
        $project = Project::find($id);
        $projectCourses = DB::select("SELECT c.id, c.name FROM projects_courses pc INNER JOIN courses c ON pc.course_id=c.id WHERE pc.project_id=".$project->id);
        $projectUsers = DB::select("SELECT u.id, u.name, u.email, u.image, u.access_level FROM projects_users pu INNER JOIN users u ON pu.user_id=u.id WHERE pu.project_id=".$project->id);
        $projectTags = DB::select("SELECT t.id, t.name FROM projects_tags pt INNER JOIN tags t ON pt.tag_id=t.id WHERE pt.project_id=".$project->id);
        $users = User::where('status', '0')->where('access_level', '3')->orWhere('access_level', '4')->get();
        $tags = Tag::all();
        $courses = Course::all();
        $files = DB::select("SELECT * FROM files WHERE project_id=".$project->id);
        $idsCourses = [];
        $idsTags = [];
        $idsUsers = [];
        foreach($projectTags as $tag) {
            $idsTags[] = $tag->id;
        }
        foreach($projectCourses as $course) {
            $idsCourses[] = $course->id;
        }
        foreach($projectUsers as $user) {
            $idsUsers[] = $user->id;
        }

        $started_date = \DateTime::createFromFormat('d/m/Y', $project->started_date)->format('Y-m-d');
        $finished_date = "";
        if($project->finished_date != 'Em andamento') {
            $finished_date = \DateTime::createFromFormat('d/m/Y', $project->finished_date)->format('Y-m-d');
        }
        return view('projects.edit', compact('started_date', 'finished_date', 'project', 'users', 'tags', 'files', 'idsTags', 'idsCourses', 'idsUsers', 'courses'));
    }

    public function update(StoreProject $request, $id) {
        $project = Project::find($id);

        $dataProject = [
            'title' => $request['title'],
            'description' => $request['description'],
            'started_date' => $request['started_date'],
            'finished_date' => $request['finished_date'],
            'private' => isset($request['private']) ? '1' : '0',
        ];

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $name = str_random(5).kebab_case($request['title']).str_random(5);
            $extension = $request->image->extension();
            $nameFile = "{$name}.{$extension}";
            $dataProject['image'] = $nameFile;
            $upload = $request->image->storeAs('public/projects', $nameFile);
            if($project->image) {
                Storage::delete('public/projects/'.$project->image);
            }
            if(!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload da imagem!');
        }
        
        $project->update($dataProject);

        DB::delete('DELETE FROM projects_courses WHERE project_id = ?', [$project->id]);
        DB::delete('DELETE FROM projects_users WHERE project_id = ?', [$project->id]);
        DB::delete('DELETE FROM projects_tags WHERE project_id = ?', [$project->id]);
        foreach($request['courses'] as $course) {
            DB::insert('INSERT INTO projects_courses (project_id, course_id) VALUES (?, ?)', [$project->id, $course]);
        }
        foreach($request['users'] as $user) {
            DB::insert('INSERT INTO projects_users (project_id, user_id) VALUES (?, ?)', [$project->id, $user]);
        }
        foreach($request['tags'] as $tag) {
            DB::insert('INSERT INTO projects_tags (project_id, tag_id) VALUES (?, ?)', [$project->id, $tag]);
        }

        if($files = $request->file('files')) {
            foreach($files as $file) {
                $name = str_random(5).str_shuffle('abcdefghijklmnopqrstuvwxyz').str_random(5);
                $extension = $file->extension();
                $nameFile = "{$name}.{$extension}";
                $size = $file->getSize();
                
                $upload = $file->storeAs('public/files', $nameFile);
                if(!$upload)
                    return response()->json(['message' => 'Arquivo não pode ser enviado'], 400);
        
                DB::insert("INSERT INTO files (project_id, path, extension, size) VALUES (?,?,?,?)", [$project->id, $nameFile, $extension, $size]);
            }
        }

        return redirect()->action('ProjectsController@index')->with('success', 'Projeto cadastrado com sucesso!');


    }

    public function delete($id) {
        $project = Project::find($id);
        
        if(!$project) {
            return redirect()->back()->with('error', 'Projeto não encontrado, tente novamente!');
        }

        $result = $project->update(['status' => '1']);

        if(!$result) {
            return redirect()->back()->with('error', 'Não foi possível deletar o projeto, tente novamente!');
        }

        return redirect()->back()->with('success', 'Projeto desativado com sucesso!');
    }

    public function active($id) {
        $project = Project::find($id);
        
        if(!$project) {
            return redirect()->back()->with('error', 'Projeto não encontrado, tente novamente!');
        }

        $result = $project->update(['status' => '0']);

        if(!$result) {
            return redirect()->back()->with('error', 'Não foi possível ativar o projeto, tente novamente!');
        }

        return redirect()->back()->with('success', 'Projeto ativado com sucesso!');
    }

    public function show($id) {
        $project = Project::where('projects.id', $id)
            ->leftJoin('project_likes', function($join) {
                $join->on('project_likes.project_id', '=', 'projects.id');
                $join->where('project_likes.user_id', '=', Auth::user()->id);
            })->select('projects.*', 'project_likes.id as like')->first();
        $courses = DB::select("SELECT c.name FROM projects_courses pc INNER JOIN courses c ON pc.course_id=c.id WHERE pc.project_id=".$project->id);
        $users = DB::select("SELECT u.id, u.name, u.email, u.image, u.access_level FROM projects_users pu INNER JOIN users u ON pu.user_id=u.id WHERE pu.project_id=".$project->id);
        $tags = DB::select("SELECT t.name FROM projects_tags pt INNER JOIN tags t ON pt.tag_id=t.id WHERE pt.project_id=".$project->id);
        $files = DB::select("SELECT * FROM files WHERE project_id=".$project->id);
        $auth = Auth::user();
        $auths = [];
        foreach($users as $user) {
            $auths[] = $user->id;
        }

        return view('projects.show', compact('project', 'courses', 'users', 'tags', 'files', 'auth', 'auths'));
    }

    public function deleteFile($path) {
        $result = DB::delete("DELETE FROM files WHERE path='".$path."'");

        if(!$result) {
            return redirect()->back()->with('error', 'Não foi possível excluir o arquivo.');
        }

        Storage::delete('public/files/'.$path);

        return redirect()->back();
    }

    public function pdf($id) {
        return PDF::loadView('projects.pdf')->stream();
    }

    public function like($id) {
        $existLike = DB::select('SELECT * FROM project_likes WHERE project_id = ? AND user_id = ?', [$id, Auth::user()->id]);

        if(empty($existLike)) {
            DB::insert('INSERT INTO project_likes (project_id, user_id) VALUES (?,?)', [$id, Auth::user()->id]);
            return response()->json(['status' => 'liked']);
        } else {
            DB::delete('DELETE FROM project_likes WHERE project_id = ? AND user_id = ?', [$id, Auth::user()->id]);
            return response()->json(['status' => 'unliked']);
        }

        return response()->json(['status' => 'error']);
    }

    public function is_in_array($array, $key, $key_value){
        $within_array = 'no';
        foreach( $array as $k=>$v ){
          if( is_array($v) ){
              $within_array = is_in_array($v, $key, $key_value);
              if( $within_array == 'yes' ){
                  break;
              }
          } else {
                  if( $v == $key_value && $k == $key ){
                          $within_array = 'yes';
                          break;
                  }
          }
        }
        return $within_array;
  }
}
