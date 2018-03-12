@extends('layouts.charts')
@php
/**USERS PER YEAR**/
use App\StatisticsHelper;
$stats = new StatisticsHelper();
$thechart = $stats->createChartUsersLastYears();
@endphp

@section('chart')
    {!! $thechart->dimensions(0,$height)->render() !!}
@endsection
