<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDF;

class UsersModel extends Model
{
    public function getUsersList(){
        $data = DB::connection('mysql')
        ->table('m_users')
        ->select('EmployeeCode', 'Password', 'UserName',
            DB::raw('CASE WHEN DeletedDate IS NULL THEN 1 ELSE 0 END AS Status'))
        ->orderBy('CreatedDate', 'DESC')
        ->get();
        // return dd($data);
            return $data->toArray(); 
    }

    public function insertUsers($req){
        DB::connection('mysql')
        ->table('m_users')
        ->insert([
            'EmployeeCode' => $req['employeeCode'],
            'Password' => $req['password'],
            'UserName' => $req['username'],
            'Email' => $req['email'],
            'CreatedDate' => date('Y-m-d H:i:s'),
            'UpdatedDate' => date('Y-m-d H:i:s'),
            'UpdatedBy' => 'rickkk',
        ]);
        return $this->getUsersList();
    }

    public function updateUsers($req){
        DB::connection('mysql')
        ->table('m_users')
        ->where('EmployeeCode', $req['employeeCode'])
        ->update([
            'Password' => $req['password'],
            'UserName' => $req['username'],
            'Email' => $req['email'],
            'UpdatedDate' => date('Y-m-d H:i:s'),
            'UpdatedBy' => 'rickkkss',
        ]);
        return $this->getUsersList();
    }

    public function deleteRestoreUsers($req){
        DB::connection('mysql')
        ->table('m_users')
        ->where('EmployeeCode', $req['employeeCode'])
        ->update([
            'DeletedDate' => $req['Status'] == 1 ? date('Y-m-d H:i:s') : null,
            'UpdatedDate' => date('Y-m-d H:i:s'),
            'UpdatedBy' => 'rickkkss',
        ]);
        return $this->getUsersList();
    }

    public function createPDF(){
        $data = $this->getUsersList();
        // $data1 = array_map(function($user) {
        //     return (object)[
        //         "EmployeeCode" => mb_convert_encoding($user->EmployeeCode, 'UTF-8'),
        //         "Password" => mb_convert_encoding($user->Password, 'UTF-8'),
        //         "UserName" => mb_convert_encoding($user->UserName, 'UTF-8'),
        //         "Email" => mb_convert_encoding($user->Email, 'UTF-8'),
        //         "Status" => $user->Status, // Status is an integer, no need to convert
        //     ];
        // }, $data);
        // return dd($data);
        $pdf = PDF::loadView('pdf.print_pdf',compact('data'))->setPaper("A4", "landscape");
        return $pdf->stream('Sample.pdf');
    }
}
