<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use App\Models\Contest;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ParticipantRequest;
use App\Models\Judge;

class ParticipantController extends Controller
{
    public function index()
    {
        $data['participants'] = Participant::latest()->get();
        return view('client.participants.index', $data);
    }

    public function create(Request $request)
    {
        $data['maxDate']    = Carbon::now()->subYears(3)->format('Y-m-d');
        $contest_id         = $request['contest_id'];
        $data['contest']    = [];
        $data['contests']   = Contest::where('status', 'Active')->orderBy('title')->get();
        if(isset($contest_id)) {
            $data['contest'] = Contest::find($contest_id);
        }
        return view('client.participants.create', $data);
    }

    public function store(ParticipantRequest $request)
    {
        $participant = new Participant();
        $participant->contest_id        = $request['contest_id'];
        $participant->fname             = $request['fname'];
        $participant->mname             = $request['mname'];
        $participant->lname             = $request['lname'];
        $participant->birthdate         = $request['birthdate'];
        $participant->contact_number    = $request['contact_number'];
        $participant->address           = $request['address'];
        $participant->city              = $request['city'];
        $participant->gender            = $request['gender'];
        $participant->status            = $request['status'];

        if(isset($request['photo']) && $request->has('photo')) {
            $file  = $request->file('photo');
            $photo = time().'.'.$file->getClientOriginalExtension();

            $path = Storage::disk('upcloud')->putFileAs(
                'pageant/uploads/participants',
                $file,
                $photo,
                'public'
            );
            
            $participant->photo = Storage::disk('upcloud')->url($path);
        }

        $participant->save();

        return redirect()->to('client/participants')->with('success', 'New participant has been added.');
    }

    public function edit(Request $request, $id)
    {
        $data['maxDate']     = Carbon::now()->subYears(3)->format('Y-m-d');
        $data['participant'] = $participant = Participant::find($id);
        $data['contest']     = Contest::find($participant->contest_id);
        return view('client.participants.edit', $data);
    }

    public function update(ParticipantRequest $request, $id)
    {
        $participant = Participant::find($id);
        $participant->contest_id        = $request['contest_id'];
        $participant->fname             = $request['fname'];
        $participant->mname             = $request['mname'];
        $participant->lname             = $request['lname'];
        $participant->birthdate         = $request['birthdate'];
        $participant->contact_number    = $request['contact_number'];
        $participant->address           = $request['address'];
        $participant->city              = $request['city'];
        $participant->gender            = $request['gender'];
        $participant->status            = $request['status'];

        if(isset($request['photo']) && $request->has('photo')) {
            $file  = $request->file('photo');
            $photo = time().'.'.$file->getClientOriginalExtension();

            $path = Storage::disk('upcloud')->putFileAs(
                'pageant/uploads/participants',
                $file,
                $photo,
                'public'
            );
            
            $participant->photo = Storage::disk('upcloud')->url($path);
        }

        $participant->save();

        return redirect()->to('client/participants')->with('success', 'New participant has been added.');
    }

    public function show($id)
    {
        $data['participant'] = $participant = Participant::find($id);
        $data['judges']      = Judge::where('contest_id', $participant->contest_id)->get();
        $data['contest']     = Contest::find($participant->contest_id);
        return view('client.participants.show', $data);
    }

    public function destroy($id)
    {
        $participant = Participant::find($id);
        if(isset($participant->photo)) {
            Storage::disk('upcloud')->delete('pageant/uploads/participants/'.basename($participant->photo));
        }
        $participant->delete();

        $data['success'] = 'Participant has been deleted.';
        return response()->json($data);
    }
}
