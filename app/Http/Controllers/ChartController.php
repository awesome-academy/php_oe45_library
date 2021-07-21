<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $chart_options = [
                'chart_title' => 'Borrow Requests By Weeks',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Borrow',
                'group_by_field' => 'created_at',
                'group_by_period' => 'day',
                'chart_type' => 'bar',
                'filter_field' => 'created_at',
                'filter_days' => 7,
            ];
            $chartDay = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Borrow Requests By Months',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Borrow',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'chart_type' => 'bar',
            ];
            $chartMonth = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Borrow Requests By Years',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Borrow',
                'group_by_field' => 'created_at',
                'group_by_period' => 'year',
                'chart_type' => 'bar',
            ];
            $chartYear = new LaravelChart($chart_options);

            return view('admin.charts.index', compact('chartDay', 'chartMonth', 'chartYear'));
        } catch (ModelNotFoundException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
