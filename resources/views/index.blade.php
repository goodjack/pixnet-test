@extends('layout')

@section('title', 'PIXNET')

@section('content')
  <div class="container">
    <br>
    <div class="row">
      <div class="col-lg-6">
        <h1>
          猜數字
          <small class="text-muted">
            答案提示：1234
            @foreach ($numSet as $num)
            <div>
              {{ $num }}
            </div>
            @endforeach
          </small>
        </h1>
      </div>
      <div class="col-lg-2">
        <button type="button" class="btn btn-outline-primary btn-lg btn-block">重新遊戲</button>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-6">
        <div class="input-group input-group-lg">
          <input type="text" class="form-control" placeholder="請輸入不重複的數字">
          <span class="input-group-btn">
            <button class="btn btn-secondary" type="button">GO</button>
          </span>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-6">
        <div class="alert alert-danger" role="alert">
          你輸入的答案是 5678: 0A0B
        </div>
      </div>
    </div>
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
