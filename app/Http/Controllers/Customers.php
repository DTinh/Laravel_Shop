<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Social;
use Socialite;
use App\Models\Login;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Rules\Captcha; 
use App\Models\Statistic;
use Carbon\Carbon;

class Customers extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function customers(){
        $this->AuthLogin();
        $all_customers= DB::table('tbl_customers')->get(); 
        return view('admin.all_customers')->with('all_customers', $all_customers);
    }
    public function unactive_customers($customer_id){
        $this->AuthLogin();
        DB::table('tbl_customers')->where('customer_id',$customer_id)->update(['customers_status'=>1]);
        Session::put('message','Block tài khoản thành công');
        return Redirect::to('all-customers');

    }
    public function active_customers($customer_id){
        $this->AuthLogin();
        DB::table('tbl_customers')->where('customer_id',$customer_id)->update(['customers_status'=>0]);
        Session::put('message','Kích hoạt tài khoản thành công');
        return Redirect::to('all-customers');

    }
}
