@extends('layouts.charts')
@php
/**PRINTS PER MONTH**/
use App\StatisticsHelper;
$stats = new StatisticsHelper();
$count_prints = $stats->getArrayPrintsLastMonths(12);
$count_months = $stats->getArrayLastMonths(12);
$thechart = $stats->createChartPrintsLastMonths($count_prints,$count_months);
@endphp

@section('chart')
    {!! $thechart->template('prussian-uni')->dimensions(0,$height)->render() !!}
@endsection
