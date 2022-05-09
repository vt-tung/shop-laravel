@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Add Slider
                        </header>
                         <?php
                            $message = Session::get('messageslider');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('messageslider',null);
                            }
                            ?>
                        <div class="panel-body">

                            <div class="position-center">
                                <form role="form" action="{{URL::to('/insert-slider')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name slide</label>
                                    <input type="text" name="slider_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Image</label>
                                    <input type="file" name="slider_image" class="form-control" id="exampleInputEmail1" placeholder="Slide" required="">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Status</label>
                                      <select name="slider_status" class="form-control input-sm m-bot15">
                                           <option value="1">Show</option>
                                            <option value="0">Hide</option>
                                            
                                    </select>
                                </div>
                               
                                <button type="submit" name="add_slider" class="btn btn-info">INSERT</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection