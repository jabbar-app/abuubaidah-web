<?php

namespace App\Http\Controllers;

use App\Models\Help;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpController extends Controller
{
    public function index()
    {
        $helps = Help::all();
        return view('admin.helps.index', compact('helps'));
    }

    public function create()
    {
        $programs = Program::all();
        $users = User::all();
        return view('admin.helps.create', compact('programs', 'users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_upload' => 'required|file',
        ]);

        $fileName = 'Issue-'. time() . '.' . $request->file_upload->extension();
        $request->file_upload->move(public_path('uploads'), $fileName);

        Help::create([
            'program_id' => $request->program_id,
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_upload' => $fileName,
        ]);

        return redirect()->route('helps.index');
    }

    public function show(Help $help)
    {
        return view('admin.helps.show', compact('help'));
    }

    public function edit(Help $help)
    {
        $programs = Program::all();
        $users = User::all();
        return view('admin.helps.edit', compact('help', 'programs', 'users'));
    }


    public function update(Request $request, Help $help)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_upload' => 'file',
        ]);

        if ($request->hasFile('file_upload')) {
            $fileName = time() . '.' . $request->file_upload->extension();
            $request->file_upload->move(public_path('uploads'), $fileName);
            $help->file_upload = $fileName;
        }

        $help->program_id = $request->program_id;
        $help->user_id = $request->user_id;
        $help->title = $request->title;
        $help->description = $request->description;
        $help->save();

        return redirect()->route('helps.index');
    }

    public function destroy(Help $help)
    {
        $help->delete();
        return redirect()->route('helps.index');
    }



    // For Student
    public function indexHelp()
    {
        $helps = Help::where('user_id', Auth::user()->id)->get();
        return view('student.helps.index', compact('helps'));
    }

    public function createHelp()
    {
        $programs = Program::all();
        return view('student.helps.create', compact('programs'));
    }


    public function storeHelp(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_upload' => 'required|file',
        ]);

        $fileName = 'Issue-'. time() . '.' . $request->file_upload->extension();
        $request->file_upload->move(public_path('uploads'), $fileName);

        Help::create([
            'program_id' => $request->program_id,
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_upload' => $fileName,
        ]);

        return redirect()->route('student.helps.index');
    }

    public function showHelp(Help $help)
    {
        return view('student.helps.show', compact('help'));
    }

    public function editHelp(Help $help)
    {
        $programs = Program::all();
        return view('student.helps.edit', compact('help', 'programs'));
    }


    public function updateHelp(Request $request, Help $help)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_upload' => 'file',
        ]);

        if ($request->hasFile('file_upload')) {
            $fileName = time() . '.' . $request->file_upload->extension();
            $request->file_upload->move(public_path('uploads'), $fileName);
            $help->file_upload = $fileName;
        }

        $help->program_id = $request->program_id;
        $help->user_id = $request->user_id;
        $help->title = $request->title;
        $help->description = $request->description;
        $help->save();

        return redirect()->route('student.helps.index');
    }
}
