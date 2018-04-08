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
        $response = $query->with('user')->paginate($perPage);

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
        $response = [];

        $users_special = $this->user->all();
        $users_standar = $this->user->find(\Auth::User()->id);
        $current_user = \Auth::User();

        $role_check = \Auth::User()->hasRole(['superadministrator','administrator']);

        if($role_check){
            $response['user_special'] = true;
            foreach($users_special as $user){
                array_set($user, 'label', $user->name);
            }
            $response['user'] = $users_special;
        }else{
            $response['user_special'] = false;
            array_set($users_standar, 'label', $users_standar->name);
            $response['user'] = $users_standar;
        }

        array_set($current_user, 'label', $current_user->name);

        $response['current_user'] = $current_user;
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
            /*'user_id' => 'required|unique:master_sktms,user_id',*/
            'user_id' => 'required',
            'nama' => 'required',
            'nilai' => 'required',
            'instansi' => 'required',
        ]);

        /*if($validator->fails()){
            $check = $master_sktm->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed ! Username, already exists';*/
          if($validator->fails()){
            $check = $master_sktm->where('label',$request->label)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed ! Username, already exists';

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
        $response = array();
        $message  = array();
        $master_sktm = $this->master_sktm->findOrFail($id);

            $validator = Validator::make($request->all(), [
                /*'user_id' => 'required|unique:master_sktms,user_id,'.$id,*/
                'user_id' => 'required',
                'nama' => 'required',
                'nilai' => 'required',
                'instansi' => 'required',

            ]);

        if ($validator->fails()) {

            foreach($validator->messages()->getMessages() as $key => $error){
                        foreach($error AS $error_get) {
                            array_push($message, $error_get);
                        }
                    }

             /*$check_user = $this->master_sktm->where('id','!=', $id)->where('user_id', $request->user_id);*/
             $check_user = $this->master_sktm->where('id','!=', $id)->where('label', $request->label);

             if($check_user->count() > 0){
                  $response['message'] = implode("\n",$message);

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
