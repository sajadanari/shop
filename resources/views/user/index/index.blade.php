@extends("user.layouts.user_layout")

@section("user-page-title", "My Account")

@section("user-content")
  
<div class="page-content my-account__dashboard">
  <p>Hello <strong>{{ Auth::user()->name }}</strong></p>
  <p>From your account dashboard you can view your <a class="unerline-link" href="account_orders.html">recent
      orders</a>, manage your <a class="unerline-link" href="account_edit_address.html">shipping
      addresses</a>, and <a class="unerline-link" href="account_edit.html">edit your password and account
      details.</a></p>
</div>

@endsection