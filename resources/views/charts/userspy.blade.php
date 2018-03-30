@extends('layouts.charts')
@php
/**USERS PER YEAR**/
use App\ChartsHelper;
$chrts = new ChartsHelper();
$thechart = $chrts->createChartUsersLastYears($template);
@endphp

@section('chart')
    {!! $thechart->dimensions(0,$height)->render() !!}
@endsection
