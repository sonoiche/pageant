<?php

namespace App\Http\Controllers\Client;

use App\Models\Judge;
use App\Models\Contest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\JudgeRequest;
use App\Http\Controllers\Controller;

class JudgeController extends Controller
{
    public function index()
    {
        $data['judges'] = Judge::latest()->get();
        return view('client.judges.index', $data);
    }

    public function create(Request $request)
    {
        $contest_id         = $request['contest_id'];
        $data['contest']    = [];
        $data['contests']   = Contest::where('status', 'Active')->orderBy('title')->get();
        if(isset($contest_id)) {
            $data['contest'] = Contest::find($contest_id);
        }
        return view('client.judges.create', $data);
    }

    public function store(JudgeRequest $request)
    {
        $judge = new Judge;
        $judge->fname               = $request['fname'];
        $judge->mname               = $request['mname'];
        $judge->lname               = $request['lname'];
        $judge->email               = $request['email'];
        $judge->contact_number      = $request['contact_number'];
        $judge->position            = $request['position'];
        $judge->complete_address    = $request['complete_address'];
        $judge->access_key          = Str::random(15);
        $judge->contest_id          = $request['contest_id'];
        $judge->save();

        //send email
        //to do send an email to the judge
        return redirect()->to('client/judges')->with('success', 'New judge has been added.');
    }

    public function edit($id)
    {
        $data['judge']   = $judge = Judge::find($id);
        $data['contest'] = Contest::find($judge->contest_id);
        return view('client.judges.edit', $data);
    }

    public function update(JudgeRequest $request, $id)
    {
        $judge = Judge::find($id);
        $judge->fname               = $request['fname'];
        $judge->mname               = $request['mname'];
        $judge->lname               = $request['lname'];
        $judge->email               = $request['email'];
        $judge->contact_number      = $request['contact_number'];
        $judge->position            = $request['position'];
        $judge->complete_address    = $request['complete_address'];
        $judge->save();

        return redirect()->to('client/judges')->with('success', 'Judge information has been updated.');
    }

    public function destroy($id)
    {
        $judge = Judge::find($id);
        $judge->delete();

        return response()->json(200);
    }
}
