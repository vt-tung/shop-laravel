    <div class="select-items">
      <table>
          <tbody>
            @foreach($content as $item)
              <tr>
                  <td class="si-pic"><img src="{{URL::to('public/uploads/product/'.$item->options->image)}}" alt=""></td>
                  <td class="si-text">
                      <div class="product-selected">
                          <p>{{number_format($item->price).' '.'VNĐ'}}                                   
 x {{$item->qty}}</p>
                          <h6>{{$item->name}}</h6>
                      </div>
                  </td>
                  <td class="si-close">
                      <i class="washabi-multiply"></i>
                  </td>
              </tr>
             @endforeach
          </tbody>
      </table>
    </div>
    <div class="select-total">
      <span>total:</span>
    </div>