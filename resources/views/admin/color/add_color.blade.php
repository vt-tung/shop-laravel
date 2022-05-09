@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Add color for products
                        </header>
                         <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
                        <form action="{{url('/insert-color/'.$pro_id)}}" method="POST" style="margin-top: 40px;">
                            @csrf
                        <div class="row">
                            <div class="col-md-3" align="right">
                                
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="file" name="color_name">
                                <span id="error_color"></span>
                            </div>
                            <div class="col-md-3" >
                                <input type="submit" name="upload" name="taimau" value="Load color" class="btn btn-success ">
                            </div>
                            
                        </div>
                        </form>

                        <div class="panel-body">
                            <input type="hidden" value="{{$pro_id}}" name="pro_id" class="pro_id">
                            <form >
                                <div id="color_load">
                                   
                                </div>
                            </form>

                        </div>
                    </section>

            </div>
@endsection