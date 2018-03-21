@extends('layouts.charts')
@php
/**Number of currently available printers**/
use App\ChartsHelper;
$chrts = new ChartsHelper();
$thechart = $chrts->createChartPrinterStatus();
@endphp

@section('chart')
    {!! $thechart->dimensions(0,$height)->render() !!}
@endsection
