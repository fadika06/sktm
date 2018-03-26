<?php

namespace Bantenprov\Sktm\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\Sktm\Facades\SktmFacade;

/* Models */
use Bantenprov\Sktm\Models\Bantenprov\Sktm\Sktm;
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
    protected $user;
    protected $sktm;

    public function __construct(Sktm $sktm, User $user)
    {
        $this->sktm = $sktm;
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
                    ->orWhere('kode_sktm', 'like', $value);
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
        $sktm = $this->sktm;
        $users = $this->user->all();

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }

        $response['sktm'] = $sktm;
        $response['user'] = $users;
        $response['status'] = true;

        return response()->json($sktm);
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
            'kode_sktm' => 'required',
            'nama_suket' => 'required',
            'instansi_suket' => 'required',
            'no_suket' => 'required',
            'nilai_sktm' => 'required',
        ]);

        if($validator->fails()){
            $check = $sktm->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, Username ' . $request->user_id . ' already exists';
            } else {
                $sktm->user_id = $request->input('user_id');
                $sktm->nomor_un = $request->input('nomor_un');
                $sktm->kode_sktm = $request->input('kode_sktm');
                $sktm->nama_suket = $request->input('nama_suket');
                $sktm->instansi_suket = $request->input('instansi_suket');
                $sktm->no_suket = $request->input('no_suket');
                $sktm->nilai_sktm = $request->input('nilai_sktm');
                $sktm->save();

                $response['message'] = 'success';
            }
        } else {
                $sktm->user_id = $request->input('user_id');
                $sktm->nomor_un = $request->input('nomor_un');
                $sktm->kode_sktm = $request->input('kode_sktm');
                $sktm->nama_suket = $request->input('nama_suket');
                $sktm->instansi_suket = $request->input('instansi_suket');
                $sktm->no_suket = $request->input('no_suket');
                $sktm->nilai_sktm = $request->input('nilai_sktm');
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

        $response['sktm'] = $sktm;
        $response['user'] = $sktm->user;
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

        if ($request->input('user_id') == $request->input('user_id'))
        {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|unique:sktms,user_id',
                'nomor_un' => 'required',
                'kode_sktm' => 'required',
                'nama_suket' => 'required',
                'instansi_suket' => 'required',
                'no_suket' => 'required',
                'nilai_sktm' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|unique:sktms,user_id',
                'nomor_un' => 'required',
                'kode_sktm' => 'required',
                'nama_suket' => 'required',
                'instansi_suket' => 'required',
                'no_suket' => 'required',
                'nilai_sktm' => 'required',
            ]);
        }

        if ($validator->fails()) {
            $check = $sktm->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, Username ' . $request->user_id . ' already exists';
            } else {
                $sktm->user_id = $request->input('user_id');
                $sktm->nomor_un = $request->input('nomor_un');
                $sktm->kode_sktm = $request->input('kode_sktm');
                $sktm->nama_suket = $request->input('nama_suket');
                $sktm->instansi_suket = $request->input('instansi_suket');
                $sktm->no_suket = $request->input('no_suket');
                $sktm->nilai_sktm = $request->input('nilai_sktm');
                $sktm->save();

                $response['message'] = 'success';
            }
        } else {
                $sktm->user_id = $request->input('user_id');
                $sktm->nomor_un = $request->input('nomor_un');
                $sktm->kode_sktm = $request->input('kode_sktm');
                $sktm->nama_suket = $request->input('nama_suket');
                $sktm->instansi_suket = $request->input('instansi_suket');
                $sktm->no_suket = $request->input('no_suket');
                $sktm->nilai_sktm = $request->input('nilai_sktm');
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
