<table>
    <thead>
    <tr>
        <th>CO</th>
        <th>Method</th>
        <th>Element</th>
        <th>Quantity</th>
        <th>Date</th>
        <th></th>
    </tr>
    </thead>
    <tbody>   
        <tr>
            <td>{{ $co }}</td>
            <td>{{ $methode }}</td>            
            <td>{{ $element }}</td>
            <td>{{ $quantity }}</td>
            <td>{{ $date }}</td>
            <td></td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Number</th>
        <th>Name</th>
        <th>Satmagan Reading</th>
        <th>GEO-615</th>
        <th>GEO-618</th>
        <th>GEO-644</th>
        <th>Comparative</th>
        

    </tr>
    </thead>
    <tbody>
    @foreach($samples as $key => $sample)
        <tr>
            <td>{{ $key + 1 }}</td>
            {{--<td>{{ $sample->id }}</td>--}}
            <td>{{ number_format($sample->number ,0, ",", ".")}}</td>
            <td>{{ $sample->name }}</td>
            <td>{{ number_format($sample->iron_grade ,3, ",", ".") }}</td>
            <td>{{ number_format($sample->geo615 ,3, ",", ".") }}</td>
            <td>{{ number_format($sample->geo618 ,3, ",", ".") }}</td>
            <td>{{ number_format($sample->geo644 ,3, ",", ".") }}</td>
            <td>
                @if($sample->comparative == 1) true @else false @endif
            </td>
            
        </tr>
    @endforeach
    </tbody>
</table>