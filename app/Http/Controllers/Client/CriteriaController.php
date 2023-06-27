<?php

namespace App\Http\Controllers\Client;

use App\Models\Contest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CriteriaRequest;
use App\Models\Criteria;

class CriteriaController extends Controller
{
    public function index()
    {
        $data['criterias'] = Criteria::latest()->get();
        return view('client.criteria.index', $data);
    }

    public function create(Request $request)
    {
        $contest_id         = $request['contest_id'];
        $data['contest']    = [];
        $data['contests']   = Contest::where('status', 'Active')->orderBy('title')->get();
        if(isset($contest_id)) {
            $data['contest'] = Contest::find($contest_id);
        }

        return view('client.criteria.create', $data);
    }

    public function store(CriteriaRequest $request)
    {
        $criteria = new Criteria;
        $criteria->name = $request['name'];
        $criteria->percentage = $request['percentage'];
        $criteria->contest_id = $request['contest_id'];
        $criteria->save();

        return redirect()->to('client/criteria')->with('success', 'New criteria has been added.');
    }

    public function edit($id)
    {
        $data['criteria']   = $criteria = Criteria::find($id);
        $data['contest']    = Contest::find($criteria->contest_id);

        return view('client.criteria.edit', $data);
    }

    public function update(CriteriaRequest $request, $id)
    {
        $criteria = Criteria::find($id);
        $criteria->name = $request['name'];
        $criteria->percentage = $request['percentage'];
        $criteria->save();

        return redirect()->to('client/criteria')->with('success', 'Criteria has been updated.');
    }

    public function destroy($id)
    {
        $criteria = Criteria::find($id);
        $criteria->delete();

        return response()->json(200);
    }
}
