<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Socialite;
use App\Customer;
use App\SocialCustomers;
use App\Product;
use App\Login;
use App\Comment;
use App\Coupon;
use App\Social;
use App\Statistic;
use App\Order;
use App\Admin;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    public function login_facebook_customer(){
        return Socialite::driver('facebook')->redirect();
    }
    public function callback_facebook_customer(){
        $provider = Socialite::driver('facebook')->user();

        $account = SocialCustomers::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();

        if($account!=NULL){

           $account_name = Customer::where('customer_id',$account->user)->first();
           Session::put('customer_id',$account_name->customer_id);
           Session::put('customer_name',$account_name->customer_name);

           return Redirect::to('/checkout');

       }elseif($account==NULL){
           $customer_login = new SocialCustomers([
            'provider_user_id' => $provider->getId(),
            'provider_user_email' => $provider->getEmail(),
            'provider' => 'facebook'
            ]);

           $customer = Customer::where('customer_email',$provider->getEmail())->first();

           if(!$customer){
            $customer = Customer::create([
                'customer_name' => $provider->getName(),
                'customer_email' => $provider->getEmail(),
                'customer_picture' => '',
                'customer_password' => '',
                'customer_phone' => ''
            ]);
        }
            $customer_login->customer()->associate($customer);
            $customer_login->save();

            $account_new = Customer::where('customer_id',$customer_login->user)->first();
            Session::put('customer_id',$account_new->customer_id);
            Session::put('customer_name',$account_new->customer_name);


            return Redirect::to('/checkout');      
        }

    }

    public function login_customer_google(){
        return Socialite::driver('google')->redirect();
    }


    public function callback_customer_google(){

        $users = Socialite::driver('google')->stateless()->user(); 

        $authUser = $this->findOrCreateCustomer($users, 'google');

        if($authUser){
            $account_name = Customer::where('customer_id',$authUser->user)->first();
            Session::put('customer_id',$account_name->customer_id);
            Session::put('customer_picture',$account_name->customer_picture);
            Session::put('customer_name',$account_name->customer_name);

        }elseif($customer_new){
            $account_name = Customer::where('customer_id',$authUser->user)->first();
            Session::put('customer_id',$account_name->customer_id);
            Session::put('customer_picture',$account_name->customer_picture);
            Session::put('customer_name',$account_name->customer_name);
        }

        return Redirect::to('/checkout');
    }

    public function findOrCreateCustomer($users, $provider){
        $authUser = SocialCustomers::where('provider_user_id', $users->id)->first();
        if($authUser){
            return $authUser;
        }else{
            $customer_new = new SocialCustomers([
                'provider_user_id' => $users->id,
                'provider_user_email' => $users->email,
                'provider' => strtoupper($provider)
            ]);

            $customer = Customer::where('customer_email',$users->email)->first();

            if(!$customer){

                $customer = Customer::create([
                    'customer_name' => $users->name,
                    'customer_picture' => $users->avatar,
                    'customer_email' => $users->email,
                    'customer_password' => '',
                    'customer_phone' => '',
                    'customer_address' => ''
                ]);
            }

            $customer_new->customer()->associate($customer);

            $customer_new->save();
            return $customer_new;
        }           

    }
    

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function index(){
    	return view('admin_login');
    }

    public function show_dashboard(){
        $this->AuthLogin();
        $product      = Product::all()->count();
        $coupon       = Coupon::all()->count();
        $order        = Order::all()->count();
        $customer     = Customer::all()->count();
        $comment      = Comment::where('comment_parent_comment','=',0)->count();
        $productview  = Product::where('product_status','1')->orderby('tbl_product.product_views','desc')->take(10)->get();
        $best_sellers = Product::where('product_status','1')->where('product_sold','>','0')->orderby('product_sold','DESC')->get(); 
        $sumsales     = Statistic::sum('sales');
        $sumprofits   = Statistic::sum('profit');
        $sumquantity  = Statistic::sum('quantity');
        $sumorder     = Statistic::sum('total_order');
    	return view('admin.dashboard')->with(compact('product','order','customer','comment','coupon','productview','best_sellers','sumsales','sumprofits','sumquantity','sumorder'));
    }

    public function dashboard(Request $request){
    	$admin_email = $request->admin_email;
    	$admin_password = md5($request->admin_password);

    	$result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
    	if($result){
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            Session::put('admin_role',$result->admin_role);
            return Redirect::to('/dashboard');
        }else{
            Session::put('message','Wrong password or account! Please re-enter');
            return Redirect::to('/admin');
        }

    }

    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_role',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }


    public function days_order(){

        // $sub60days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(60)->toDateString();
        $sub60days = Statistic::min('order_date');

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        $get = Statistic::whereBetween('order_date',[$sub60days,$now])->orderBy('order_date','ASC')->get();


        foreach($get as $key => $val){

           $chart_data[] = array(
            'period' => $val->order_date,
            'order' => $val->total_order,
            'sales' => $val->sales,
            'profit' => $val->profit,
            'quantity' => $val->quantity
        );

       }

       echo $data = json_encode($chart_data);
    }

    public function dashboard_filter(Request $request){

        $data = $request->all();

            // $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
           // $tomorrow = Carbon::now('Asia/Ho_Chi_Minh')->addDay()->format('d-m-Y H:i:s');
           // $lastWeek = Carbon::now('Asia/Ho_Chi_Minh')->subWeek()->format('d-m-Y H:i:s');
           // $sub15days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(15)->format('d-m-Y H:i:s');
           // $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->format('d-m-Y H:i:s');

        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();

        $dauthang9 = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(2)->startOfMonth()->toDateString();
        $cuoithang9 = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(2)->endOfMonth()->toDateString();


        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if($data['dashboard_value']=='7ngay'){

            $get = Statistic::whereBetween('order_date',[$sub7days,$now])->orderBy('order_date','ASC')->get();

        }elseif($data['dashboard_value']=='thangtruoc'){

            $get = Statistic::whereBetween('order_date',[$dau_thangtruoc,$cuoi_thangtruoc])->orderBy('order_date','ASC')->get();

        }elseif($data['dashboard_value']=='thangnay'){

            $get = Statistic::whereBetween('order_date',[$dauthangnay,$now])->orderBy('order_date','ASC')->get();

        }elseif ($data['dashboard_value']=='thang9') {

            $get = Statistic::whereBetween('order_date',[$dauthang9,$cuoithang9])->orderBy('order_date','ASC')->get();

        }else{
            $get = Statistic::whereBetween('order_date',[$sub365days,$now])->orderBy('order_date','ASC')->get();
        }


        foreach($get as $key => $val){

            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }

        echo $data = json_encode($chart_data);

    }
    public function filter_by_date(Request $request){

        $data = $request->all();

        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $get = Statistic::whereBetween('order_date',[$from_date,$to_date])->orderBy('order_date','ASC')->get();


        foreach($get as $key => $val){

            $chart_data[] = array(

                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }

        echo $data = json_encode($chart_data);  

    }

    public function order_date(Request $request){
        $order_date = $_GET['date'];
        $order = Order::where('order_date',$order_date)->orderby('created_at','DESC')->get();
        return view('admin.order_date')->with(compact('order'));
    }

    public function add_staff(){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            return view('admin.staff.add_staff');
        }else{
            return view('errors.404');
        }
    }

    public function save_staff(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d h:i:s');
        $checkaccount = Admin::where('admin_email',$data['admin_email'])->first();
        if($checkaccount){
            Session::put('messageaddstaff','Account already exists');
            return redirect()->back();
        }else{
            $staff = new Admin();
            $staff->admin_name     = $data['admin_name'];
            $staff->admin_email    = $data['admin_email'];
            $staff->admin_password = md5($data['admin_password']);
            $staff->admin_phone    = $data['admin_phone'];
            $staff->admin_role     = $data['admin_role'];
            $staff->created_at     = $today;
            $staff->save();
            Session::put('messageaddstaff','Add staff successfully');
            return redirect()->back();
        }
    }

    public function list_staff(Request $request){
        $this->AuthLogin();
        $all_staff = Admin::orderBy('admin_id','DESC')->paginate(6);
        $manager_all_staff  = view('admin.staff.lish_staff')->with('all_staff',$all_staff);
        return view('admin_layout')->with('admin.staff.lish_staff', $manager_all_staff);
    }

    public function edit_staff($admin_id){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            $staff = Admin::find($admin_id);
            return view('admin.staff.edit_staff')->with('edit_staff',$staff);
        }else{
            return view('errors.404');
        }
    }

    public function update_staff(Request $request,$admin_id){
        $this->AuthLogin();
        $data = $request->all();
        $checkaccount = Admin::where('admin_id',$admin_id)->where('admin_password',md5($data['admin_password']))->first();
        if($checkaccount){
            Session::put('messageeditstaff','The new password cannot be the same as the old password');
            return redirect()->back();
        }else{
            $staff = Admin::find($admin_id);
            $staff->admin_name     = $data['admin_name'];
            $staff->admin_password = md5($data['admin_password']);
            $staff->admin_phone    = $data['admin_phone'];
            $staff->admin_role     = $data['admin_role'];
            $staff->save();
            Session::put('messageeditstaff','Edit staff successfully');
            return redirect()->back();
        }
    }

    public function delete_staff($admin_id){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            Admin::where('admin_id',$admin_id)->delete();
            Session::put('messagedeletestaff','Delete staff successfully');
            return redirect()->back();
        }else{
            return view('errors.404');
        }
    }
}
