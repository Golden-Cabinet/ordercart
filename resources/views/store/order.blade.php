@extends('store.layouts.main')
@section('content')

<div class="col-md-10" style="margin: auto;">
    <h1 class="text-center">ORDERS</h1>
    <h3 class="text-center">THREE PATHS</h3>
  
    <p>
      1. <strong>Send an email to <a href="mailto:orders@goldencabinetherbs.com?subject=Golden Cabinet Order">orders@goldencabinetherbs.com</a></strong> with the formula in the body of the email. Please tell us:
    </p>

      <ul class="ml-4 mt-3 mb-4">
        <li>Your name</li>
        <li>Your phone number</li>
        <li>Your patient's name</li>
        <li>Your patient's phone number</li>
        <li>Whether the formula will be picked up or shipped</li>
        <li>If shipped, the shipping address</li>
        <li>If picked up, when the formula should be ready</li>
        <li>Who's going to pay for the formula (you or your patient)</li>
        <li>How many refills (if any) would you like to authorize?</li>    
      </ul>

  
    <p>
      2. <strong>Download <a href="/Golden Cabinet Order Form.xls" download="<?php echo "/Golden Cabinet Order Form " . date("F Y"). ".xls";?>">this Order Form</a></strong>, fill it out and email it to orders@goldencabinetherbs.com - all the information we need is on the Order Form.  
    </p>
  
    <p>
      3. <strong>Call <a href="tel:1-503-233-4102">(503) 233-4102</a></strong> and we'll talk you through it.  
    </p>
  </div>
  
  

@push('js')

@endpush
@endsection