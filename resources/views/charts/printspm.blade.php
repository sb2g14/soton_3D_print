@extends('layouts.charts')
@php
/**PRINTS PER MONTH**/
use App\StatisticsHelper;
use App\ChartsHelper;
$chrts = new ChartsHelper();
$stats = new StatisticsHelper();
$count_prints = $stats->getArrayPrintsLastMonths(12);
$count_months = $stats->getArrayLastMonths(12);
$thechart = $chrts->createChartPrintsLastMonths($count_prints,$count_months,$template);
@endphp

@section('chart')
    {!! $thechart->dimensions(0,$height)->render() !!}
@endsection
