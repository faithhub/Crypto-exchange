@extends('include.admindashboard')

@section('body')


<script>
  function goBack() {
    window.history.back()
  }
</script>

<div class="page-content">
  <div class="container">
    <div class="card content-area">
      <div class="card-innr">
        <div class="card-head d-flex justify-content-between align-items-center">
          <h4 class="card-title mb-0">Transaction Details</h4><a href="#" onclick="goBack()" class="btn btn-sm btn-auto btn-primary d-sm-block d-none"><em class="fas fa-arrow-left mr-3"></em>Back</a><a href="#" onclick="goBack()" class="btn btn-icon btn-sm btn-primary d-sm-none"><em class="fas fa-arrow-left"></em></a>
        </div>
        <div class="gaps-1-5x"></div>
        <div class="data-details d-md-flex">
          <div class="fake-class"><span class="data-details-title">Transaction Date</span><span class="data-details-info">{{date('d M Y',strtotime($exchange->created_at))}}</span></div>
          <div class="fake-class"><span class="data-details-title">Transaction Status</span>
            @if( $exchange->status == "Confirmed" )
            <span class="badge badge-success">Approved</span>
            @elseif( $exchange->status == "Declined" )
            <span class="badge badge-danger">Declined</span>
            @elseif( $exchange->status == "Pending" )
            <span class="badge badge-warning">Pending</span>
            @endif
          </div>
          <div class="fake-class"><span class="data-details-title">Transaction Time</span><span class="data-details-info"> {{$exchange->created_at}}</span></div>
        </div>
        <div class="gaps-3x"></div>

        <ul class="data-details-list">
          <li>
            <div class="data-details-head">Transaction Type</div>
            <div class="data-details-des"><strong>{{$exchange->type}}</strong></div>
          </li><!-- li -->
          <li>
            <div class="data-details-head">Transaction ID</div>
            <div class="data-details-des"><span>{{$exchange->trx}} </span> <span></span></div>
          </li><!-- li -->

          <li>
            <div class="data-details-head">Amount</div>
            <div class="data-details-des"><b style="color:#21a184">{{ $basic->currency_sym}}{{number_format($exchange->amount, $basic->decimal)}}</b></div>
          </li>

          <li>
            <div class="data-details-head">Charge</div>
            <div class="data-details-des"><b style="color:#21a184">{{ $basic->currency_sym}}{{number_format($exchange->charge, $basic->decimal)}}</b></div>
          </li>

          <li>
            <div class="data-details-head">Total Amount</div>
            <div class="data-details-des"><b style="color:#21a184">{{ $basic->currency_sym}}{{number_format($exchange->amount + $exchange->charge, $basic->decimal)}}</b></div>
          </li>
          @if(isset($exchange->currency_amount_usd))
          <li>
            <div class="data-details-head">Amount In USD</div>
            <div class="data-details-des"><b style="color:#21a184">${{number_format($exchange->currency_amount_usd, $basic->decimal)}}</b></div>
          </li>
          @endif
        </ul><!-- .data-details -->

        @if(isset($exchange->bank))
        <div class="gaps-3x"></div>
        <h6 class="card-sub-title">Bank Account Details</h6>
        <ul class="data-details-list">
          <li>
            <div class="data-details-head">Bank Name</div>
            <div class="data-details-des"><span>{{$exchange->bank}}</span></div>
          </li>
          <li>
            <div class="data-details-head">Account Name</div>
            <div class="data-details-des"><span>{{$exchange->acc_name}}</span></div>
          </li>
          <li>
            <div class="data-details-head">Account Number</div>
            <div class="data-details-des"><span>{{$exchange->acc_num}}</span></div>
          </li>
          <!-- li -->
        </ul>

        @endif
      </div>
    </div><!-- .card -->
  </div><!-- .container -->
</div>
@endsection
@section('script')
@endsection