<table class="table table-bordered">
        <thead>
          <tr>
            <th>№</th>
            <th>Название</th>
            <th>Цена</th>
          </tr>
        </thead>
        <tbody>
          @foreach($bill as $item)
          <tr>
            <th scope="row">{{($loop->index+1)}}</th>
            <td>{{$item->priceable->bill_title}}</td>
            <td>{{price_uah($item->price)}}</td>
          </tr>
          @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2">Итого</td>
          <td>{{price_uah($total_price)}}</td>
        </tr>
      </tfoot>
</table>
