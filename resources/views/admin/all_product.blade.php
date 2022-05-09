@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        List of product
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn b tn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
       <?php
          $message = Session::get('messageProuduct');
          if($message){
            ?>
              <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{$message}}
              </div>
            <?php
            Session::put('messageProuduct',null);
          }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              No.
            </th>
            <th >Product name</th>
            <th>Sold</th>
            <th>Image</th>
            <th>Color</th>
            <th>Size</th>
            <th>Status</th>
            
          </tr>
        </thead>

        <tbody>
          @foreach($all_product as $key => $pro)
          <tr>
            <td>{{$key+ $all_product->firstItem()}}</td>
            <td>
              <div>{{ $pro->product_name }}</div>
              <ul style="margin-left: 15px;" class="cl-content-product">
                <li>Import price: {{ number_format($pro->product_import_price,0,',','.')  }} VNĐ</li>
                <li>Price: {{ number_format($pro->product_price,0,',','.')  }} VNĐ</li>
                <li>Promotion: {{ $pro->product_promotion  }} (%)</li>
                <li>Quantity: {{ $pro->product_qty  }}</li>
                <li>Category: {{ $pro->category_name  }}</li>
                <li>Brand: {{ $pro->brand_name  }}</li>
                <li>Views: {{ $pro->product_views  }}</li>
                <li>
                  <?php
                    $age = 0;
                    if($pro->product_total_rating>0){
                      $age = round($pro->product_total_rating/$pro->product_number_rating, 1, PHP_ROUND_HALF_DOWN);
                    } 
                  ?>
                  <a href="{{URL::to('/view-rating/'.$pro->product_id)}}">
                      <span>Rating: ({{$age}})</span>
                      <ul class="cl-star_rating_admin">
                          @for($i=1; $i<=5; $i++)
                                <li title="star_rating" class="rating lish_star {{$i <= $age ? 'active' : ''}}" style="cursor:pointer; color:#ccc; ">
                                  <span class="fa" >&#9733;</span>
                                </li>
                          @endfor
                      </ul>
                      <span> 
                     | {{$pro->product_number_rating}} review
                      </span>
                  </a>
                </li>
              </ul>

            </td>
            <td>{{ $pro->product_sold  }}</td>
            <td><img src="public/uploads/product/{{ $pro->product_image }}"  width="50"><br/><a href="{{URL::to('/add-gallery/'.$pro->product_id)}}">Add Gallery</a></td>
            <td><a href="{{URL::to('/add-color/'.$pro->product_id)}}">Add Color</a></td>
            <td><a href="{{URL::to('/add-size/'.$pro->product_id)}}">Add Size</a></td>
            <td><span class="text-ellipsis">
              <?php
               if($pro->product_status==1){
                ?>
                  <a href="{{URL::to('/active-product/'.$pro->product_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                <?php
                 }else{
                ?>  
                 <a href="{{URL::to('/unactive-product/'.$pro->product_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                <?php
               }
              ?>
            </span></td>
           
            <td>
              <a href="{{URL::to('/edit-product/'.$pro->product_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Are you sure?')" href="{{URL::to('/delete-product/'.$pro->product_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-left">
          <small>Showing item {{$all_product->firstItem()}} to {{$all_product->lastItem()}} of {{$all_product->total()}} results</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
            {!! $all_product->links() !!}
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection