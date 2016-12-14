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
        <a href="/?N={{ $count }}&reset=1" class="btn btn-outline-primary btn-lg btn-block">重新遊戲</a>
      </div>
    </div>
    @if (!isset($guessResult) || $guessResult !== $count . 'A0B')
        <br>
        <div class="row">
          <div class="col-lg-6">
            <form action="/" method="POST">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="count" value="{{ $count }}">
              <div class="input-group input-group-lg">
                <input type="number" name="inputNumStr" class="form-control" placeholder="請輸入不重複的數字" autofocus>
                <span class="input-group-btn">
                  <button class="btn btn-secondary" type="submit" data-toggle="tooltip" data-placement="right" title="或按 Enter">GO</button>
                </span>
              </div>
            </form>
          </div>
        </div>
    @endif
    <br>
    @if (isset($inputNumStr))
        <div class="row">
          <div class="col-lg-6">
            @if (isset($checkInputCountErr) || isset($checkSameErr))
                <div class="alert alert-danger" role="alert">
                  請輸入 {{ $count }} 個不重複的數字
            @elseif (isset($checkPastInputErr))
                <div class="alert alert-danger" role="alert">
                  此答案已經輸入過了
            @elseif ($guessResult === $count . 'A0B')
                <div class="alert alert-success" role="alert">
                  {{ $inputNumStr }}：正解
            @else
                <div class="alert alert-danger" role="alert">
                  你輸入的答案是 {{ $inputNumStr }}：{{ $guessResult }}
            @endif
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
            @if (isset($guessHistory))
                {!! nl2br(e($guessHistory)) !!}
            @endif
            <br>
          </p>
        </div>
      </div>
      <div class="col-lg-2">
        <a href="/download" class="btn btn-primary btn-block">下載作答記錄</a>
      </div>
    </div>
    <br>
    <br>
    <br>
    <div class="row">
      <div class="col-lg-2">
        <h5 class="text-muted">
          更改 N 位數<br>
          <small class="text-muted"> N = 1 ~ 10</small>
        </h5>
      </div>
      <div class="col-lg-2">
        <form class="form-group" action="/" method="GET">
          <div class="input-group">
            <input type="number" name="N" class="form-control" value="{{ $count }}" min="1" max="10">
            <span class="input-group-btn">
              <button class="btn btn-secondary" type="submit">GO</button>
            </span>
          </div>
        </form>
      </div>
    </div>
  </div>
@stop
