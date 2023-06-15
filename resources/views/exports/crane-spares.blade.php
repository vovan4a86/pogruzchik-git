<table>
    <thead>
    <tr>
        <th>1й уровень</th>
        <th>2й уровень</th>
        <th>3й уровень</th>
        <th>Артикул</th>
        <th>Название</th>
        <th>Наличие</th>
        <th>Города</th>
        <th>Цена</th>
        <th>Аналоги</th>
        <th>Бренд</th>
        <th>Распродажа</th>
        <th>Новинка</th>
        <th>Двигатели</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td>{{$item->cat_root}}</td>
            <td>{{$item->cat_child}}</td>
            <td>{{$item->cat_translate}}</td>
            <td>{{$item->articul}}</td>
            <td>{{$item->translate}}</td>
            <td>1</td>
            <td></td>
            <td></td>
            <td></td>
            <td>Crane Spares</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
