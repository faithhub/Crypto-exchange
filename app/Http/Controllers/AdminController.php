<?php

namespace App\Http\Controllers;

use App\Admin;
use App\BuyMoney;
use App\ExchangeMoney;
use App\Provider;
use App\SellMoney;
use App\Message;
use App\Trx;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\GeneralSettings;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use File;
use Image;

class AdminController extends Controller
{
    public function __construct()
    {
        $Gset = GeneralSettings::first();
        $this->sitename = $Gset->sitename;
        $this->middleware('auth:admin');
    }

    public function exchangeLog()
    {
        $data['exchange'] = ExchangeMoney::where('status', '!=', 0)->latest()->get();
        $data['page_title'] = 'Manage Exchange Log';
        return view('admin.currency.exchange-list', $data);
    }

    public function exchangeInfo($id)
    {
        $get = ExchangeMoney::where('id', $id)->where('status', '!=', 0)->first();
        if ($get) {
            $data['exchange'] = $get;
            $data['page_title'] = ' Exchange Log Details';
            return view('admin.currency.exchange-info', $data);
        }
        abort(404);
    }

    public function exchangeapprove($id)
    {
        $data = ExchangeMoney::find($id);
        $data->status = 2;
        $data->save();


        Message::create([
            'user_id' => $data->user_id,
            'title' => 'Exchange Approved',
            'details' => 'Your cryptocurrency exchange with transaction number ' . $data->transaction_number . ' was approved. Your fund has been credited into your wallet as requested',
            'admin' => 1,
            'status' =>  0
        ]);



        $notification =  array('message' => 'Exchange Approved Successfully !!', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function exchangereject($id)
    {
        $data = ExchangeMoney::find($id);
        $data->status = -2;
        $data->save();


        Message::create([
            'user_id' => $data->user_id,
            'title' => 'Exchange Rejected',
            'details' => 'Your cryptocurrency exchange was with transaction number ' . $data->transaction_number . ' rejected. Please send us a message to facilitate a refund if your money is not refunded in 24hours',
            'admin' => 1,
            'status' =>  0
        ]);



        $notification =  array('message' => 'Exhange Rejected Successfully !!', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function buyLog()
    {
        $data['exchange'] = Trx::whereStatus(2)->whereType(1)->latest()->get();
        $data['page_title'] = 'Processed Buy Log';
        return view('admin.currency.buy-list', $data);
    }
    public function pendingbuyLog()
    {
        $data['exchange'] = Trx::whereStatus(1)->whereType(1)->latest()->get();
        $data['page_title'] = 'Pending Buy Log';
        return view('admin.currency.buy-list', $data);
    }
    public function declinedbuyLog()
    {
        $data['exchange'] = Trx::whereStatus(-2)->whereType(1)->latest()->get();
        $data['page_title'] = 'Declined Buy Log';
        return view('admin.currency.buy-list', $data);
    }
    public function buyInfo($id)
    {
        $get = Trx::where('id', $id)->where('status', '!=', 0)->first();
        if ($get) {
            $data['exchange'] = $get;
            $data['page_title'] = ' Buy Log Details';
            return view('admin.currency.buy-info', $data);
        }
        abort(404);
    }

    public function buyapprove($id)
    {
        $data = Trx::find($id);
        $basic = GeneralSettings::first();
        $data->status = 2;

        $data->save();
        Message::create([
            'user_id' => $data->user_id,
            'title' => 'Coin Purchase Approved',
            'details' => 'Your cryptocurrency purchase with transaction number ' . $data->trx . '  was approved. Your account has been credited as required, Thank you for choosing ' . $basic->sitename . '',
            'admin' => 1,
            'status' =>  0
        ]);



        $notification =  array('message' => 'Approved Successfully !!', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function buyreject(Request $request)
    {

        $data = Trx::find($request->id);
        $basic = GeneralSettings::first();
        $user = User::findOrFail($data->user_id);



        Message::create([
            'user_id' => $data->user_id,
            'title' => 'Purchase Rejected',
            'details' => 'Your cryptocurrency purchase with transaction number ' . $data->trx . ' was rejected. Please send us a message for complaints or clarifications on purchase rejection',
            'admin' => 1,
            'status' =>  0
        ]);

        $msg =  ' Buy Declined ' . $data->main_amo . ' ' . $basic->currency;
        send_email($user->email, $user->username, 'Buy Amount return ', $msg);

        $data->status = -2;

        $data->save();

        $notification =  array('message' => 'Cryptocurrency Purchase Was Rejected Successfully !!', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function sellLog()
    {
        $data['exchange'] = Trx::whereStatus(2)->whereType(0)->latest()->get();
        $data['page_title'] = 'Processed Sell Log';
        return view('admin.currency.sell-list', $data);
    }
    public function pendingsellLog()
    {
        $data['exchange'] = Trx::whereStatus(1)->whereType(0)->latest()->get();
        $data['page_title'] = 'Pending Sell Log';
        return view('admin.currency.sell-list', $data);
    }
    public function declinedsellLog()
    {
        $data['exchange'] = Trx::whereStatus(-2)->whereType(0)->latest()->get();
        $data['page_title'] = 'Declined Sell Log';
        return view('admin.currency.sell-list', $data);
    }
    public function sellInfo($id)
    {
        $get = Trx::where('id', $id)->where('status', '!=', 0)->first();
        if ($get) {
            $data['exchange'] = $get;
            $data['page_title'] = ' Sell Log Details';
            return view('admin.currency.sell-info', $data);
        }
        abort(404);
    }

    public function sellapprove($id)
    {

        $data = Trx::find($id);
        $basic = GeneralSettings::first();
        $data->status = 2;
        if ($data->payout == 1) {

            $user = User::find($data->user_id);
            $user->balance += $data->get_amount;
            $user->save();
        }
        $user = User::find($data->user_id);

        Message::create([
            'user_id' => $data->user_id,
            'title' => 'Sales Approved',
            'details' => 'Your cryptocurrency sales with transaction number ' . $data->trx . ' has been approved. You fund has been credited to your account as required. Thank you for choosing us',
            'admin' => 1,
            'status' =>  0
        ]);


        $msg =  ' Sell Amount  ' . $data->get_amount . ' ' . $basic->currency;
        //send_email($user->email, $user->username, 'Sell Amount  ', $msg);

        $data->save();

        $notification =  array('message' => 'Sales Approved Successfully !!', 'alert-type' => 'success');
        return back()->with($notification);
    }


    public function sellreject($id)
    {

        $data = Trx::find($id);
        $basic = GeneralSettings::first();

        Message::create([
            'user_id' => $data->user_id,
            'title' => 'Sale Rejected',
            'details' => 'Your cryptocurrency sales was rejected. Please send us a message to facilitate a refund if your money is not refunded in 24hours',
            'admin' => 1,
            'status' =>  0
        ]);

        $data->status = -2;
        $data->save();

        $notification =  array('message' => 'Rejected Successfully !!', 'alert-type' => 'success');
        return back()->with($notification);
    }



    public function socialLogin()
    {
        $data['page_title'] = 'Manage Social Login';
        $data['providers'] = Provider::all();
        return view('admin.social-login.index', $data);
    }

    public function socialLoginUpd(Request $request)
    {
        $data =  Provider::find($request->id);
        $data->client_id =  $request->name;
        $data->client_secret =  $request->account;
        $data->save();

        $notification =  array('message' => 'Updated Successfully !!', 'alert-type' => 'success');
        return back()->with($notification);
    }


    public function dashboard()
    {
        $data['page_title'] = 'DashBoard';
        return view('admin.dashboard', $data);
    }


    public function changePassword()
    {
        $data['page_title'] = "Change Password";
        return view('admin.change_password', $data);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'password_confirmation' => 'required|same:new_password',
        ]);

        $user = Auth::guard('admin')->user();

        $oldPassword = $request->old_password;
        $password = $request->new_password;
        $passwordConf = $request->password_confirmation;

        if (!Hash::check($oldPassword, $user->password) || $password != $passwordConf) {
            $notification =  array('message' => 'Password Do not match !!', 'alert-type' => 'error');
            return back()->with($notification);
        } elseif (Hash::check($oldPassword, $user->password) && $password == $passwordConf) {
            $user->password = bcrypt($password);
            $user->save();
            $notification =  array('message' => 'Password Changed Successfully !!', 'alert-type' => 'success');
            return back()->with($notification);
        }
    }


    public function profile()
    {
        $data['admin'] = Auth::user();
        $data['page_title'] = "Profile Settings";
        return view('admin.profile', $data);
    }

    public function updateProfile(Request $request)
    {
        $data = Admin::find($request->id);
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|max:50|unique:admins,email,' . $data->id,
            'mobile' => 'required',
        ]);

        $in = Input::except('_method', '_token');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'admin_' . time() . '.jpg';
            $location = 'assets/admin/img/' . $filename;
            Image::make($image)->resize(300, 300)->save($location);
            $path = './assets/admin/img/';
            File::delete($path . $data->image);
            $in['image'] = $filename;
        }
        $data->fill($in)->save();

        $notification =  array('message' => 'Admin Profile Update Successfully', 'alert-type' => 'success');
        return back()->with($notification);
    }





    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->flash('message', 'Just Logged Out!');
        return redirect('/admin');
    }
}
