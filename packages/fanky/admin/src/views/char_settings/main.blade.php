@extends('admin::template')

@section('scripts')
	<script type="text/javascript" src="/adminlte/interface_char_sets.js"></script>
@stop

@section('page_name')
	<h1>Обратная связь</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i>Главная</a></li>
		<li class="active">Характеристики товаров</li>
	</ol>
@stop

@section('content')
	<div class="box box-solid">
		<div class="box-body">
			@if (count($chars))
				<form id="feedbacks-form">
					<table class="table table-striped table-v-middle">
						<tr>
							<th width="130">Название</th>
							<th width="50"></th>
						</tr>
						@foreach ($chars as $item)
							<tr>
								<td><a href="{{ route('admin.char_settings.edit', [$item->id]) }}">{{ $item->name }}</a></td>
								<td>
									<a class="glyphicon glyphicon-trash" href="{{ route('admin.char_settings.del', [$item->id]) }}"
									   style="font-size:20px; color:red;" onclick="charDel(this, event)"></a>
								</td>
							</tr>
						@endforeach
					</table>
				</form>
				{!! Pagination::render('admin::pagination') !!}
			@else
				<p class="text-yellow">Нет характеристик!</p>
			@endif
		</div>
	</div>
@stop
