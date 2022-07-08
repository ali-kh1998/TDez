<?php

namespace App\Http\Controllers;

use App\Models\Theater;
use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class TheaterController extends Controller
{
    public function __construct()
    {
        $this->middleware('superadmin');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Ths = Theater::all();
        return view('theater.index',['Ths' => $Ths]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover' => 'required|mimes:jpg,bmp,png|max:2048'
        ]);


        $coverfile = $request->file('cover');
        $coverfilename = $coverfile->getClientOriginalName();
        $extension = $coverfile->extension();
        $newcoverfilename = sha1(time().'_'.rand(1000000000,1999999999).'_'.rand(1000000000,1999999999).'_'.$coverfilename);
        $newcoverfilename = $newcoverfilename.'.'.$extension;

        Storage::disk('local')->putFileAs(
            'public/files',
            $coverfile,
            $newcoverfilename
        );


        Theater::Create(["title" =>$request->title ,"description"=>$request->description, 'cover_file_name'=> $newcoverfilename, 'original_cover_file_name'=>$coverfilename]);
        return redirect()->action([TheaterController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Theater  $theater
     * @return \Illuminate\Http\Response
     */
    public function show(Theater $theater)
    {
        $theater->load('shows');
        $url = Storage::url('public/files/'.$theater->cover_file_name);
        return view('theater.show',['theater' => $theater,'cover_url'=>$url ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Theater  $theater
     * @return \Illuminate\Http\Response
     */
    public function edit(Theater $theater)
    {
        /*
        if (! Gate::allows('update_book', $theater)) {
            abort(403);
        }
        */
        $all_shows = Show::all();
        $theater->load('shows');
        return view('theater.edit',['theater' => $theater]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Theater  $theater
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Theater $theater)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        /*
        if (! Gate::allows('update_book', $book)) {
            abort(403);
        }
        */
        $theater->Update(["title" =>$request->title ,"description"=>$request->description ]);
        $url = Storage::url('public/files/'.$theater->cover_file_name);
        return view('theater.show',['theater' => $theater,'cover_url'=>$url ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Theater  $theater
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theater $theater)
    {
        //
    }
}
