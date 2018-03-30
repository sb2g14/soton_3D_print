@extends('layouts.charts')
@php
/**number of successful prints over total prints per printer type**/
use App\ChartsHelper;
$chrts = new ChartsHelper();
$thechart = $chrts->createChartReliabilityPerPrinterType($template);
@endphp

@section('chart')
    {!! $thechart->title('Reliability of Printers in %')->dimensions(0,$height)->render() !!}
@endsection
