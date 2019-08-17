@extends('layouts.app')

@section('content')
  <div id="app">
    {{-- デフォルトだとこの中ではvue.jsが有効 --}}
    {{-- example-componentはLaraveln入っているサンプルのコンポートネント --}}
  <example-component title="{{ __('Practice').'「'.$drill->title.'」' }}" :drill="{{$drill}}" category-name="{{ $drill->category_name }}"></example-component>
  </div>
@endsection
