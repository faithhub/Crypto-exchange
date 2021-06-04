@extends('include.userdashboard')
@section('content')
<style>
  .error {
    color: red;
  }

  .acc {
    font-size: 16px;
    letter-spacing: 0.03em;
    margin-bottom: 0;
    text-transform: uppercase;
    font-weight: bolder
  }
</style>
<div class="page-content">
  <div class="container">
    <div class="row">
      <div class="main-content col-lg-12">
        <div class="content-area card">
          <div class="card-innr">
            <h4 class="card-title" id="dep_text">Deposit Transaction Preview</h4>
            <div class="text-right mt-2">
              <a href="{{ route('cancel-deposit',$data->trx) }}" onclick="return confirm('Are you sure you want to Cancelled this Deposit Transaction?')" class="btn btn-danger btn-between">Cancel Payment <em class="ti ti-wallet"></em></a>
            </div>

            <div id="confirm">
              <div class="card-head"><span class="card-sub-title text-primary font-mid">Step 1</span>
                <h4 class="card-title"> Payment Preview</h4>
              </div>
              <div class="card-text">
                <p>You have opted to Deposit using {{$data->payment_method_id}}
                  Please find your pre-payment summary below.</p>
              </div>

              <div class="token-overview-wrap">
                <div class="token-overview">
                  <div class="row">
                    <div class="col-md-4 col-sm-6">
                      <div class="token-bonus token-bonus-sale"><span class="token-overview-title">Amount</span><span class="token-overview-value bonus-on-sale">{{ $basic->currency_sym}}{{number_format($data->amount, $basic->decimal)}}</span></div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                      <div class="token-bonus token-bonus-amount"><span class="token-overview-title">Deposit Charge</span><span class="token-overview-value bonus-on-amount">{{ $basic->currency_sym}}{{number_format($data->charge, $basic->decimal)}}</span></div>
                    </div>
                    <div class="col-md-4">
                      <div class="token-total"><span class="token-overview-title font-bold">Total Amount</span><span class="token-overview-value token-total-amount text-primary">{{ $basic->currency_sym}}{{number_format($data->amount + $data->charge, $basic->decimal)}}</span></div>
                    </div>

                  </div>
                </div>
                <div class="note note-plane note-danger note-sm pdt-1x pl-0">
                  <p>Note: Do not pay below the Total Amount of {{ $basic->currency_sym}}{{number_format($data->amount + $data->charge, $basic->decimal)}}</p>
                </div>
              </div>
              <hr>
              <div class="card-head"><span class="card-sub-title text-primary font-mid">Step 2</span>
                <h4 class="card-title">Make Payment Using Bank Transfer </h4>
              </div>
              <div class="card-text">
                <p>Make Payment to the Account Details below using {{$data->method->name}} option as you've choosen. </p>
              </div>
              <div class="schedule-item">
                <div class="row mt-2">
                  <div class="col-xl-4 col-md-5 col-lg-6">
                    <div class="pdb-1x">
                      <h5 class="schedule-title">
                        <span">Bank Name</span>
                      </h5><span class="acc">{{$data->bank}}</span>
                    </div>
                  </div>
                  <div class="col-xl-4 col-md col-lg-6">
                    <div class="pdb-1x">
                      <h5 class="schedule-title">
                        <span">Account Name</span>
                      </h5><span class="acc">{{$data->acc_name}}</span>
                    </div>
                  </div>
                  <div class="col-xl-4 col-md col-lg-6">
                    <div class="pdb-1x">
                      <h5 class="schedule-title">
                        <span">Account Number</span>
                      </h5><span class="acc">{{$data->acc_num}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="gaps-3x"></div>
              <hr>
              <div class="card-head"><span class="card-sub-title text-primary font-mid">Step 3</span>
                <h4 class="card-title">Confirm Payment</h4>
              </div>
              <div class="card-text">
                <p>Click on the button below after making a successful transaction</p>
              </div>
              <div class="text-left mt-2">
                <button type="submit" onclick="proceed()" class="btn btn-primary btn-between">Proceed To Pay <em class="ti ti-wallet"></em></button>
              </div>
            </div>
            <div id="back_confirm" style="display:none">
              <div class="mt-3">
                <div class="">
                  <form method="POST" action="{{ route('confirm_deposit_save') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                      <div class="input-item input-with-label">
                        <label class="input-item-label text-exlight">Transaction Number</label>
                        <input name="trans_number" class="input-bordered" type="text">
                        <label class="input-item-label text-exlight"><small> (Please enter your payment transaction number,)</small></label><br>
                        <label class="input-item-label text-exlight"><small>
                            @if ($errors->has('trans_number'))
                            <span class="error">
                              {{ $errors->first('trans_number') }}
                            </span><br>
                            @endif</small></label>
                        <br>
                      </div>

                      <input name="trx" value="{{$data->trx}}" hidden="">
                      <div class="input-item input-with-label"><label class="input-item-label text-exlight">Attachment Upload</label>
                        <div class="relative"><em class="input-file-icon fas fa-upload"></em>
                          <input type="file" name="prove" required class="input-file" id="file-01" accept="image/*"><label for="file-01">Choose a file</label>
                        </div>
                        <label><small> (Please attach a screenshot of your bank transfer of payment slip)</small></label><br>
                        <label><small>
                            @if ($errors->has('prove'))
                            <span class="error">
                              {{ $errors->first('prove') }}
                            </span><br>
                            @endif</small></label>
                      </div>
                      <button type="submit" class="btn btn-primary btn-between">Confirm Payment</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="text-left mt-3">
                <a href="#" class="mt-3" onclick="back()"><span class="schedule-bonus" style="color: grey;">Back To Payment Details</span></a>
              </div>
            </div>
            <div class="pay-notes">
              <div class="note note-plane note-light note-md font-italic"><em class="fas fa-info-circle"></em>
                <p>Fund will appear in your account after payment successfully made. </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
<script>
  function proceed() {
    document.getElementById("dep_text").textContent = 'Deposit Confirmation Form';
    var div = document.getElementById("confirm");
    div.style.display = 'none';
    var div = document.getElementById("back_confirm");
    div.style.display = 'block';
  }

  function back() {
    document.getElementById("dep_text").textContent = 'Deposit Transaction Preview';
    var div = document.getElementById("back_confirm");
    div.style.display = 'none';
    var div = document.getElementById("confirm");
    div.style.display = 'block';
  }
</script>