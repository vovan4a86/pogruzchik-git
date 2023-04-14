@extends('admin::template')

@section('scripts')
	<script type="text/javascript" src="/adminlte/interface_delivery.js"></script>
@stop

@section('page_name')
	<h1>Способы оплаты
		<small><a href="{{ route('admin.payment.edit') }}">Добавить способ оплаты</a></small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Главная</a></li>
		<li class="active">Способы доставки</li>
	</ol>
@stop

@section('content')
	<div class="box box-solid">
		<div class="box-body">
			@if (count($items))
				<table class="table table-striped">
					<thead>
						<tr>
							<th width="200">Название</th>
							<th>Описание</th>
							<th width="120">Сортировка</th>
							<th width="50"></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($items as $item)
							<tr>
								<td><a href="{{ route('admin.payment.edit', [$item->id]) }}">{{ $item->name }}</a></td>
								<td><a href="{{ route('admin.payment.edit', [$item->id]) }}">{{ $item->description }}</a></td>
								<td>
									<form class="input-group input-group-sm"
										  action="{{ route('admin.payment.update-order', [$item->id]) }}"
										  onsubmit="updateOrder(this, event)">
										<input type="number" name="order" class="form-control" step="1" value="{{ $item->order }}">
										<span class="input-group-btn">
											<button class="btn btn-success btn-flat" type="submit">
											   <span class="glyphicon glyphicon-ok"></span>
											</button>
										</span>
									</form>
								</td>
								<td>
									<a class="glyphicon glyphicon-trash" href="{{ route('admin.payment.delete', [$item->id]) }}"
									   style="font-size:20px; color:red;" title="Удалить" onclick="return deliveryItemDel(this)"></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
{{--                {!! $items->render() !!}--}}
			@else
				<p>Не добавлено ни одного способа оплаты!</p>
			@endif
		</div>
	</div>
@stop
