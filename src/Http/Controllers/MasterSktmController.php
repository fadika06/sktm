<?php

namespace Bantenprov\Sktm\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\Sktm\Facades\SktmFacade;

/* Models */
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
class MasterSktmController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $master_sktm;
    protected $user;

    public function __construct(MasterSktm $master_sktm, User $user)
    {
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

            $query = $this->master_sktm->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->master_sktm->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('nama', 'like', $value)
                    ->orWhere('nilai', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->paginate($perPage);

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

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }
        
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
        $master_sktm = $this->master_sktm;

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|unique:master_sktms,user_id',
            'nama' => 'required',
            'nilai' => 'required',
            'instansi' => 'required',
        ]);

        if($validator->fails()){
            $check = $master_sktm->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, Username ' . $request->user_id . ' already exists';
            } else {
                $master_sktm->user_id = $request->input('user_id');
                $master_sktm->nama = $request->input('nama');
                $master_sktm->nilai = $request->input('nilai');
                $master_sktm->instansi = $request->input('instansi');
                $master_sktm->save();

                $response['message'] = 'success';
            }
        } else {
                $master_sktm->user_id = $request->input('user_id');
                $master_sktm->nama = $request->input('nama');
                $master_sktm->nilai = $request->input('nilai');
                $master_sktm->instansi = $request->input('instansi');
                $master_sktm->save();

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
        $master_sktm = $this->master_sktm->findOrFail($id);
        
        $response['user'] = $master_sktm->user;
        $response['master_sktm'] = $master_sktm;
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
        $master_sktm = $this->master_sktm->findOrFail($id);

        array_set($master_sktm->user, 'label', $master_sktm->user->name);

        $response['master_sktm'] = $master_sktm;
        $response['user'] = $master_sktm->user;
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
        $master_sktm = $this->master_sktm->findOrFail($id);

        if ($request->input('user_id') == $request->input('user_id'))
        {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|unique:master_sktms,user_id',
                'nama' => 'required',
                'nilai' => 'required',
                'instansi' => 'required',
                
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|unique:master_sktms,user_id',
                'nama' => 'required',
                'nilai' => 'required',
                'instansi' => 'required',
            ]);
        }

        if ($validator->fails()) {
            $check = $master_sktm->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, Username ' . $request->user_id . ' already exists';
            } else {
                $master_sktm->user_id = $request->input('user_id');
                $master_sktm->nama = $request->input('nama');
                $master_sktm->nilai = $request->input('nilai');
                $master_sktm->instansi = $request->input('instansi');
                $master_sktm->save();

                $response['message'] = 'success';
            }
        } else {
                $master_sktm->user_id = $request->input('user_id');
                $master_sktm->nama = $request->input('nama');
                $master_sktm->nilai = $request->input('nilai');
                $master_sktm->instansi = $request->input('instansi');
                $master_sktm->save();

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
        $master_sktm = $this->master_sktm->findOrFail($id);

        if ($master_sktm->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        return json_encode($response);
    }
}
