@extends('layouts.charts')
@php
/**PRINTS PER YEAR**/
use App\ChartsHelper;
$chrts = new ChartsHelper();
$thechart = $chrts->createChartPrintsLastYears(5,$template);
@endphp

@section('chart')
    {!! $thechart->dimensions(0,$height)->render() !!}
@endsection
