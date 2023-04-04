<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $links = $user->links()->latest()->paginate(5);

        return view('links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('links.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url|max:255',
        ]);

        $validator->after(function ($validator) {
            $user = Auth::user();

            if ($user->links()->count() >= 5) {
                $validator->errors()->add('url', 'You can only have a maximum of 5 links.');
            }
        });

        if ($validator->fails()) {
            return redirect()->route('links.create')
                ->withErrors($validator)
                ->withInput();
        }


        $shortUrl = Str::random(6);

        while (Link::where('short_url', $shortUrl)->exists()) {
            $shortUrl = Str::random(6);
        }
    
        $link = new Link([
            'url' => $request->input('url'),
            'short_url' => $shortUrl,
            'user_id' => auth()->id(),
            'expires_at' => now()->addDay()
        ]);
    
        $link->save();
    
        return redirect()->route('links.index')
                         ->with('success', 'Link created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        return view('links.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {

    $validator = Validator::make($request->all(), [
        'url' => 'required|url|max:255',
    ]);

    if ($validator->fails()) {
        return redirect()->route('links.edit')
            ->withErrors($validator)
            ->withInput();
    }

    $shorLink = Str::random(6);

    while (Link::where('short_url', $shorLink)->exists()) {
        $shorLink = Str::random(6);
    }
    $link = Link::where('id', $link['id'])->first();
 
    $link->url = $request->input('url');
    $link->short_url = $shorLink;
    $link->expires_at = now()->addDay();
    $link->user_id = auth()->user()->id;
 
    $link->save();

    return redirect()->route('links.index')
    ->with('success', 'Link updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        $user = Auth::user();
        if ($user && $user->id == $link->user_id) {
            $link->delete();
        }
        return redirect()->route('links.index')
        ->with('success', 'Link deleted successfully.');
        
    }

    /**
     * Display a listing of the all links of users.
     */
    public function getAllLinks()
    {
       $linkCount = Link::count();
       if ($linkCount > 20) {
           $oldestLink = Link::orderBy('created_at', 'asc')->first();
           $oldestLink->delete();
       }

       $links = Link::all();

        return view('welcome', compact('links'));

    }
}
