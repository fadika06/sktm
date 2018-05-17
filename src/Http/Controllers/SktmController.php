<?php

namespace Bantenprov\Sktm\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Bantenprov\Sktm\Facades\SktmFacade;

/* Models */
use Bantenprov\Sktm\Models\Bantenprov\Sktm\Sktm;
use Bantenprov\Siswa\Models\Bantenprov\Siswa\Siswa;
use Bantenprov\Sktm\Models\Bantenprov\Sktm\MasterSktm;
use App\User;
use Bantenprov\Nilai\Models\Bantenprov\Nilai\Nilai;
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\AdminSekolah;

/* Etc */
use Validator;
use Auth;

/**
 * The SktmController class.
 *
 * @package Bantenprov\Sktm
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class SktmController extends Controller
{
    protected $sktm;
    protected $siswa;
    protected $master_sktm;
    protected $user;
    protected $nilai;
    protected $admin_sekolah;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sktm             = new Sktm;
        $this->siswa            = new Siswa;
        $this->master_sktm      = new MasterSktm;
        $this->user             = new User;
        $this->nilai            = new Nilai;
        $this->admin_sekolah    = new AdminSekolah;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_sekolah = $this->admin_sekolah->where('admin_sekolah_id', Auth::user()->id)->first();

        if(is_null($admin_sekolah) && $this->checkRole(['superadministrator']) === false){
            $response = [];
            return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
        }
        
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);

            if($this->checkRole(['superadministrator'])){
                $query = $this->sktm->orderBy($sortCol, $sortDir);
            }else{
                $query = $this->sktm->where('user_id', $admin_sekolah->admin_sekolah_id)->orderBy($sortCol, $sortDir);
            }
        } else {
            if($this->checkRole(['superadministrator'])){
                $query = $this->sktm->orderBy('id', 'asc');
            }else{
                $query = $this->sktm->where('user_id', $admin_sekolah->admin_sekolah_id)->orderBy('id', 'asc');            
            }
        }

        if ($request->exists('filter')) {
            if($this->checkRole(['superadministrator'])){
                $query->where(function($q) use($request) {
                    $value = "%{$request->filter}%";

                    $q->where('sekolah_id', 'like', $value)
                        ->orWhere('admin_sekolah_id', 'like', $value);
                });
            }else{
                $query->where(function($q) use($request, $admin_sekolah) {
                    $value = "%{$request->filter}%";

                    $q->where('sekolah_id', $admin_sekolah->sekolah_id)->where('sekolah_id', 'like', $value);
                });
            }

        }


        $perPage    = request()->has('per_page') ? (int) request()->per_page : null;

        $response   = $query->with(['siswa', 'master_sktm', 'user'])->paginate($perPage);

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $sktms = $this->sktm->with(['master_sktm', 'user'])->get();

        $response['sktms']      = $sktms;
        $response['error']      = false;
        $response['message']    = 'Success';
        $response['status']     = true;

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id        = isset(Auth::User()->id) ? Auth::User()->id : null;
        $sktm           = $this->sktm->getAttributes();
        $users          = $this->user->getAttributes();
        $users_special  = $this->user->all();
        $users_standar  = $this->user->findOrFail($user_id);
        $current_user   = Auth::User();

        $admin_sekolah = $this->admin_sekolah->where('admin_sekolah_id', Auth::user()->id)->first();

        if($this->checkRole(['superadministrator'])){
            $siswas = $this->siswa->all();
        }else{
            $sekolah_id = $admin_sekolah->sekolah_id;
            $siswas     = $this->siswa->where('sekolah_id', $sekolah_id)->get();
        }

     //   dd($siswas);

        $role_check = Auth::User()->hasRole(['superadministrator','administrator']);

        if ($role_check) {
            $user_special = true;

            foreach ($users_special as $user) {
                array_set($user, 'label', $user->name);
            }

            $users = $users_special;
        } else {
            $user_special = false;

            array_set($users_standar, 'label', $users_standar->name);

            $users = $users_standar;
        }

        array_set($current_user, 'label', $current_user->name);

        $response['sktm']           = $sktm;
        $response['siswa']          = $siswas;
        $response['users']          = $users;
        $response['user_special']   = $user_special;
        $response['current_user']   = $current_user;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sktm = $this->sktm;

        $validator = Validator::make($request->all(), [
            'nomor_un'          => "required|exists:{$this->siswa->getTable()},nomor_un|unique:{$this->sktm->getTable()},nomor_un,NULL,id,deleted_at,NULL",
            'master_sktm_id'    => "required|exists:{$this->master_sktm->getTable()},id",
            'no_sktm'           => 'required|max:255',
            // 'nilai'             => 'required|numeric|min:0|max:100',
            'user_id'           => "required|exists:{$this->user->getTable()},id",
        ]);

        if ($validator->fails()) {
            $error      = true;
            $message    = $validator->errors()->first();
        } else {
            $sktm_master_sktm_id    = $request->input('master_sktm_id');
            $master_sktm            = $this->master_sktm->findOrFail($sktm_master_sktm_id);

            $sktm->nomor_un         = $request->input('nomor_un');
            $sktm->master_sktm_id   = $sktm_master_sktm_id;
            $sktm->no_sktm          = $request->input('no_sktm');
            $sktm->nilai            = $master_sktm->nilai;
            $sktm->user_id          = $request->input('user_id');

            $nilai = $this->nilai->updateOrCreate(
                [
                    'nomor_un'  => $sktm->nomor_un,
                ],
                [
                    'sktm'      => $sktm->nilai,
                    'total'     => null,
                    'user_id'   => $sktm->user_id,
                ]
            );

            DB::beginTransaction();

            if ($sktm->save() && $nilai->save())
            {
                DB::commit();

                $error      = false;
                $message    = 'Success';
            } else {
                DB::rollBack();

                $error      = true;
                $message    = 'Failed';
            }
        }

        $response['sktm']       = $sktm;
        $response['error']      = $error;
        $response['message']    = $message;
        $response['status']     = true;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sktm  $nilai
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sktm = $this->sktm->with(['siswa', 'master_sktm', 'user'])->findOrFail($id);

        $response['sktm']       = $sktm;
        $response['error']      = false;
        $response['message']    = 'Success';
        $response['status']     = true;

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sktm  $nilai
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_id        = isset(Auth::User()->id) ? Auth::User()->id : null;
        $sktm           = $this->sktm->with(['siswa', 'master_sktm', 'user'])->findOrFail($id);
        $users          = $this->user->getAttributes();
        $users_special  = $this->user->all();
        $users_standar  = $this->user->findOrFail($user_id);
        $current_user   = Auth::User();

        if ($sktm->user !== null) {
            array_set($sktm->user, 'label', $sktm->user->name);
        }

        $role_check = Auth::User()->hasRole(['superadministrator','administrator']);

        if ($role_check) {
            $user_special = true;

            foreach ($users_special as $user) {
                array_set($user, 'label', $user->name);
            }

            $users = $users_special;
        } else {
            $user_special = false;

            array_set($users_standar, 'label', $users_standar->name);

            $users = $users_standar;
        }

        array_set($current_user, 'label', $current_user->name);

        $response['sktm']           = $sktm;
        $response['users']          = $users;
        $response['user_special']   = $user_special;
        $response['current_user']   = $current_user;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sktm  $nilai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sktm = $this->sktm->with(['siswa', 'master_sktm', 'user'])->findOrFail($id);

        $validator = Validator::make($request->all(), [
            // 'nomor_un'          => "required|exists:{$this->siswa->getTable()},nomor_un|unique:{$this->sktm->getTable()},nomor_un,{$id},id,deleted_at,NULL",
            'master_sktm_id'    => "required|exists:{$this->master_sktm->getTable()},id",
            'no_sktm'           => 'required|max:255',
            // 'nilai'             => 'required|numeric|min:0|max:100',
            'user_id'           => "required|exists:{$this->user->getTable()},id",
        ]);

        if ($validator->fails()) {
            $error      = true;
            $message    = $validator->errors()->first();
        } else {
            $sktm_master_sktm_id    = $request->input('master_sktm_id');
            $master_sktm            = $this->master_sktm->findOrFail($sktm_master_sktm_id);

            $sktm->nomor_un         = $request->input('nomor_un');
            $sktm->master_sktm_id   = $sktm_master_sktm_id;
            $sktm->no_sktm          = $request->input('no_sktm');
            $sktm->nilai            = $master_sktm->nilai;
            $sktm->user_id          = $request->input('user_id');

            $nilai = $this->nilai->updateOrCreate(
                [
                    'nomor_un'  => $sktm->nomor_un,
                ],
                [
                    'sktm'      => $sktm->nilai,
                    'total'     => null,
                    'user_id'   => $sktm->user_id,
                ]
            );

            DB::beginTransaction();

            if ($sktm->save() && $nilai->save())
            {
                DB::commit();

                $error      = false;
                $message    = 'Success';
            } else {
                DB::rollBack();

                $error      = true;
                $message    = 'Failed';
            }
        }

        $response['sktm']       = $sktm;
        $response['error']      = $error;
        $response['message']    = $message;
        $response['status']     = true;

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sktm  $nilai
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sktm = $this->sktm->findOrFail($id);

        $nilai = $this->nilai->updateOrCreate(
            [
                'nomor_un'  => $sktm->nomor_un,
            ],
            [
                'sktm'      => 0,
                'total'     => null,
                'user_id'   => $sktm->user_id,
            ]
        );

        DB::beginTransaction();

        if ($sktm->delete() && $nilai->save())
        {
            DB::commit();

            $response['message']    = 'Success';
            $response['success']    = true;
        } else {
            DB::rollBack();

            $response['message']    = 'Failed';
            $response['success']    = false;
        }

        $response['status']     = true;

        return json_encode($response);
    }

    protected function checkRole($role = array())
    {
        return Auth::user()->hasRole($role);
    }
}
