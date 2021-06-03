@extends('include.userdashboard')
@section('content')
<div class="page-content">
  <div class="container">
    <div class="row">
      <div class="main-content col-lg-12">
        <div class="content-area card">
          <div class="card-innr">
            <div class="">
              <div class="popup-body">
                <div class="card-head">
                  <h4 class="card-title">Deposit</h4>
                </div>
                <h4 class="popup-title">Fund Your Naira Wallet</h4>
                <p class="lead">You currently have <span><b>{{$basic->currency_sym}}{{number_format(Auth::user()->balance, $basic->decimal)}}</b></span> in your deposit wallet. Fill the form below to proceed.</p>
                <p>You can choose any of following payment method to fund your wallet. The fund will appear in your account after successfull payment.</p>
                <form method="POST" action="{{ route('make_deposit_now') }}">
                  @csrf
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-item input-with-label">
                        <h5 class="mgt-1-5x font-mid">Select payment method:</h5>
                        <select onchange="showDiv('div',this)" class="select-bordered select-block" id="" name="payment" required>
                          <option value="1" selected>Choose...</option>
                          <option value="2">Bank Transfer </option>
                          <option value="3">Online Payment </option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div id="div1" style="display:block;">

                  </div>
                  <div id="div2" style="display:none;">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="input-item input-with-label">
                          <h5 class="mgt-1-5x font-mid">Payment Method</h5>
                          <select required class="select-bordered select-block" id="mySelect" onchange="myFunction()" name="method">
                            <option selected>Choose...</option>
                            @foreach($method as $data)
                            <option value="{{$data->id}}">{{$data->name}} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="input-item input-with-label">
                          <h5 class="mgt-1-5x font-mid">Select Bank</h5>
                          <select required class="select-bordered select-block" name="bank">
                            <option selected>Choose...</option>
                            @foreach($bank as $data)
                            <option value="{{$data->id}}">{{$data->name}} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="div3" style="display:none;">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="input-item input-with-label">
                          <h5 class="mgt-1-5x font-mid">Select Payment Gateway</h5>
                          <select required class="select-bordered select-block" name="gateway" required>
                            <option selected>Choose...</option>
                            @foreach($gates as $data)
                            <option value="{{$data->id}}">{{$data->name}} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <h5 class="mgt-1-5x font-mid">Enter Amount:</h5>
                  <div class="copy-wrap mgb-0-5x">
                    <input required="" type="number" name="amount" class="copy-address">
                    <buttonn class="copy-trigger"><em class="ti ti-wallet"></em></buttonn>
                  </div>
                  <span class="text-light font-italic mgb-2x"><small>* Payment gateway company may charge you a processing fee.</small></span>
                  <div class="pdb-2-5x pdt-1-5x">
                    <input required="" type="checkbox" class="input-checkbox input-checkbox-md" id="agree-term-3">
                    <label for="agree-term-3">I hereby agree to the <strong>BMY GUIDE agreement &amp; deposit terms term</strong>.</label>
                  </div>
                  <ul class="d-flex flex-wrap align-items-center guttar-30px">
                    <li><button type="submit" class="btn btn-primary">Accept &amp; Process Payment <em class="ti ti-arrow-right mgl-2x"></em></button></li>
                  </ul>
                  <div class="gaps-2x"></div>
                  <div class="gaps-1x d-none d-sm-block"></div>
                  <div class="note note-plane note-light mgb-1x"><em class="fas fa-info-circle"></em>
                    <p class="text-light">You will automatically redirect for payment after your order placing.</p>
                  </div>
                </form>
              </div>
            </div>
          </div><!-- .container -->
        </div><!-- .page-content -->
        <script>
          function showDiv(prefix, chooser) {
            console.log(prefix)
            console.log(chooser)
            for (var i = 0; i < chooser.options.length; i++) {
              var div = document.getElementById(prefix + chooser.options[i].value);
              div.style.display = 'none';
            }

            var selectedOption = (chooser.options[chooser.selectedIndex].value);
            if (selectedOption == "1") {
              displayDiv(prefix, "1");
            }
            if (selectedOption == "2") {
              displayDiv(prefix, "2");
            }
            if (selectedOption == "3") {
              displayDiv(prefix, "3");
            }
          }

          function displayDiv(prefix, suffix) {
            var div = document.getElementById(prefix + suffix);
            div.style.display = 'block';
          }
        </script>
        @endsection