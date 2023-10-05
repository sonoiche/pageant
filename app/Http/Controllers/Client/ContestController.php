<?php

namespace App\Http\Controllers\Client;

use App\Models\Contest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContestRequest;
use Illuminate\Support\Facades\Storage;

class ContestController extends Controller
{
    public function index()
    {
        $data['contests'] = Contest::where('status', "Active")->latest()->get();
        return view('client.contests.index', $data);
    }

    public function create()
    {
        return view('client.contests.create');
    }

    public function store(ContestRequest $request)
    {
        $contest_title          = Str::slug($request['title']);
        $contest = new Contest;
        $contest->title         = $request['title'];
        $contest->venue         = $request['venue'];
        $contest->description   = $request['description'];
        $contest->participants  = $request['participants'];
        $contest->date_held     = $request['date_held'];
        $contest->status        = $request['status'];
        $contest->user_id       = auth()->user()->id;
        $contest->link          = config('app.url').'/contests/'.$contest_title.'/'.Str::random(15);

        if(isset($request['logo']) && $request->has('logo')) {
            $file  = $request->file('logo');
            $logo = time().'.'.$file->getClientOriginalExtension();

            $path = Storage::disk('upcloud')->putFileAs(
                'pageant/uploads/contest',
                $file,
                $logo,
                'public'
            );
            
            $contest->logo = Storage::disk('upcloud')->url($path);
        }

        $contest->save();

        return redirect()->to('client/contests')->with('success', 'Contest has been created.');
    }

    public function edit(Request $request, $id)
    {
        $what = $request['what'];
        switch ($what) {
            case 'deleteImage':
                $contest = Contest::find($id);
                if(isset($contest->logo)) {
                    Storage::disk('upcloud')->delete('pageant/uploads/contest/'.basename($contest->logo));
                }
                $contest->logo = null;
                $contest->save();

                return response()->json(200);
                break;
            
            default:
                $data['contest'] = Contest::find($id);
                return view('client.contests.edit', $data);
                break;
        }
    }

    public function update(ContestRequest $request, $id)
    {
        $contest = Contest::find($id);
        $contest->title         = $request['title'];
        $contest->venue         = $request['venue'];
        $contest->description   = $request['description'];
        $contest->participants  = $request['participants'];
        $contest->date_held     = $request['date_held'];
        $contest->status        = $request['status'];
        $contest->user_id       = auth()->user()->id;

        if(isset($request['logo']) && $request->has('logo')) {
            $file  = $request->file('logo');
            $logo = time().'.'.$file->getClientOriginalExtension();

            $path = Storage::disk('upcloud')->putFileAs(
                'pageant/uploads/contest',
                $file,
                $logo,
                'public'
            );
            
            $contest->logo = Storage::disk('upcloud')->url($path);
        }

        $contest->save();

        return redirect()->to('client/contests')->with('success', 'Contest has been updated.');
    }

    public function destroy($id)
    {
        $contest = Contest::find($id);
        if(isset($contest->logo)) {
            Storage::disk('upcloud')->delete('pageant/uploads/contest/'.basename($contest->logo));
        }
        $contest->delete();

        $data['success'] = 'Contest has been deleted.';
        return response()->json($data);
    }
}
