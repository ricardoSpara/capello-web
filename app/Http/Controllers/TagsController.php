<?php

namespace Capello\Http\Controllers;

use Illuminate\Http\Request;
use Capello\Models\Tag;
use Capello\Models\Course;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{
    private $totalPages = 20;

    public function index() {
        $tags = Tag::join('courses', 'tags.course_id', '=', 'courses.id')->select('tags.*', 'courses.name as course_name')->get();
        return view('tags.index', compact('tags'));
    }

    public function myTags() {
        $tags = Tag::where('user_id', '=', Auth::user()->id)->get();
        return view('tags.index', compact('tags'));
    }

    public function create() {
        $courses = Course::all();
        return view('tags.create', compact('courses'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'course_id' => 'required'
        ]);

        $data['user_id'] = Auth::user()->id;
        Tag::create($data);

        return redirect()->route('tags.index')->with('success', 'Tag cadastrada com sucesso!');
    }

    public function edit($id) {
        $tag = Tag::find($id);
        $courses = Course::all();

        return view('tags.edit', compact('tag', 'courses'));
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'name' => 'required',
            'course_id' => 'required'
        ]);

        $tag = Tag::find($id);

        $tag->update($data);

        return redirect()->route('tags.index')->with('success', 'Tag atualizada com sucesso!');
    }

    public function delete($id) {
        $tag = Tag::find($id);

        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Tag excluída com sucesso!');
    }
}
