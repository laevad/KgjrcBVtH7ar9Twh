<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $users = User::latest()->get();
        if ($request->ajax()){
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function (){
                    $btn= '<button type="button" class="btn btn-primary btn-sm ">Update</button>  <button type="button" class="btn btn-danger btn-sm">Delete</button>';
                    return $btn;
                })
                ->make(true);
        }
        return view('home');
    }
}
