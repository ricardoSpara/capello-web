<?php

namespace Capello\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Capello\Http\Requests\UpdateUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Capello\User;
use Carbon\Carbon;

class UserController extends Controller
{


    public function profile() {
        $user = User::find(auth()->user()->id);
        return view('user.profile', compact('user'));
    }

    public function changePassword() {
        return view('user.changePassword');
    }

    public function storeNewPassword(Request $request) {
        $data = $request->except('_token');
        if($data['password'] == $data['repeat_password']) {
            $id = Auth::user()->id;
            $user = User::find($id);
            if(Hash::check($data['password'], $user->password)) {
                $user->update(['password' => Hash::make($data['new_password'])]);

                return redirect()->back()->with('success', 'Senha alterada com sucesso!');
            } else { 
                return redirect()->back()->with('error', 'As senhas não coincidem 2');    
            }
        } else {
            return redirect()->back()->with('error', 'As senhas não coincidem');
        }
    }

    public function updateProfile(UpdateUser $request) {
        $user = User::find(Auth::user()->id);
        $data = $request->except('_token');
        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $name = str_random(5).kebab_case($data['name']).str_random(5);
            $extension = $request->image->extension();
            $nameFile = "{$name}.{$extension}";
            $data['image'] = $nameFile;
            $upload = $request->image->storeAs('public/users', $nameFile);
            if($user->image) {
                Storage::delete('public/users/'.$user->image);
            }
            if(!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload da imagem!');
        }


        $data['birth'] = \DateTime::createFromFormat('d/m/Y', $data['birth']);
        $data['birth'] = $data['birth']->format('Y-m-d');

        $user->update($data);

        return redirect()->route('user.profile')->with('success', 'Usuário alterado com sucesso!');
        
    }

    public function approveStudents() {
        $students = User::where('access_level', '1')->where('status', '0')->join('courses', 'users.course_id', '=', 'courses.id')->select('users.*', 'courses.name as course_name')->get();

        return view('auth.students', compact('students'));
    }

    public function storeApproveStudents($id, $what) {
        $student = User::find($id);

        if($what == 'approve') {
            $student->update(['access_level' => '3']);
        } elseif($what == 'decline') {
            $student->update(['access_level' => '0']);
        }

        return redirect()->route('students.approve');
    }

    public function approveTeacher() {
        $teachers = User::where('access_level', '2')->where('status', '0')->join('courses', 'users.course_id', '=', 'courses.id')->select('users.*', 'courses.name as course_name')->get();

        return view('auth.teachers', compact('teachers'));
    }

    public function storeApproveTeachers($id, $what) {
        $teacher = User::find($id);

        if($what == 'approve') {
            $teacher->update(['access_level' => '4']);
        } elseif($what == 'decline') {
            $teacher->update(['access_level' => '0']);
        }

        return redirect()->route('teachers.approve');
    }

    public function students() {
        $students = User::where('access_level', '3')->join('courses', 'users.course_id', '=', 'courses.id')->select('users.*', 'courses.name as course_name')->get();

        return view('user.students', compact('students'));
    }

    public function deleteStudent($id) {
        $user = User::find($id);

        if($user->status == '1') {
            $user->update(['status' => '0']);
            return redirect()->back()->with('success', 'Aluno ativado com sucesso!');
        } else {
            $user->update(['status' => '1']);
            return redirect()->back()->with('success', 'Aluno excluído com sucesso!');
        }

    }

    public function profileStudent($id) { 
        $student = User::where('users.id', $id)->join('courses', 'users.course_id', '=', 'courses.id')->select('users.*', 'courses.name as course_name')->first();
        return view('user.student', compact('student'));
    }

    public function pdf($action) {
        $users = null;
        if($action == 'teachers') {
            $users = User::where('access_level', '4')->join('courses', 'users.course_id', '=', 'courses.id')->where('status', '0')->select('users.*', 'courses.name as course_name')->get();
        } elseif($action == 'students') {
            $users = User::where('access_level', '3')->join('courses', 'users.course_id', '=', 'courses.id')->where('status', '0')->select('users.*', 'courses.name as course_name')->get();
        } elseif($actions = 'guests') {
            $users = User::where('access_level', '0')->join('courses', 'users.course_id', '=', 'courses.id')->where('status', '0')->select('users.*', 'courses.name as course_name')->get();
        } else {
            $users = User::join('courses', 'users.course_id', '=', 'courses.id')->where('status', '0')->select('users.*', 'courses.name as course_name')->orderBy('users.access_level')->get();
        }

        $data['users'] = $users;
        $data['action'] = $action;
        
        // dd($users);
        $pdf = PDF::loadView('user.pdf', $data);
        
        return $pdf->output('idontknow.pdf');
    }
}
