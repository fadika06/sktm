<?php

namespace Bantenprov\Sktm\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\Sktm\Facades\SktmFacade;

/* Models */
use Bantenprov\Sktm\Models\Bantenprov\Sktm\Sktm;
use Bantenprov\Sktm\Models\Bantenprov\Sktm\MasterSktm;
use Bantenprov\Siswa\Models\Bantenprov\Siswa\Siswa;
use Bantenprov\Nilai\Models\Bantenprov\Nilai\Nilai;
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
    protected $siswa;
    protected $nilai;
    protected $master_sktm;
    protected $user;

    public function __construct(Sktm $sktm, MasterSktm $master_sktm, User $user, Siswa $siswa, Nilai $nilai)
    {
        $this->sktm = $sktm;
        $this->siswa = $siswa;
        $this->master_sktm = $master_sktm;
        $this->user = $user;
        $this->nilai = $nilai;
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
                $q->where('id', 'like', $value)
                    ->orWhere('nilai', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->with('user')->with('master_sktm')->with('siswa')->paginate($perPage);

        /*foreach($response as $master_sktm){
            array_set($response->data, 'master_sktm', $master_sktm->master_sktm->nama);
        }

        foreach($response as $user){
            array_set($response->data, 'user', $user->user->name);
        }*/

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
        $siswas = $this->siswa->all();

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }

        foreach($master_sktms as $master_sktm){
            array_set($master_sktm, 'label', $master_sktm->instansi);
        }

        foreach($siswas as $siswa){
            array_set($siswa, 'label', $siswa->nama_siswa);
        }
        
        $response['master_sktm'] = $master_sktms;
        $response['siswa'] = $siswas;
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
        $nilai_sktm = $request->nilai_sktm;

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|unique:sktms,user_id',
            'nomor_un' => 'required|unique:sktms,nomor_un',
            'master_sktm_id' => 'required|unique:sktms,master_sktm_id',
            'no_sktm' => 'required',
            'nilai_sktm' => 'required',
        ]);

        if($validator->fails()){
            $check = $sktm->where('user_id', $request->user_id)->orWhere('master_sktm_id',$request->master_sktm_id)->orWhere('nomor_un',$request->nomor_un)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed ! Username, Nama Siswa, Master SKTM, already exists';
            } else {
                $sktm->user_id = $request->input('user_id');
                $sktm->nomor_un = $request->input('nomor_un');
                $sktm->master_sktm_id = $request->input('master_sktm_id');
                $sktm->no_sktm = $request->input('no_sktm');
                $sktm->nilai = $request->input('nilai_sktm');
                $sktm->save();

                $check_sktm = $this->nilai->where('siswa_id', $request->input('siswa_id'));
                if($check_sktm->count() > 0){
                    $this->nilai->where('siswa_id', $request->input('siswa_id'))->update([
                        'user_id' => $request->input('user_id'),
                        'siswa_id' => $request->input('siswa_id'),
                        'sktm' => $nilai_sktm
                    ]);
                }else{
                    $this->nilai->create([
                        'user_id' => $request->input('user_id'),
                        'siswa_id' => $request->input('siswa_id'),
                        'sktm' => $nilai_sktm
                    ]);
                }

                $response['message'] = 'success';
            }
        } else {
                $sktm->user_id = $request->input('user_id');
                $sktm->nomor_un = $request->input('nomor_un');
                $sktm->master_sktm_id = $request->input('master_sktm_id');
                $sktm->no_sktm = $request->input('no_sktm');
                $sktm->nilai = $request->input('nilai_sktm');
                $sktm->save();

                $check_sktm = $this->nilai->where('siswa_id', $request->input('siswa_id'));
                if($check_sktm->count() > 0){
                    $this->nilai->where('siswa_id', $request->input('siswa_id'))->update([
                        'user_id' => $request->input('user_id'),
                        'siswa_id' => $request->input('siswa_id'),
                        'sktm' => $nilai_sktm
                    ]);
                }else{
                    $this->nilai->create([
                        'user_id' => $request->input('user_id'),
                        'siswa_id' => $request->input('siswa_id'),
                        'sktm' => $nilai_sktm
                    ]);
                }

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
        $response['siswa'] = $sktm->siswa;
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
        array_set($sktm->master_sktm, 'label', $sktm->master_sktm->instansi);
        array_set($sktm->siswa, 'label', $sktm->siswa->nama_siswa);
        
        $response['master_sktm'] = $sktm->master_sktm;
        $response['sktm'] = $sktm;
        $response['siswa'] = $sktm->siswa;
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
        $response = array();
        $message  = array();
        
        $sktm = $this->sktm->findOrFail($id);
        $nilai_sktm = $request->nilai_sktm;

        /*if ($request->input('master_sktm_id') == $request->input('master_sktm_id'))
        {*/
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|unique:sktms,user_id,'.$id,
                'nomor_un' => 'required|unique:sktms,nomor_un,'.$id,
                'master_sktm_id' => 'required',
                'no_sktm' => 'required',
                'nilai_sktm' => 'required',
                
            ]);

        if ($validator->fails()) {

            foreach($validator->messages()->getMessages() as $key => $error){
                        foreach($error AS $error_get) {
                            array_push($message, $error_get);
                        }                
                    } 

             $check_user     = $this->sktm->where('id','!=', $id)->where('user_id', $request->user_id);
             $check_siswa = $this->sktm->where('id','!=', $id)->where('nomor_un', $request->nomor_un);

             if($check_user->count() > 0 || $check_siswa->count() > 0){
                  $response['message'] = implode("\n",$message);

            } else {
                $sktm->user_id = $request->input('user_id');
                $sktm->nomor_un = $request->input('nomor_un');
                $sktm->master_sktm_id = $request->input('master_sktm_id');
                $sktm->no_sktm = $request->input('no_sktm');
                $sktm->nilai = $request->input('nilai_sktm');
                $sktm->save();

                $check_sktm = $this->nilai->where('siswa_id', $request->input('siswa_id'));
                if($check_sktm->count() > 0){
                    $this->nilai->where('siswa_id', $request->input('siswa_id'))->update([
                        'user_id' => $request->input('user_id'),
                        'siswa_id' => $request->input('siswa_id'),
                        'sktm' => $nilai_sktm
                    ]);
                }

                $response['message'] = 'success';
            }
        } else {
                $sktm->user_id = $request->input('user_id');
                $sktm->nomor_un = $request->input('nomor_un');
                $sktm->master_sktm_id = $request->input('master_sktm_id');
                $sktm->no_sktm = $request->input('no_sktm');
                $sktm->nilai = $request->input('nilai_sktm');
                $sktm->save();

                $check_sktm = $this->nilai->where('siswa_id', $request->input('siswa_id'));
                if($check_sktm->count() > 0){
                    $this->nilai->where('siswa_id', $request->input('siswa_id'))->update([
                        'user_id' => $request->input('user_id'),
                        'siswa_id' => $request->input('siswa_id'),
                        'sktm' => $nilai_sktm
                    ]);
                }

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
