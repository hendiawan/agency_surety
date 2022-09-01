<?php

namespace App\Http\ViewComposers;

use App\Sppsb;
use App\Sp3kbg;
use DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class GlobalComposer {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {  
        if(Auth::user()){ 
            if(Auth::user()->role=='AA')
               {
                $sppsb = Sppsb::where('user_id',Auth::user()->id)->count();
                $sppsb2 = DB::table('sppsb')->where('user_id',Auth::user()->id)->whereIn('status',['B','P'])->count();
                $sppsb3 = DB::table('sppsb')->where([['user_id','=',Auth::user()->id],['status','=','T']])->count();
                $sppsb4 = DB::table('sppsb')->where('user_id',Auth::user()->id)->whereIn('status',['S','C'])->count();

                $sp3kbg = Sp3kbg::where('user_id',Auth::user()->id)->count();
                $sp3kbg2 = DB::table('sp3kbg')->where('user_id',Auth::user()->id)->whereIn('status',['B','P'])->count();
                $sp3kbg3 = DB::table('sp3kbg')->where([['user_id','=',Auth::user()->id],['status','=','T']])->count();
                $sp3kbg4 = DB::table('sp3kbg')->where('user_id',Auth::user()->id)->whereIn('status',['S','C'])->count();

                $pemohon = $sppsb+$sp3kbg; 
                $proses = $sppsb2+$sp3kbg2;
                $tolak = $sppsb3+$sp3kbg3;
                $setuju = $sppsb4+$sp3kbg4; 

            }
            else
                {
                $sppsb = Sppsb::all()->count();
                $sppsb2 = DB::table('sppsb')->whereIn('status',['B','P','D'])->count();
                $sppsb3 = DB::table('sppsb')->where('status','T')->count();
                $sppsb4 = DB::table('sppsb')->whereIn('status',['C'])->count();

                $sp3kbg = Sp3kbg::all()->count();
                $sp3kbg2 = DB::table('sp3kbg')->whereIn('status',['B','P','D'])->count();
                $sp3kbg3 = DB::table('sp3kbg')->where('status','T')->count();
                $sp3kbg4 = DB::table('sp3kbg')->whereIn('status',['C'])->count();

                $pemohon = $sppsb; 
                $proses = $sppsb2+$sp3kbg2;
                $tolak = $sppsb3+$sp3kbg3;
                $setuju = $sppsb4+$sp3kbg4; 
            }
            $view->with('pemohon', $pemohon);
            $view->with('proses', $proses);
            $view->with('tolak', $tolak);
            $view->with('setuju', $setuju);
        }
    }

}