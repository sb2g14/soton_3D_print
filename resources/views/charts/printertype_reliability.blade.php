@extends('layouts.charts')
@php
/**number of successful prints over total prints per printer type**/
use App\StatisticsHelper;
$stats = new StatisticsHelper();
$thechart = $stats->createChartReliabilityPerPrinterType();
@endphp

@section('chart')
    {!! $thechart->title('Reliability of Printers in %')->template('shamrock-uni')->oneColor(false)->dimensions(0,$height)->render() !!}
@endsection
