@extends('layouts.front')
@section('title','Thank You')
@section('description','Thank You')
@section('keywords','Thank You')
@section('content')
<section class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-4">
                <span class="icon icon-xl icon-success"><i class="ti ti-check-box"></i></span>
                <h1 class="mb-2">Thank you for your order!</h1>                            <div class="thanks-content">
                                <h3><i class="icofont icofont-tick-mark"></i> Congratulations. <br>Your order was Completed Successfully.</h3>
                                <p><strong>Hi <?php echo (isset($lastOrder) && !empty($lastOrder)) ? $lastOrder->user->first_name : ''; ?>,</strong></p>
                                <p>We have received your order.<br> <?php if($lastOrder->take_order != 'takeaway'){ ?>We will send you an Email and SMS the moment your order items are dispatched to your address.<?php } ?></p>
                                <p>Your Order ID: <strong><?php echo (isset($lastOrder) && !empty($lastOrder)) ? $lastOrder->order_number : ''; ?></strong></p>
                            </div><br>
                <a href="<?php echo URL::to('/'); ?>" class="btn btn-outline-secondary"><span>Go back to Home</span></a>
            </div>
        </div>
    </div>
</section>
            <!-- Breadcrumb End -->
			


			
@endsection
