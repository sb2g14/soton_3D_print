@extends('layouts.charts')
@php
/**PRINTS PER YEAR**/
use App\StatisticsHelper;
$stats = new StatisticsHelper();
$thechart = $stats->createChartPrintsLastYears(5);
@endphp

@section('chart')
    {!! $thechart->dimensions(0,$height)->render() !!}
@endsection
