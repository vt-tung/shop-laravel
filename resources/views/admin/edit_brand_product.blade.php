@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Update brand product
                        </header>
                        <div class="panel-body">
                             <?php
                                $message = Session::get('messageupdatebrand');
                                if($message){
                                  ?>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      {{$message}}
                                    </div>
                                  <?php
                                  Session::put('messageupdatebrand',null);
                                }
                            ?>
                            @foreach($edit_brand_product as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-brand-product/'.$edit_value->brand_id)}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Brand Name:</label>
                                    <input type="text" value="{{$edit_value->brand_name}}" name="brand_product_name" class="form-control" id="exampleInputEmail1" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Brand description:</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="brand_product_desc" >{{$edit_value->brand_desc}}</textarea>
                                </div>
                               
                                <button type="submit" name="update_brand_product" class="btn btn-info">Update Brand</button>
                                </form>
                            </div>
                            @endforeach

                        </div>
                    </section>

            </div>
@endsection