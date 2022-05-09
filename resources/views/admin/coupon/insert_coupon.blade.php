@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Add discount code
                        </header>

                        <div class="panel-body">
                          <?php
                              $message = Session::get('messageadd');
                              if($message){
                                  ?>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      {{$message}}
                                    </div>
                                  <?php
                                  Session::put('messageadd',null);
                              }

                              $message = Session::get('messageadd_coupon_success');
                              if($message){
                                  ?>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      {{$message}}
                                    </div>
                                  <?php
                                  Session::put('messageadd_coupon_success',null);
                              }
                          ?>
                            <div class="position-center cl-add-coupon">
                                <form role="form" action="{{URL::to('/insert-coupon-code')}}" method="post">
                                    @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Discount code name</label>
                                    <input type="text" name="coupon_name" class="form-control"  required="">
                                </div>
                                <div class="form-group">
                                    <label for="start_coupon">Start day</label>
                                    <input type="text" name="coupon_date_start" class="start_coupon form-control" id="start_coupon" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="end_coupon">End day</label>
                                    <input type="text" name="coupon_date_end" class="end_coupon form-control" id="end_coupon" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Discount code</label>
                                    <input type="text" name="coupon_code" class="form-control"  required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Number of codes</label>
                                      <input type="text" name="coupon_time" class="form-control"  required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Code features</label>
                                     <select name="coupon_condition" class="form-control input-sm m-bot15" required="">
                                             <option value="">----Choose-----</option>
                                            <option value="1">Decreased by percentage</option>
                                            <option value="2">Decreased with money</option>
                                            
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Enter the amount or discount amount</label>
                                     <input type="text" name="coupon_number" class="form-control"  required="">
                                </div>
                               
                               
                                <button type="submit" name="add_coupon" class="btn btn-info">Add code</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
</div>
<script type="text/javascript">
   
  $( function() {
    $("#start_coupon").datepicker({
        prevText:"Last month",
        nextText:"Next month",
        dateFormat:"dd/mm/yy",
        dayNamesMin: [ "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday" ]
    });
    $("#end_coupon").datepicker({
        prevText:"Last month",
        nextText:"Next month",
        dateFormat:"dd/mm/yy",
        dayNamesMin: [ "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday" ]
    });
  } );
 
</script>
@endsection