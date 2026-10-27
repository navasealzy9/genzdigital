@extends('layouts.app')
@section('learning-workspace', '1')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/campus-learning.css') }}?v={{ filemtime(public_path('css/campus-learning.css')) }}">
<link rel="stylesheet" href="{{ asset('css/campus-restore.css') }}?v={{ filemtime(public_path('css/campus-restore.css')) }}">
@endsection
