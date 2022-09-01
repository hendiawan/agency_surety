<?php

namespace App\Http\Controllers;

use App\Bank;
use DB;
use Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class BankController extends Controller
{
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        return view('admin.bank');
    }
    
    public function getDataBank()
    {
    	$bank = Bank::all();
        return Datatables::of($bank)
        	->addColumn('action', function ($bank) {
                return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                            <a href="edit-bank/'.$bank->id.'" class="icon-button icon-color-blue">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="detail-bank/'.$bank->id.'" class="icon-button icon-color-grey">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>';
            })
            ->make(true);
    }

    public function addBank()
    {
        return view('admin.tambahbank');
    }

    public function insertBank(Request $request)
    {
    	$this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'wilayah' => 'required',
            'no_rek' => 'required|numeric',
            'rate' => 'required|numeric',
        ]);

        $data = $request->all();
        $bank = Bank::create([
        	'name'		=> $data['name'],
        	'address'	=> $data['address'],
        	'wilayah'	=> $data['wilayah'],
        	'phone'		=> $data['phone'],
        	'no_rek'	=> $data['no_rek'],
        	'rate'		=> $data['rate']
        ]);

        
        Session::flash('msgupdate','Data Bank '.$data['name'].' berhasil di tambahkan');
        return redirect('/bank');
    }

    public function editBank($id)
    {
    	$bank = Bank::findOrFail($id);
        return view('admin.editbank', compact('bank'));
    }

    public function updateBank(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'wilayah' => 'required',
            'no_rek' => 'required|numeric',
            'rate' => 'required|numeric',
        ]);

        $data = $request->all();
        $bank = Bank::findOrFail($data['id']);
        $bank->name     = $data['name'];
        $bank->address  = $data['address'];
        $bank->wilayah  = $data['wilayah'];
        $bank->phone    = $data['phone'];
        $bank->no_rek   = $data['no_rek'];
        $bank->rate     = $data['rate'];
        $bank->save();

        Session::flash('msgupdate','Data Bank '.$data['name'].' berhasil di update');
        return redirect('/bank');
    }

}
