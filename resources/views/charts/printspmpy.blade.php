@extends('layouts.charts')
@php
/**PRINTS PER MONTH OVER LAST YEARS**/
use App\ChartsHelper;
$chrts = new ChartsHelper();
$thechart = $chrts->createChartPrintsLastYearsPerMonth(5,$template);
@endphp

@section('chart')
    {!! $thechart->dimensions(0,$height)->render() !!}
@endsection
