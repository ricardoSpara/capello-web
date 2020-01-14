<?php

namespace Capello\Http\Controllers;

use Illuminate\Http\Request;
use Capello\Models\Course;

class CoursesController extends Controller
{
    public function index() {
        $courses = Course::all();

        return view('courses.index', compact('courses'));
    }

    public function create() {
        return view('courses.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
        ]);

        $course = Course::create($data);

        return redirect()->route('courses.index')->with('success', 'Curso cadastrado com sucesso!');
    }

    public function edit($id) {
        $course = Course::find($id);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'name' => 'required',
        ]);

        $course = Course::find($id);
        $course->update($data);
        return redirect()->route('courses.index')->with('success', 'Curso atualizado com sucesso!');
    }

    public function delete($id) {
        $course = Course::find($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Curso excluído com sucesso!');
    }
}
