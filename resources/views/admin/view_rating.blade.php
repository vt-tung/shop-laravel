@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Lish rating
    </div>
    <div id="notify_comment"></div>
    <form class="table-responsive">
      @csrf
      <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert">'.$message.'</span>';
                Session::put('message',null);
            }
      ?>
      <table class="table table-striped b-t b-light" id="myTable">
        <thead>
          <tr>
            <th>No.</th>
            <th>Status</th>
            <th>Commenter's name</th>
            <th>Comment content</th>
            <th>Sent date</th>
            <th>Product</th>
            <th>Manage</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @if(count($comment))
            @foreach($comment as $key => $comm)
            <tr>
              <td>{{$key+ $comment->firstItem()}}</td>
              <td>
                @if($comm->comment_status==1)
                  <input type="button" data-comment_status="0" data-comment_id="{{$comm->id_comment }}" id="{{$comm->comment_product_id}}" class="btn btn-primary btn-xs comment_duyet_btn" value="Show" >
                @else 
                  <input type="button" data-comment_status="1" data-comment_id="{{$comm->id_comment }}" id="{{$comm->comment_product_id}}" class="btn btn-danger btn-xs comment_duyet_btn" value="Hide" >
                @endif
              
              </td>
              <td>{{ $comm->comment_name }}</td>

              <td>{{ $comm->comment }}
                <style type="text/css">
                  ul.list_rep li {
                    list-style-type: decimal;
                    color: blue;
                    margin: 5px 40px;
                }
                </style>
                <ul class="list_rep">
                  Trả lời : 
                  @foreach($comment_rep as $key => $comm_reply)
                    @if($comm_reply->comment_parent_comment==$comm->id_comment)
                      <li> {{$comm_reply->comment}}</li>
                    @endif
                  @endforeach

                </ul>
                @if($comm->comment_status==0)
                <br/><textarea class="form-control reply_comment_{{$comm->id_comment}}" rows="5"></textarea>
                <br/><button type="button" class="btn btn-default btn-xs btn-reply-comment" data-product_id="{{$comm->comment_product_id}}"  data-comment_id="{{$comm->id_comment}}">Reply comment</button>
                
                @endif
               

              </td>
              <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$comm->comment_date)->format('H:i:s d/m/Y')}}</td>
              <td><a href="{{url('/detail-product/'.$comm->product->product_id)}}" target="_blank">{{$comm->product->product_name }}</a></td>
              <td>
                <a href="" class="active styling-edit" ui-toggle-class="">
                  <i class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a onclick="return confirm('Are you sure')" href="" class="active styling-edit" ui-toggle-class="">
                  <i class="fa fa-times text-danger text"></i>
                </a>
              </td>
            </tr>
            @endforeach
          @else
            <tr>
              <td colspan="7" class="text-center">
                There are no reviews yet
              </td>
            </tr>
          @endif

        </tbody>
      </table>
    </form>
  
  </div>
</div>
@endsection