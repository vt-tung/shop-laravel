@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Update product
                        </header>

                        <div class="panel-body">
                             <?php
                                $message = Session::get('messageupdateproduct');
                                if($message){
                                  ?>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      {{$message}}
                                    </div>
                                  <?php
                                  Session::put('messageupdateproduct',null);
                                }
                            ?>
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-product/'.$edit_product->product_id)}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product name</label>
                                    <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" value="{{$edit_product->product_name}}">
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Category product</label>
                                    <select name="product_cate" class="form-control input-sm m-bot15">
                                        {!! $cate_product !!}
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Brand product</label>
                                      <select name="product_brand" class="form-control input-sm m-bot15">
                                        @foreach($brand_product as $key => $brand)
                                             @if($brand->brand_id==$edit_product->brand_id)
                                            <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                             @else
                                            <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                             @endif
                                        @endforeach
                                            
                                    </select>
                                </div>
                               <div class="form-group">
                                    <label for="exampleInputPassword1">Product description</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="product_desc" id="ckeditor2">{{$edit_product->product_desc}}</textarea>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Product content</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="product_content" id="ckeditor3" >{{$edit_product->product_content}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Price</label>
                                    <input type="number" value="{{$edit_product->product_price}}" name="product_price" class="form-control" id="exampleInputEmail1" >
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Quantity</label>
                                    <input type="number" name="product_qty" class="form-control" id="exampleInputEmail1" value="{{$edit_product->product_qty}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Promotion</label>
                                    <input type="number" name="product_promotion" class="form-control" id="exampleInputEmail1" p  value="{{$edit_product->product_promotion}}" required="">
                                </div> 
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Image product</label>
                                    <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                                    <img src="{{URL::to('public/uploads/product/'.$edit_product->product_image)}}" height="100" width="100">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPassword1">Status</label>
                                      <select name="product_status" class="form-control input-sm m-bot15">
                                            <option value="1">Show</option>
                                            <option value="0">Hide</option>
                                        
                                    </select>
                                </div>
                               
                                <button type="submit" name="add_product" class="btn btn-info">Update product</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection