@extends('layouts.charts')
@php
/**Number of currently available printers**/
use App\StatisticsHelper;
$stats = new StatisticsHelper();
$thechart = $stats->createChartPrinterAvailability();
@endphp

@section('chart')
    {!! $thechart->template('coral-uni')->oneColor(true)->dimensions(0,$height)->render() !!}
@endsection
