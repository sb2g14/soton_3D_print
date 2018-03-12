@extends('layouts.charts')
@php
/**PRINTS PER MONTH OVER LAST YEARS**/
use App\StatisticsHelper;
$stats = new StatisticsHelper();
$thechart = $stats->createChartPrintsLastYearsPerMonth(5);
@endphp

@section('chart')
    {!! $thechart->dimensions(0,$height)->render() !!}
@endsection
