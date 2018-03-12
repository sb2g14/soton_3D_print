@extends('layouts.charts')
@php
/**Workshop Busy Periods**/
use App\StatisticsHelper;
$stats = new StatisticsHelper();
$thechart = $stats->createChartWorkshopUsage();
@endphp

@section('chart')
    {!! $thechart->title('Average number of simultaneous prints')
            ->template('coral-uni')
            ->oneColor(true)
            ->dimensions(0,$height)
            ->render() !!}
@endsection
