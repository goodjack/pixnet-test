@extends('layout')

@section('title', 'PIXNET')

@section('content')
  <div class="container">
    <br>
    <div class="row">
      <div class="col-lg-6">
        <h1 class="text-primary">
          猜數字
          <small class="text-muted">
            答案提示：{{ $numSetStr }}
          </small>
        </h1>
      </div>
      <div class="col-lg-2">
        <a href="/?reset=1" class="btn btn-outline-primary btn-lg btn-block">重新遊戲</a>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-6">
        <form action="/" method="POST">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="input-group input-group-lg">
            <input type="text" name="inputNumStr" class="form-control" placeholder="請輸入不重複的數字" autofocus>
            <span class="input-group-btn">
              <button class="btn btn-secondary" type="submit" data-toggle="tooltip" data-placement="right" title="或按 Enter">GO</button>
            </span>
          </div>
        </form>
      </div>
    </div>
    <br>
    @if(isset($inputNum))
    <div class="row">
      <div class="col-lg-6">
        <div class="alert alert-danger" role="alert">
          你輸入的答案是 {{ $inputNum }}: {{ $guessResult }}
        </div>
      </div>
    </div>
    @endif
    <br>
    <div class="row">
      <div class="col-lg-6">
        <div class="card card-block">
          <h4 class="card-title">作答記錄</h4>
          <p class="card-text">
            5678: 0A0B<br>
            3214: 1A3B<br>
            2134: 2A2B<br>
            1234: 正解
          </p>
        </div>
      </div>
      <div class="col-lg-2">
        <button type="button" class="btn btn-primary btn-block">下載作答記錄</button>
      </div>
    </div>

  </div>
@stop
