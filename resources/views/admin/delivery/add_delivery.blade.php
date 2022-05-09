@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Add fee shipping
                        </header>
                         <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
                        <div class="panel-body">

                            <div class="position-center">
                                <form>
                                    @csrf 
                             
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Select city or province:</label>
                                      <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                    
                                            <option value="">--Select city or province--</option>
                                        @foreach($city as $key => $ci)
                                            <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                                        @endforeach
                                            
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Select District:</label>
                                      <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                                            <option value="">--Select District--</option>
                                           
                                    </select>
                                </div>
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Select Commune:</label>
                                      <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                            <option value="">--Select Commune--</option>   
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Fee shipping</label>
                                    <input type="text" name="fee_ship" class="form-control fee_ship" id="exampleInputEmail1" >
                                </div>
                               
                                <button type="button" name="add_delivery" class="btn btn-info add_delivery">Add fee shipping</button>
                                </form>
                            </div>

                            <div id="load_delivery" style="margin-top: 50px">
                                
                            </div>
                            
                        </div>
                    </section>

            </div>
@endsection