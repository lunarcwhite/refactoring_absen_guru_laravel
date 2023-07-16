<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Excel;
use App\Imports\ImportGuru;

class KelolaGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    function error($message)
    {
        return redirect()->back()->withErrors($message);
    }

    public function index()
    {
        $data['users'] = User::where('role_id', 2)
            ->orderBy('nama')
            ->get();
        return view('admin.kelolaMasterData.kelolaGuru.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:users,email',
            'no_hp' => 'required',
            'nuptk' => 'required|unique:users,nuptk',
        ]);

        $password = 'gbghfd65#2w4512345sdghgh^$^';
        $input = $request->all();
        $input['role_id'] = 2;
        $input['username'] = $request->nuptk;
        $input['password'] = bcrypt($password);
        try {
            User::create($input);
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
        return redirect()->back()->with('success', 'Berhasil Menambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $user)
    {
        return User::where('id', $user)->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $user)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
            'nuptk' => 'required',
        ]);

        $password = 'gbghfd65#2w4512345sdghgh^$^';
        $input = $request->except('_token', '_method');
        $input['role_id'] = 2;
        $input['username'] = $request->nuptk;
        $input['password'] = bcrypt($password);
        try {
            User::where('id', $user)->update($input);
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
        return redirect()->back()->with('success', 'Berhasil Memperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    function import(Request $request)
    {
        $request->validate([
            'import_guru' => 'required'
        ]);
        try {
            Excel::import(new ImportGuru, $request->file('import_guru'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return redirect()->back()->withErrors($failures);
        }
        return redirect()->back()->with('success','Import Guru Berhasil');
    }
}
