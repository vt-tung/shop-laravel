@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Add product
                        </header>

                        <div class="panel-body">
                             <?php
                                $message = Session::get('messageaddproduct');
                                if($message){
                                  ?>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      {{$message}}
                                    </div>
                                  <?php
                                  Session::put('messageaddproduct',null);
                                }
                            ?>
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-product')}}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Name:</label>
                                    <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục" required="">
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Category product:</label>
                                    <select name="product_cate" class="form-control input-sm m-bot15" required=""> 
                                        {!! $cate_product !!}
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Brand product:</label>
                                      <select name="product_brand" class="form-control input-sm m-bot15" required="">
                                        @foreach($brand_product as $key => $brand)
                                            <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @endforeach
                                            
                                    </select>
                                </div>

                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Product description:</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="product_desc" id="ckeditor" placeholder="Product description..." required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Product summary:</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="product_content" id="ckeditor1" placeholder="Product summary..." required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Import price:</label>
                                    <input type="number" name="product_import_price" class="form-control" id="exampleInputEmail1" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Price:</label>
                                    <input type="number" name="product_price" class="form-control" id="exampleInputEmail1" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Quantity:</label>
                                    <input type="number" name="product_qty" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Promotion:</label>
                                    <input type="number" name="product_promotion" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục" required="" value="0" min="0" max="100">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product image:</label>
                                    <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Add gallery:</label>
                                    <input type="file" class="form-control" id="file" name="file[]" accept="image/*" multiple>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Status:</label>
                                      <select name="product_status" class="form-control input-sm m-bot15" required="">
                                            <option value="1">Show</option>
                                            <option value="0">hide</option>
                                            
                                    </select>
                                </div>
                               
                                <button type="submit" name="add_product" class="btn btn-info">Add product</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection