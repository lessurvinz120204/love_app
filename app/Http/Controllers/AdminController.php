<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;

class AdminController extends Controller
{
    public function dashboard() {
        if (session('role') !== 'admin') return redirect('/login');
        $uploads = Upload::latest()->get();
        return view('admin.dashboard', compact('uploads'));
    }

    public function upload(Request $request) {
        if (session('role') !== 'admin') return redirect('/login');

        $type = $request->input('type');

        if ($type === 'letter') {
            $request->validate([
                'title' => 'nullable|string|max:255',
                'content' => 'required|string',
            ]);

            Upload::create([
                'type' => 'letter',
                'title' => $request->title,
                'content' => $request->content,
                'file_path' => null,
                'original_name' => $request->title ?? 'Letter',
            ]);

        } else {
            // Remove max size validation - let PHP handle it
            $request->validate([
                'file' => 'required|file',
                'type' => 'required|in:song,photo',
                'title' => 'nullable|string|max:255',
            ]);

            $file = $request->file('file');
            $path = $file->store('uploads/' . $type, 'public');

            Upload::create([
                'type' => $type,
                'title' => $request->title,
                'content' => null,
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
            ]);
        }

        return back()->with('success', 'Saved successfully!');
    }

    public function delete($id) {
        if (session('role') !== 'admin') return redirect('/login');
        Upload::findOrFail($id)->delete();
        return back()->with('success', 'Deleted!');
    }
}