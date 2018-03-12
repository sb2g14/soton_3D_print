@extends('layouts.charts')
@php
/**Number of currently available printers**/
use App\StatisticsHelper;
$stats = new StatisticsHelper();
$thechart = $stats->createChartPrinterStatus();
@endphp

@section('chart')
    {!! $thechart->template('uni')->oneColor(false)->dimensions(0,$height)->render() !!}
@endsection
