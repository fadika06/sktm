<?php

namespace Bantenprov\Sktm\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\Sktm\Facades\SktmFacade;

/* Models */
use Bantenprov\Sktm\Models\Bantenprov\Sktm\Sktm;
use Bantenprov\Sktm\Models\Bantenprov\Sktm\MasterSktm;
use App\User;

/* Etc */
use Validator;

/**
 * The SktmController class.
 *
 * @package Bantenprov\Sktm
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class SktmController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $sktm;
    protected $master_sktm;
    protected $user;

    public function __construct(Sktm $sktm, MasterSktm $master_sktm, User $user)
    {
        $this->sktm = $sktm;
        $this->master_sktm = $master_sktm;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);

            $query = $this->sktm->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->sktm->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('nomor_un', 'like', $value)
                    ->orWhere('nilai', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->paginate($perPage);

        foreach($response as $master_sktm){
            array_set($response->data, 'master_sktm', $master_sktm->master_sktm->nama);
        }

        foreach($response as $user){
            array_set($response->data, 'user', $user->user->name);
        }

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $users = $this->user->all();
        $master_sktms = $this->master_sktm->all();

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }

        foreach($master_sktms as $master_sktm){
            array_set($master_sktm, 'label', $master_sktm->nama);
        }
        
        $response['master_sktm'] = $master_sktms;
        $response['user'] = $users;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sktm  $sktm
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sktm = $this->sktm;

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|unique:sktms,user_id',
            'nomor_un' => 'required',
            'master_sktm_id' => 'required',
            'no_sktm' => 'required',
            'nilai' => 'required',
        ]);

        if($validator->fails()){
            $check = $sktm->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, Username ' . $request->user_id . ' already exists';
            } else {
                $sktm->user_id = $request->input('user_id');
                $sktm->nomor_un = $request->input('nomor_un');
                $sktm->master_sktm_id = $request->input('master_sktm_id');
                $sktm->no_sktm = $request->input('no_sktm');
                $sktm->nilai = $request->input('nilai');
                $sktm->save();

                $response['message'] = 'success';
            }
        } else {
                $sktm->user_id = $request->input('user_id');
                $sktm->nomor_un = $request->input('nomor_un');
                $sktm->master_sktm_id = $request->input('master_sktm_id');
                $sktm->no_sktm = $request->input('no_sktm');
                $sktm->nilai = $request->input('nilai');
                $sktm->save();

            $response['message'] = 'success';
        }

        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sktm = $this->sktm->findOrFail($id);
        
        $response['user'] = $sktm->user;
        $response['master_sktm'] = $sktm->master_sktm;
        $response['sktm'] = $sktm;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sktm  $sktm
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $sktm = $this->sktm->findOrFail($id);

        array_set($sktm->user, 'label', $sktm->user->name);
        array_set($sktm->master_sktm, 'label', $sktm->master_sktm->nama);
        
        $response['master_sktm'] = $sktm->master_sktm;
        $response['sktm'] = $sktm;
        $response['user'] = $sktm->user;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sktm  $sktm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sktm = $this->sktm->findOrFail($id);

        if ($request->input('master_sktm_id') == $request->input('master_sktm_id'))
        {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|unique:sktms,user_id',
            'nomor_un' => 'required',
            'master_sktm_id' => 'required',
            'no_sktm' => 'required',
            'nilai' => 'required',
                
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|unique:sktms,user_id',
            'nomor_un' => 'required',
            'master_sktm_id' => 'required',
            'no_sktm' => 'required',
            'nilai' => 'required',
            ]);
        }

        if ($validator->fails()) {
            $check = $sktm->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, Master SKTM ' . $request->user_id . ' already exists';
            } else {
                $sktm->user_id = $request->input('user_id');
                $sktm->nomor_un = $request->input('nomor_un');
                $sktm->master_sktm_id = $request->input('master_sktm_id');
                $sktm->no_sktm = $request->input('no_sktm');
                $sktm->nilai = $request->input('nilai');
                $sktm->save();

                $response['message'] = 'success';
            }
        } else {
                $sktm->user_id = $request->input('user_id');
                $sktm->nomor_un = $request->input('nomor_un');
                $sktm->master_sktm_id = $request->input('master_sktm_id');
                $sktm->no_sktm = $request->input('no_sktm');
                $sktm->nilai = $request->input('nilai');
                $sktm->save();

            $response['message'] = 'success';
        }

        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sktm  $sktm
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sktm = $this->sktm->findOrFail($id);

        if ($sktm->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        return json_encode($response);
    }
}
