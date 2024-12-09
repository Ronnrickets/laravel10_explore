<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UsersModel;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $users;
    public function __construct(){
        $this->users = new UsersModel();
    }
    public function index(Request $req)
    {
        // return dd($req->all());
        try {
            if($req['condition'] == 'users'){
                $data = $this->users->getUsersList();
                return response()->json($data);
            }
            
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        try {
            $data = $this->users->insertUsers($req);
            return response()->json($data);
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $req, string $id)
    {
        try {
            if($id == 'createPDF'){
                $data = $this->users->createPDF($req);
                return response()->json($data);
            }
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $id)
    {
        try {
            if($id == 'editusers'){
                $data = $this->users->updateUsers($req);
                return response()->json($data);
            }else {
                $data = $this->users->deleteRestoreUsers($req->all());
                return response()->json($data);
            }
            
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
