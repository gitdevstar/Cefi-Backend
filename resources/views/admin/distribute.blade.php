@extends('admin.layout.base')

@section('title', 'Distribution ')



@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            @if(Setting::get('demo_mode') == 1)
        <div class="col-md-12" style="height:50px;color:red;">
                    ** Demo Mode : No Permission to Edit and Delete.
                </div>
                @endif
            <h5 class="mb-1">
              <div class="col-md-12" style="height:50px;color:red;">
                Balance: {{ $balance }}
                <br>
                Select the users, quantity and coin to send. <button id="radiosBtn">Toggle Select all</button></div>
                @if(Setting::get('demo_mode', 0) == 1)
                <span class="pull-right">(*personal information hidden in demo)</span>
                @endif
                <br>
                <small>If sending 1000 to 100 users, every users gets 10.</small>
            </h5>

            <form action="{{ route('admin.distribute_send') }}" method="POST">
              {{csrf_field()}}
              <input type="radio" name="sendToAll" id="sendToAll" value="yes" style="display:none" />
              <div class="form-group row">
                <div class="col-xs-10">
                  <button type="submit" class="btn btn-primary">Send</button>
                </div>
              </div>
              <div class="form-group row">
      					<label for="market" class="col-xs-12 col-form-label">Amount to send:</label>
      					<div class="col-xs-10">
      						<input class="form-control" type="text" value="1" name="amount" required id="amount">
      					</div>
      				</div>

              <div class="form-group row">
      					<label for="coin" class="col-xs-12 col-form-label">Coin</label>
      					<div class="col-xs-10">
      						<select class="form-control" name="coin" required id="coin">
                    <option value="0">Wyretoken (XMT)</option>
                    <!--
                    @foreach($coins as $index => $coin)
                      <option value="{{ $coin->id }}">{{ $coin->coin_name }} ({{ $coin->coin_symbol }})</option>
                    @endforeach
                    -->
                  </select>
      					</div>
      				</div>

              <table class="table table-striped table-bordered dataTable" id="table-2">
                  <thead>
                      <tr>
                          <th>Select</th>
                          <th>ID</th>
                          <th>Name</th>
  						            <th>Email</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach($users as $index => $user)
                      <tr>
                          <td><input type="checkbox" id="users" name="users[]" value="{{ $user->id }}" /></td>
                          <td>{{ $user->id }}</td>
                          <td>{{ $user->first_name.' '.$user->last_name }}</td>
                          <td>{{ $user->email }}</td>
                      </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                      <tr>
                          <th>Select</th>
                          <th>Name</th>
  						            <th>Email</th>
                      </tr>
                  </tfoot>
              </table>
              <div class="form-group row">
      					<div class="col-xs-10">
      						<button type="submit" class="btn btn-primary">Send</button>
      					</div>
      				</div>
            </form>

            </div>
            <div class="box box-block bg-white">


            <h2>History</h2>
            <table class="table table-striped table-bordered dataTable" id="table-2">
                <thead>
                    <tr>
                        <th>Coin</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($dists as $index => $dist)
                    <tr>
                        <td>{{ $dist['coin'] }}</td>
                        <td>{{ $dist['user'] }}</td>
                        <td>{{ $dist['amount'] }}</td>
                        <td>{{ $dist['created_at'] }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Coin</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Time</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  var checkedCB = false;
  function toggleCheckbox() {
    checkedCB = checkedCB ? false : true;
    $("#table-2 input:checkbox").prop('checked', checkedCB);
    if (checkedCB) {
      $("#sendToAll").prop( "checked", true );
    } else {
      $("#sendToAll").prop( "checked", false );
    }
  }
  setTimeout(function() {
    $( document ).ready(function() {
      $("#radiosBtn").click(toggleCheckbox);
      $(".dt-buttons.btn-group").hide();
    });
  },2000);
</script>
@endsection
