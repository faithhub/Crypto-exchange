@extends('include.userdashboard')
@section('content')
<style>
  .error {
    color: red;
  }
</style>
<div class="page-content">
  <div class="container">
    <div class="row">
      <div class="main-content col-lg-12">
        <div class="content-area card">
          <div class="card-innr">
            <div class="card-head">
              <h4 class="card-title">Deposit Transaction Preview</h4>
            </div>
            <div class="card-text">
              <p>Find below the summary of your <b>Deposit Transaction Details</b>. {{$basic->sitename}} will not be liable to any loss arising from wrong account information.</p>
              <p>You can cancel this operation by clicking the button below</p>

              <div class="pdb-1x">
                <a href="{{ route('cancel-deposit',$data->trx) }}"><span class="schedule-bonus">Cancel Deposit</span></a>
              </div>
            </div>
            <div class="gaps-3x"></div>
            <div class="card-head">
              <h5 class="card-title card-title-md">Transaction Summary</h5>
            </div>

            <div class="schedule-item">
              <div class="row">
                <div class="col-xl-4 col-md-6 col-lg-4">
                  <div class="pdb-1x">
                    <h5 class="schedule-title"><span>Amount In USD</span> </h5><span>{{number_format($data->amount, $basic->decimal)}} USD</span><span>1{{$data->currency->symbol}} = ${{number_format($data->currency->price, $basic->decimal)}}</span>
                  </div>
                </div>
                <div class="col-xl-4 col-md-6 col-lg-4">
                  <div class="pdb-1x">
                    <h5 class="schedule-title"><span>Amount In {{$basic->currency}}</span></h5><span>{{$basic->currency_sym}}{{number_format($data->main_amo, $basic->decimal)}}</span><span>$1.00 = {{$basic->currency_sym}}{{number_format($data->currency->buy, $basic->decimal)}}</span>
                  </div>
                </div>
                <div class="col-xl-4 col-md-6 col-lg-4">
                </div>
              </div>
            </div>
            <div class="schedule-item">
              <div class="row">
                <div class="col-xl-3 col-md-3 align-self-center text-xl-right">
                  <div class="pdb-1x">
                    <a href=""><span class="schedule-bonus">Proceed With Payment</span></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection