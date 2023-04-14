@extends('admin::template')

@section('scripts')
    <script type="text/javascript" src="/adminlte/interface_orders.js"></script>
@stop

@section('page_name')
    <h1>Заказы</h1>
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Заказы</li>
    </ol>
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
            @if (count($orders))
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th width="150">Дата заказа</th>
                        <th>Доставка</th>
                        <th>Сумма</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Телефон</th>
                        <th>Компания</th>
                        <th>Город</th>
                        <th>Индекс</th>
                        <th>Улица</th>
                        <th>Дом</th>
                        <th>Квартира</th>
                        <th width="50"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $item)
                        <tr>
                            <td>{{ $item->dateFormat() }} @if($item->new)<span class="label label-danger">NEW</span>@endif</td>
                            <td><a href="{{ route('admin.orders.view', [$item->id]) }}">{{ $item->delivery == 1 ? 'Да' : 'Нет' }}</a></td>
                            <td><a href="{{ route('admin.orders.view', [$item->id]) }}">{{ $item->summ }}</a></td>
                            <td><a href="{{ route('admin.orders.view', [$item->id]) }}">{{ $item->name }}</a></td>
                            <td><a href="{{ route('admin.orders.view', [$item->id]) }}">{{ $item->email }}</a></td>
                            <td><a href="{{ route('admin.orders.view', [$item->id]) }}">{{ $item->phone }}</a></td>
                            <td><a href="{{ route('admin.orders.view', [$item->id]) }}">{{ $item->company }}</a></td>
                            <td><a href="{{ route('admin.orders.view', [$item->id]) }}">{{ $item->city }}</a></td>
                            <td><a href="{{ route('admin.orders.view', [$item->id]) }}">{{ $item->code }}</a></td>
                            <td><a href="{{ route('admin.orders.view', [$item->id]) }}">{{ $item->street }}</a></td>
                            <td><a href="{{ route('admin.orders.view', [$item->id]) }}">{{ $item->home_number }}</a></td>
                            <td><a href="{{ route('admin.orders.view', [$item->id]) }}">{{ $item->apartment_number }}</a></td>
                            <td>
                                <a class="glyphicon glyphicon-trash" href="{{ route('admin.orders.del', [$item->id]) }}" style="font-size:20px; color:red;" title="Удалить" onclick="return orderDel(this)"></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $orders->render() !!}
            @else
                <p>Нет заказов!</p>
            @endif
        </div>
    </div>
@stop
