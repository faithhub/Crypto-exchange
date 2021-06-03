@extends('include.userdashboard')
@section('content')
<div class="page-content">
        <div class="container">

                @php
                $ip = \App\UserLogin::whereUser_id(Auth::user()->id)->latest()->take(1)->first();
                $ncount = \App\Message::whereUser_id(Auth::user()->id)->whereAdmin(1)->whereStatus(0)->count();

                $ipcount = \App\UserLogin::whereUser_id(Auth::user()->id)->count();
                @endphp
                @if($ncount > 0)
                <div class="alert alert-info alert-dismissible fade show">Hello {{Auth::User()->username}}!, You have {{$ncount}} unread message(s). Please <a href="{{route('inbox')}}">Click Here</a> to open your inbox<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                @endif


                <div class="row">
                        <div class="col-lg-4">
                                <div class="token-statistics bg-secondary card card-token height-auto">
                                        <div class="card-innr">
                                                <div class="token-balance token-balance-with-iconx">
                                                        <div class="token-balance-icon"><em class="h2 color-white ti ti-user"></em></div>
                                                        <div class="token-balance-text">
                                                                <h6 class="card-sub-title">Account Details</h6><span class="lead">{{Auth::user()->username}} <span>
                                                                                <marquee>Current Location:
                                                                                        @if($ipcount > 0)
                                                                                        {{$ip->location}}
                                                                                        @else
                                                                                        Unknown
                                                                                        @endif
                                                                                </marquee>
                                                                        </span><span></span></span>
                                                        </div>
                                                </div>
                                                <div class="token-balance token-balance-s2">
                                                        <h6 class="card-sub-title">Summary</h6>
                                                        <ul class="token-balance-list">
                                                                <li class="token-balance-sub"><span class="leasd">{{ Carbon\Carbon::parse(Auth::User()->created_at)->diffForHumans() }}</span><span class="sub">Date Joined</span></li>
                                                                <li class="token-balance-sub"><span class="leasd">@if(Auth::user()->verified !=2) Unverified @elseif(Auth::user()->verified == 2)Verified @endif</span><span class="sub">Account Status</span></li>

                                                                <li class="token-balance-sub"><span class="leasd">
                                                                                @if($ipcount > 0)
                                                                                {{$ip->user_ip}}
                                                                                @else
                                                                                1:
                                                                                @endif
                                                                        </span><span class="sub">Login IP</span></li>
                                                        </ul>
                                                </div>
                                        </div>
                                </div>
                        </div><!-- .col -->
                        <div class="col-lg-8">
                                <div class="token-statistics bg-primary  card card-token height-auto">
                                        <div class="card-innr" style="min-height: 261px;">
                                                <div class="row mb-4">
                                                        <div class="col-12">
                                                                <div class="token-balance token-balance-with-icon mb-3">
                                                                        <div class="token-balance-icon"><em class="h2 color-white fa fa-money-bill"></em></div>
                                                                        <div class="token-balance-text">
                                                                                <h6 class="card-sub-title">Naira Wallet Balance</h6><span class="lead"> {{$basic->currency_sym}}{{number_format($buy - $bacharge, $basic->decimal)}}</span>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>

                                                <div class="token-balance token-balance-s2">
                                                        <div class="row">
                                                                @foreach($currency as $data)
                                                                <div class="col-3">
                                                                        <!-- {{$data}} -->
                                                                        <h6 class="card-sub-title">{{$data->name}} Balance</h6>
                                                                        <ul class="token-balance-list">
                                                                                <li class="token-balance-sub">
                                                                                        <span class="lead">
                                                                                                <em class="pay-icon cf cf-@if($data->icon =='paypal')pivx @else{{$data->icon}}@endif"></em>
                                                                                                {{number_format($bpend - $bcharge, $basic->decimal)}}
                                                                                        </span>
                                                                                </li>
                                                                                <!-- <li class="token-balance-sub"><span class="lead">{{$basic->currency_sym}}{{number_format($bdecline - $bdeccharge, $basic->decimal)}}</span><span class="sub">Declined</span></li> -->
                                                                        </ul>
                                                                </div>
                                                                @endforeach
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div><!-- .col -->
                </div>
                <div class="row">
                        <div class="col-lg-6">
                                <div class="token-statistics  card card-token height-auto">
                                        <div class="card-innr">
                                                <div class="token-balance token-balance-with-icon">
                                                        <div class="token-balance-icon"><em class="h2 color-white ti ti-shopping-cart"></em></div>
                                                        <div class="token-balance-text">
                                                                <h6 class="card-sub-title">Total Crypto Purchase</h6><span class="lead"> {{$basic->currency_sym}}{{number_format($buy - $bacharge, $basic->decimal)}}</span>
                                                        </div>
                                                </div>
                                                <div class="token-balance token-balance-s2">
                                                        <h6 class="card-sub-title">Your Purchase</h6>
                                                        <ul class="token-balance-list">
                                                                <li class="token-balance-sub"><span class="lead">{{$basic->currency_sym}}{{number_format($bpend - $bcharge, $basic->decimal)}}</span><span class="sub">Pending</span></li>
                                                                <li class="token-balance-sub"><span class="lead">{{$basic->currency_sym}}{{number_format($bdecline - $bdeccharge, $basic->decimal)}}</span><span class="sub">Declined</span></li>
                                                        </ul>
                                                </div>
                                        </div>
                                </div>
                        </div><!-- .col -->
                        <div class="col-lg-6">
                                <div class="token-statistics bg-primary card card-token height-auto">
                                        <div class="card-innr">
                                                <div class="token-balance token-balance-with-icon">
                                                        <div class="token-balance-icon"><em class="h2 color-white ti ti-share"></em></div>
                                                        <div class="token-balance-text">
                                                                <h6 class="card-sub-title">Total Crypto Sales</h6><span class="lead"> {{$basic->currency_sym}}{{number_format($sell, $basic->decimal)}}</span>
                                                        </div>
                                                </div>
                                                <div class="token-balance token-balance-s2">
                                                        <h6 class="card-sub-title">Your Sales</h6>
                                                        <ul class="token-balance-list">
                                                                <li class="token-balance-sub"><span class="lead">{{$basic->currency_sym}}{{number_format($spend, $basic->decimal)}}</span><span class="sub">Pending</span></li>
                                                                <li class="token-balance-sub"><span class="lead">{{$basic->currency_sym}}{{number_format($sdecline, $basic->decimal)}}</span><span class="sub">Declined</span></li>
                                                        </ul>
                                                </div>
                                        </div>
                                </div>
                        </div><!-- .col -->







                        <div class="col-xl-8 col-lg-7">
                                <div class="token-transaction card card-full-height">
                                        <div class="card-innr">
                                                <div class="card-head has-aside">
                                                        <h4 class="card-title">Recent Transactions</h4>
                                                        <div class="card-opt"><a href="{{route('transaction')}}" class="link ucap">View ALL <em class="fas fa-angle-right ml-2"></em></a></div>
                                                </div>
                                                <table class="data-table dt-init user-dtnx table-responsive">
                                                        <thead>
                                                                <tr class="data-item data-head">
                                                                        <th class="data-col dt-tnxno">Tranx NO</th>
                                                                        <th class="data-col dt-token">Currency</th>
                                                                        <th class="data-col dt-token">Amount</th>
                                                                        <th class="data-col dt-usd-amount">Rate</th>
                                                                        <th class="data-col dt-account">Payment Method</th>
                                                                        <th class="data-col dt-type">
                                                                                <div class="dt-type-text">Status</div>
                                                                        </th>
                                                                        <th class="data-col"></th>
                                                                </tr>
                                                        </thead>
                                                        <tbody>


                                                                @if(count($trx) >0)
                                                                @foreach($trx as $k=>$data)

                                                                <tr class="data-item">
                                                                        <td class="data-col dt-tnxno">
                                                                                <div class="d-flex align-items-center">
                                                                                        @if($data->status == 0)
                                                                                        <div class="data-state data-state-pending"><span class="d-none">Pending</span></div>
                                                                                        @elseif($data->status == 1)
                                                                                        <div class="data-state data-state-progress"><span class="d-none">Progress</span></div>
                                                                                        @elseif($data->status == 2)
                                                                                        <div class="data-state data-state-approved"><span class="d-none">Approved</span></div>
                                                                                        @else
                                                                                        <div class="data-state data-state-canceled"><span class="d-none">Declined</span></div>
                                                                                        @endif
                                                                                        <div class="fake-class"><span class="lead tnx-id">{{$data->trx}}</span><span class="sub sub-date">{{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</span></div>
                                                                                </div>
                                                                        </td>
                                                                        <td class="data-col dt-token"><span class="lead token-amount">{{$data->currency->name}}</span><span class="sub sub-symbol">@if($data->type == 1) BUY @else SELL @endif</span></td>
                                                                        <td class="data-col dt-token"><span class="lead amount-pay">{{number_format($data->amount, $basic->decimal)}}</span><span class="sub sub-symbol">USD <em class="fas fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="{{number_format($data->main_amount * $basic->rate, $basic->decimal)}}"></em></span></td>
                                                                        <td class="data-col dt-usd-amount"><span class="lead amount-pay">


                                                                                        {{number_format($data->rate, $basic->decimal)}}</span><span class="sub sub-symbol">{{$basic->currency}} <em class="fas fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="1 {{$data->currency->symbol}} = {{$data->rate}} USD"></em></span></td>
                                                                        <td class="data-col dt-account"><span class="lead user-info">
                                                                                        @if($data->type == 1)

                                                                                        @if($data->gateway)
                                                                                        {{App\Gateway::whereId($data->gateway)->first()->name}}
                                                                                        @else
                                                                                        {{App\PaymentMethod::whereId($data->method)->first()->name}}
                                                                                        @endif

                                                                                        @else Wallet @endif</span><span class="sub sub-date">{{$data->created_at}}</span></td>
                                                                        <td class="data-col dt-type">
                                                                                @if($data->status == 0)
                                                                                <span class="dt-type-md badge badge-outline badge-warning badge-sm">Unpaid</span>
                                                                                @elseif($data->status == 1)
                                                                                <span class="dt-type-md badge badge-outline badge-info badge-sm"><i class="fa fa-spinner fa-spin"></i>&nbsp;Awaiting</span>
                                                                                @elseif($data->status == 2)
                                                                                <span class="dt-type-md badge badge-outline badge-success badge-sm">Approved</span>
                                                                                @else
                                                                                <span class="dt-type-md badge badge-outline badge-danger badge-sm">Declined</span>
                                                                                @endif

                                                                        </td>


                                                                        <td class="data-col text-right">
                                                                                <div class="relative d-inline-block d-md-none"><a href="#" class="btn btn-light-alt btn-xs btn-icon toggle-tigger"><em class="ti ti-more-alt"></em></a>
                                                                                        <div class="toggle-class dropdown-content dropdown-content-center-left pd-2x">

                                                                                                <ul class="data-action-list">
                                                                                                        @if($data->status == 0)

                                                                                                        @if($data->type > 0)
                                                                                                        <li><a href="{{ route('ebuypost2',$data->trx) }}" class="btn btn-auto btn-primary btn-xs"><span>Pay <span class="d-none d-xl-inline-block">Now</span></span><em class="ti ti-wallet"></em></a></li>
                                                                                                        <li><a href="{{ route('ebuydel',$data->trx) }}" class="btn btn-danger-alt btn-xs btn-icon"><em class="ti ti-trash"></em></a></li>
                                                                                                        @elseif($data->type < 1) <li><a href="{{ route('esellpost22', $data->trx) }}" class="btn btn-auto btn-primary btn-xs"><span>Pay <span class="d-none d-xl-inline-block">Now</span></span><em class="ti ti-wallet"></em></a></li>
                                                                                                                <li><a href="{{ route('eselldel', $data->trx) }}" class="btn btn-danger-alt btn-xs btn-icon"><em class="ti ti-trash"></em></a></li>
                                                                                                                @endif
                                                                                                                @endif

                                                                                                                <li><a href="#" data-toggle="modal" data-target="#transaction-{{$data->id}}details" class="btn btn-primary-alt btn-xs btn-icon"><em class="ti ti-eye"></em></a></li>
                                                                                                </ul>
                                                                                        </div>
                                                                                </div>
                                                                                <ul class="data-action-list d-none d-md-inline-flex">
                                                                                        @if($data->status == 0)
                                                                                        @if($data->type > 0)
                                                                                        <li><a href="{{ route('ebuypost2',$data->trx) }}" class="btn btn-auto btn-primary btn-xs"><span>Pay <span class="d-none d-xl-inline-block">Now</span></span><em class="ti ti-wallet"></em></a></li>
                                                                                        <li><a href="{{ route('ebuydel',$data->trx) }}" class="btn btn-danger-alt btn-xs btn-icon"><em class="ti ti-trash"></em></a></li>
                                                                                        @elseif($data->type < 1) <li><a href="{{ route('esellpost22', $data->trx) }}" class="btn btn-auto btn-primary btn-xs"><span>Pay <span class="d-none d-xl-inline-block">Now</span></span><em class="ti ti-wallet"></em></a></li>
                                                                                                <li><a href="{{ route('eselldel', $data->trx) }}" class="btn btn-danger-alt btn-xs btn-icon"><em class="ti ti-trash"></em></a></li>
                                                                                                @endif
                                                                                                @endif
                                                                                                <li><a href="#" data-toggle="modal" data-target="#transaction-{{$data->id}}details" class="btn btn-primary btn-outline btn-xs btn-icon"><em class="ti ti-eye"></em></a></li>
                                                                                </ul>
                                                                        </td>
                                                                </tr>





                                                                <!-- Modal Large -->
                                                                <div class="modal fade" id="transaction-{{$data->id}}details" tabindex="-1">
                                                                        <div class="modal-dialog modal-dialog-lg modal-dialog-centered">
                                                                                <div class="modal-content"><a href="#" class="modal-close" data-dismiss="modal" aria-label="Close"><em class="ti ti-close"></em></a>
                                                                                        <div class="popup-body popup-body-lg">
                                                                                                <div class="content-area">
                                                                                                        <div class="card-head d-flex justify-content-between align-items-center">
                                                                                                                <h4 class="card-title mb-0">Transaction Details</h4>
                                                                                                        </div>
                                                                                                        <div class="gaps-1-5x"></div>
                                                                                                        <div class="data-details d-md-flex">
                                                                                                                <div class="fake-class"><span class="data-details-title">Tranx Date</span><span class="data-details-info">{!! date(' D-d-M-Y', strtotime($data->created_at)) !!}</span></div>
                                                                                                                <div class="fake-class"><span class="data-details-title">Tranx Status</span>
                                                                                                                        @if($data->status == 0)
                                                                                                                        <span class="badge badge-warning ucap">Unpaid</span>
                                                                                                                        @elseif($data->status == 1)
                                                                                                                        <span class="badge badge-info ucap">Awaiting</span>
                                                                                                                        @elseif($data->status == 2)
                                                                                                                        <span class="badge badge-success ucap">Approved</span>
                                                                                                                        @else
                                                                                                                        <span class="badge badge-danger ucap">Declined</span>
                                                                                                                        @endif
                                                                                                                </div>
                                                                                                                <div class="fake-class"><span class="data-details-title">Tranx Code</span><span class="data-details-info">{{$data->trx}}</span></div>
                                                                                                        </div>
                                                                                                        <div class="gaps-3x"></div>
                                                                                                        <h6 class="card-sub-title">Transaction Info</h6>
                                                                                                        <ul class="data-details-list">
                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Transaction Type</div>
                                                                                                                        <div class="data-details-des">

                                                                                                                                @if($data->type == 1)
                                                                                                                                <strong>Purchase</strong>
                                                                                                                                @else

                                                                                                                                <strong>Sales</strong>
                                                                                                                                @endif
                                                                                                                        </div>
                                                                                                                </li><!-- li -->
                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Payment Method</div>
                                                                                                                        <div class="data-details-des"><strong>

                                                                                                                                        @if($data->type == 1)
                                                                                                                                        @if($data->gateway)
                                                                                                                                        {{App\Gateway::whereId($data->gateway)->first()->name}}
                                                                                                                                        @else
                                                                                                                                        {{App\PaymentMethod::whereId($data->method)->first()->name}}
                                                                                                                                        @endif
                                                                                                                                        @else Online Payment @endif<small>- Online Payment</small></strong></div>
                                                                                                                </li><!-- li -->

                                                                                                                @if($data->type == 1)
                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Payment Method</div>
                                                                                                                        <div class="data-details-des"><strong>

                                                                                                                                        @if($data->gateway)
                                                                                                                                        {{App\Gateway::whereId($data->gateway)->first()->name}}
                                                                                                                                        @else
                                                                                                                                        {{App\Bank::whereId($data->bank)->first()->name}}
                                                                                                                                        @endif
                                                                                                                                </strong></div>
                                                                                                                </li>@endif
                                                                                                                <!-- li -->
                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Amount Paid</div>
                                                                                                                        <div class="data-details-des"><span>
                                                                                                                                        @if($data->type == 1)
                                                                                                                                        @if($data->amountpaid)
                                                                                                                                        {{$basic->currency_sym}}{{number_format($data->amountpaid, $basic->decimal)}}
                                                                                                                                        @else

                                                                                                                                        {{$basic->currency_sym}}{{number_format($data->main_amo, $basic->decimal)}}
                                                                                                                                        @endif
                                                                                                                                        @else
                                                                                                                                        USD {{number_format($data->amount, $basic->decimal)}}
                                                                                                                                        @endif

                                                                                                                                </span> <span></span></div>
                                                                                                                </li><!-- li -->

                                                                                                                @if($data->type == 1)
                                                                                                                @if($data->depositor)
                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Depositor's Name</div>
                                                                                                                        <div class="data-details-des"><span>{{$data->depositor}}</span> <span></span></div>
                                                                                                                </li>
                                                                                                                @endif
                                                                                                                @endif
                                                                                                                @if($data->tnum)
                                                                                                                <!-- li -->
                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Transaction Number</div>
                                                                                                                        <div class="data-details-des">{{$data->tnum}}</div>
                                                                                                                </li>
                                                                                                                @endif
                                                                                                                @if($data->image)
                                                                                                                <li><br>
                                                                                                                        <div class="data-details-head">Payment Screenshot</div>&nbsp;&nbsp;&nbsp;<div class="data-doc-item data-doc-item-lg">
                                                                                                                                <div class="data-doc-image"><img src="{{asset('uploads/payments/'.$data->image)}}" alt="passport"></div>
                                                                                                                                <ul class="data-doc-actions">
                                                                                                                                        <li><a href="{{asset('uploads/payments/'.$data->image)}}" download><em class="ti ti-import"></em></a></li>
                                                                                                                                </ul>
                                                                                                                        </div>
                                                                                                                </li>
                                                                                                                @endif

                                                                                                                <!-- li -->
                                                                                                        </ul><!-- .data-details -->
                                                                                                        <div class="gaps-3x"></div>
                                                                                                        <h6 class="card-sub-title">Currency Details</h6>
                                                                                                        <ul class="data-details-list">
                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Currency Name</div>
                                                                                                                        <div class="data-details-des"><strong>{{$data->currency->name}}</strong></div>
                                                                                                                </li><!-- li -->
                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Rate</div>
                                                                                                                        <div class="data-details-des"><span><strong>

                                                                                                                                                @if($data->type == 1)
                                                                                                                                                {{$data->currency->buy}}
                                                                                                                                                @else
                                                                                                                                                {{$data->currency->sell}}
                                                                                                                                                @endif

                                                                                                                                                {{$basic->currency}}</strong> <em class="fas fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="1 USD = {{$data->currency->buy}}{{$basic->currency}}"></em></span><span><em class="fas fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="1 USD = {{$data->currency->buy}}{{$basic->currency}}"></em> 1 USD = {{$data->currency->buy}}{{$basic->currency}}</span></div>
                                                                                                                </li><!-- li -->

                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Amount Payable</div>
                                                                                                                        <div class="data-details-des"><span>{{number_format($data->main_amo, $basic->decimal)}}{{$basic->currency}} </span><span>@if($data->type == 1 )(including charges) @endif</span></div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Amount In Dollars</div>
                                                                                                                        <div class="data-details-des"><strong>{{number_format($data->amount, $basic->decimal)}} USD<small></small></strong></div>
                                                                                                                </li><!-- li -->
                                                                                                                <!-- li -->
                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Amount in {{$basic->currency}}</div>
                                                                                                                        <div class="data-details-des"><strong>{{number_format($data->main_amo, $basic->decimal)}}{{$basic->currency}} <small>- @if($data->type == 1 )(including charges) @endif</small></strong></div>
                                                                                                                </li>

                                                                                                                @if($data->type == 1)
                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Amount Paid</div>
                                                                                                                        <div class="data-details-des"><strong>{{number_format($data->amountpaid, $basic->decimal)}}{{$basic->currency}} <small>- Amount You Paid</small></strong></div>
                                                                                                                </li>

                                                                                                                <!-- li -->
                                                                                                                <!-- li -->
                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Value</div>
                                                                                                                        <div class="data-details-des"><span>{{$data->currency->symbol}}{{number_format($data->getamo, 8)}}</span> </div>
                                                                                                                </li><!-- li -->
                                                                                                                @endif
                                                                                                                @if($data->type == 1)
                                                                                                                <li>
                                                                                                                        <div class="data-details-head">Wallet Address</div>
                                                                                                                        <div class="data-details-des"><span><strong>{{$data->wallet}}</strong></span></div>
                                                                                                                </li>
                                                                                                                @endif

                                                                                                                <!-- li -->
                                                                                                        </ul><!-- .data-details -->
                                                                                                </div><!-- .card -->
                                                                                        </div>
                                                                                </div><!-- .modal-content -->
                                                                        </div><!-- .modal-dialog -->
                                                                </div><!-- Modal End -->
                                                                @endforeach
                                                                @else
                                                                No Transaction Record Forund Yet
                                                                @endif

                                                                <!-- .data-item -->
                                                        </tbody>
                                                </table><!-- .table -->
                                        </div>
                                </div>
                        </div>




                        <div class="col-xl-4 col-lg-5">
                                <div class="token-sales card card-full-height">
                                        <div class="card-innr">
                                                <div class="card-head">
                                                        <h4 class="card-title">Currency/Coin Calculator</h4>
                                                </div><iframe src="https://widget.coinlib.io/widget?type=converter&theme=light" style="width:100%" height="310px" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;"></iframe>
                                        </div>
                                </div>
                        </div>



                </div><!-- .container -->
        </div><!-- .page-content -->
        @endsection
        @section('js')


        @endsection