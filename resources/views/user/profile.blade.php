@extends('include.userdashboard')

@section('content')
<div class="page-content">
  <div class="container">
    <div class="row">
      <div class="main-content col-lg-8">
        <div class="content-area card">
          <div class="card-innr">
            <div class="card-head">
              <h4 class="card-title">Profile Details</h4>
            </div>
            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
              <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#personal-data">Personal Data</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#settings">Settings</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#password">Password</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#bank">Bank Account Details</a></li>
            </ul><!-- .nav-tabs-line -->
            <div class="tab-content" id="profile-details">
              <div class="tab-pane fade show active" id="personal-data">{!! Form::open(['method'=>'post','role'=>'form','name' =>'editForm', 'files'=>true]) !!}

                <div class="row">

                  <div class="col-md-6">
                    <div class="input-item input-with-label"><label for="full-name" class="input-item-label">First Name</label><input name="fname" class="input-bordered" type="text" value="{{$user->fname}}">

                    </div><!-- .input-item -->
                  </div>
                  <div class="col-md-6">
                    <div class="input-item input-with-label"><label for="email-address" class="input-item-label">Last Name</label><input name="lname" class="input-bordered" type="text" value="{{$user->lname}}">

                    </div><!-- .input-item -->
                  </div>

                  <div class="col-md-6">
                    <div class="input-item input-with-label"><label for="mobile-number" class="input-item-label">Email Address</label><input class="input-bordered" type="email" id="mobile-number" value="{{$user->email}}" readonly name="email"></div>
                    <!-- .input-item -->
                  </div>

                  <div class="col-md-6">
                    <div class="input-item input-with-label"><label for="mobile-number" class="input-item-label">Phone Numbner</label><input class="input-bordered" type="text" id="mobile-number" value="{{$user->phone}}" name="phone"></div>
                    <!-- .input-item -->
                  </div>

                  <div class="col-md-6">
                    <div class="input-item input-with-label"><label for="mobile-number" class="input-item-label">County <small>{{$user->country}}</small></label> <select onchange="print_state('state', this.selectedIndex);" id="country" name="country" class="select-bordered select-block" /></select>
                      <script language="javascript">
                        print_country("country");
                      </script>
                    </div>
                    <!-- .input-item -->
                  </div>


                  <div class="col-md-6">
                    <div class="input-item input-with-label"><label for="mobile-number" class="input-item-label">Address</label><input class="input-bordered" type="text" id="mobile-number" value="{{$user->address}}" name="address"></div>
                    <!-- .input-item -->
                  </div>


                  <div class="col-md-6">
                    <div class="input-item input-with-label"><label for="mobile-number" class="input-item-label">City</label><input class="input-bordered" type="text" id="mobile-number" value="{{$user->city}}" name="city"></div>
                    <!-- .input-item -->
                  </div>


                  <div class="col-md-6">
                    <div class="input-item input-with-label"><label for="mobile-number" class="input-item-label">Zip Code</label><input class="input-bordered" type="text" id="mobile-number" value="{{$user->zip_code}}" name="zip_code"></div>
                    <!-- .input-item -->
                  </div>




                  <div class="col-md-6">
                    <div class="input-item input-with-label"><label for="date-of-birth" class="input-item-label">Date of Birth</label><input class="input-bordered date-picker-dob" value="{{$user->dob}}" type="text" id="date-of-birth" name="dob"></div><!-- .input-item -->
                  </div><!-- .col -->



                  <div class="col-md-6">
                    <div class="input-item input-with-label"><label for="nationality" class="input-item-label">Upload Avatar</label>
                      <div class="relative"><em class="input-file-icon fas fa-upload"></em><input type="file" class="input-file" id="file-01" name="image" accept="image/*"><label for="file-01">Choose a file</label></div>


                    </div><!-- .input-item -->
                  </div><!-- .col -->
                </div><!-- .row -->
                <div class="gaps-1x"></div><!-- 10px gap -->
                <div class="d-sm-flex justify-content-between align-items-center"><button class="btn btn-primary">Update Profile</button>
                  <div class="gaps-2x d-sm-none"></div>
                </div> {!! Form::close() !!}
                <!-- form -->
              </div><!-- .tab-pane -->
              <div class="tab-pane fade" id="bank">
                <form method="post" action="{{route('check_bank') }}">
                  @csrf
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-item input-with-label">
                        <label for="old-pass" class="input-item-label">Select Bank</label>
                        <select name="bank" class="input-bordered" required>
                          <option value="">Choose...</option>
                          @foreach($banks as $bank)
                          <option value="{{$bank->code}}" {{ Auth::user()->bank == $bank->bank ? "selected" : '' }}>{{$bank->bank}}</option>
                          @endforeach
                        </select>
                        @if ($errors->has('bank'))
                        <span class="error">
                          {{ $errors->first('bank') }}
                        </span><br>
                        @endif
                      </div><!-- .input-item -->
                    </div><!-- .col -->
                  </div><!-- .row -->

                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-item input-with-label"><label for="new-pass" class="input-item-label">Account Name</label>
                        <input class="input-bordered" type="text" value="{{Auth::user()->accountname }}" readonly name="acc_name" style="cursor: no-drop; background-color: #e9eff9;">
                      </div><!-- .input-item -->
                    </div>

                    <!-- .col -->
                    <div class="col-md-12">
                      <div class="input-item input-with-label"><label for="confirm-pass" class="input-item-label">Account Number</label>
                        <input class="input-bordered" type="number" id="confirm-pass" name="acctnumber" value="{{Auth::user()->accountno }}" required>
                        @if ($errors->has('acctnumber'))
                        <span class="error">
                          {{ $errors->first('acctnumber') }}
                        </span><br>
                        @endif
                      </div><!-- .input-item -->
                    </div><!-- .col -->
                  </div><!-- .row -->

                  <div class="note note-plane note-info pdb-1x">
                    <!-- <em class="fas fa-info-circle"></em> -->
                    <!-- <p>Password should be minmum 8 letter and include lower and uppercase letter for better security.</p> -->
                  </div>
                  <div class="gaps-1x"></div>
                  <div class="d-sm-flex /justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                  </div>

                </form>
              </div>
              <div class="tab-pane fade" id="settings">
                <div class="pdb-1-5x">
                  <h5 class="card-title card-title-sm text-dark">Security Settings</h5>
                </div>
                <div class="input-item"><input type="checkbox" class="input-switch input-switch-sm" id="save-log" checked><label for="save-log">Save my Activities Log</label></div>
                <div class="input-item"><input type="checkbox" class="input-switch input-switch-sm" id="pass-change-confirm"><label for="pass-change-confirm">Confirm me through email before password change</label></div>
                <div class="pdb-1-5x">
                  <h5 class="card-title card-title-sm text-dark">Manage Notification</h5>
                </div>
                <div class="input-item"><input type="checkbox" class="input-switch input-switch-sm" id="latest-news" checked><label for="latest-news">Notify me by email about sales and latest news</label></div>
                <div class="input-item"><input type="checkbox" class="input-switch input-switch-sm" id="activity-alert" checked><label for="activity-alert">Alert me by email for unusual activity.</label></div>
                <div class="gaps-1x"></div>
                <div class="d-flex justify-content-between align-items-center"><span></span><span class="text-success"><em class="ti ti-check-box"></em> Setting has been updated</span></div>
              </div><!-- .tab-pane -->
              <div class="tab-pane fade" id="password">
                <form method="post" action="{{route('user.change-password') }}">
                  @csrf

                  <div class="row">


                    <div class="col-md-6">
                      <div class="input-item input-with-label">

                        <label for="old-pass" class="input-item-label">Old Password</label><input class="input-bordered" type="password" id="old-pass" name="current_password">
                      </div><!-- .input-item -->
                    </div><!-- .col -->
                  </div><!-- .row -->

                  <div class="row">

                    <div class="col-md-6">
                      <div class="input-item input-with-label"><label for="new-pass" class="input-item-label">New Password</label><input class="input-bordered" type="password" id="new-pass" name="password"></div><!-- .input-item -->
                    </div>

                    <!-- .col -->
                    <div class="col-md-6">
                      <div class="input-item input-with-label"><label for="confirm-pass" class="input-item-label">Confirm New Password</label><input class="input-bordered" type="password" id="confirm-pass" name="password_confirmation"></div><!-- .input-item -->
                    </div><!-- .col -->
                  </div><!-- .row -->

                  <div class="note note-plane note-info pdb-1x"><em class="fas fa-info-circle"></em>
                    <p>Password should be minmum 8 letter and include lower and uppercase letter for better security.</p>
                  </div>
                  <div class="gaps-1x"></div>

                  <!-- 10px gap -->
                  <div class="d-sm-flex /justify-content-between align-items-center"><button type="submit" class="btn btn-primary">Update</button>

                </form>
              </div>
            </div><!-- .tab-pane -->
          </div><!-- .tab-content -->
        </div><!-- .card-innr -->
      </div><!-- .card -->
      <div class="content-area card">
        <div class="card-innr">
          <div class="card-head">
            <h4 class="card-title">Two-Factor Verification</h4>
          </div>
          <p>Two-factor authentication is a method for protection your web account. When it is activated you need to enter not only your password, but also a special code. You can receive this code by in mobile app. Even if third person will find your password, then can't access with that code.</p>
          <div class="d-sm-flex justify-content-between align-items-center pdt-1-5x"><span class="text-light ucap d-inline-flex align-items-center"><span class="mb-0"><small>Current Status:</small></span> <span class="badge badge-disabled ml-2">Disabled</span></span>
            <div class="gaps-2x d-sm-none"></div><button class="order-sm-first btn btn-primary">Enable 2FA</button>
          </div>
        </div><!-- .card-innr -->
      </div><!-- .card -->
    </div><!-- .col -->
    <div class="aside sidebar-right col-lg-4">
      <div class="account-info card">
        <div class="card-innr">
          <h6 class="card-title card-title-sm">Account Verification Status</h6>
          <ul class="btn-grp">
            <li>

              @if(Auth::user()->email_verify == 0)
              <a href="#" class="btn btn-auto btn-xs btn-danger">Email Verify Pending</a>
              @else
              <a href="#" class="btn btn-auto btn-xs btn-success">Email Verify Pending</a>
              @endif

            </li>
            <li>
              @if(Auth::user()->phone_verify == 0)
              <a href="#" class="btn btn-auto btn-xs btn-danger">Phone Verify Pending</a>
              @else
              <a href="#" class="btn btn-auto btn-xs btn-success">Phone Verify Pending</a>
              @endif
            </li>
          </ul>
        </div>
      </div>
      <div class="referral-info card">
        <div class="card-innr">
          <h6 class="card-title card-title-sm">Earn with Referral</h6>
          <p class=" pdb-0-5x">Invite your friends &amp; family and receive a <strong><span class="text-primary">bonus of {{$basic->currency_sym}}{{$basic->ref}}</span> when they get verified.</strong></p>
          <div class="copy-wrap mgb-0-5x"><span class="copy-feedback"></span><input type="text" class="copy-address" value="{{ route('refer.register',auth::user()->username) }}" disabled><button class="copy-trigger copy-clipboard" data-clipboard-text="{{ route('refer.register',auth::user()->username) }}"><em class="ti ti-files"></em></button></div><!-- .copy-wrap -->
        </div>
      </div>
      <div class="kyc-info card">
        <div class="card-innr">
          <h6 class="card-title card-title-sm">Identity Verification - KYC</h6>
          <p>To comply with regulation and be eligible for daily bonus and cryptocurrency purchase , customers will have to go through indentity verification.</p>

          @if(Auth::user()->verified == 1)
          <p class="lead text-light pdb-0-5x">Your have submitted your KYC request. You will be notified once approved.</p>
          <a href="{{route('verification')}}" class="btn btn-primary btn-block">View Submission</a>
          @elseif(Auth::user()->verified == 2)
          <p class="lead text-light pdb-0-5x">Your KYC verification request has been approved. You are eligible for bonus and offers</p>
          <a href="{{route('verification')}}" class="btn btn-primary btn-block">View Submission</a>
          @elseif(Auth::user()->verified == 3)
          <p class="lead text-light pdb-0-5x">Your KYC verification request has been rejected. Please try again now.</p>
          <a href="{{route('verification')}}" class="btn btn-primary btn-block">Try Again</a>
          @else
          <p class="lead text-light pdb-0-5x">You have not submitted your KYC application to verify your indentity.</p>
          <a href="{{route('verification')}}" class="btn btn-primary btn-block">Click to Proceed</a>
          @endif


          <h6 class="kyc-alert text-danger">* KYC verification required for purchase of cryptocurrencies</h6>
        </div>
      </div>
    </div><!-- .col -->
  </div><!-- .container -->
</div><!-- .container -->
</div><!-- .page-content -->
@endsection