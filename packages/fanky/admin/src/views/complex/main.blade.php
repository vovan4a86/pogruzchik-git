@extends('admin::template')

@section('scripts')
	<script type="text/javascript" src="/adminlte/interface_news.js"></script>
@stop

@section('page_name')
	<h1>Комплексные решения
		<small><a href="{{ route('admin.complex.edit') }}">Добавить комплексное решение</a></small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Комплексные решения</li>
	</ol>
@stop

@section('content')
	<div class="box box-solid">
		<div class="box-body">
			@if (count($complex))
				<table class="table table-striped">
					<thead>
					<tr>
						<th width="100">Дата</th>
						<th width="100">Изображение</th>
						<th>Название</th>
						<th width="50"></th>
					</tr>
					</thead>
					<tbody>
					@foreach ($complex as $item)
						<tr>
							<td>{{ $item->dateFormat() }}</td>
							<td style="text-align: center;">
								@if($item->image)
									<img src="{{ $item->thumb(1) }}" alt="{{ $item->name }}"></td>
							@else
								<img src="{{ \Fanky\Admin\Models\Complex::NO_IMAGE }}" alt="Не загружено"
									 title="Не загружено" width="50" height="50"></td>
							@endif
							<td><a href="{{ route('admin.complex.edit', [$item->id]) }}">{{ $item->name }}</a></td>
							<td>
								<a class="glyphicon glyphicon-trash"
								   href="{{ route('admin.complex.delete', [$item->id]) }}"
								   style="font-size:20px; color:red;" title="Удалить"
								   onclick="return newsDel(this)"></a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
				{!! $complex->render() !!}
			@else
				<p>Нет комплексных решений!</p>
			@endif
		</div>
	</div>
@stop