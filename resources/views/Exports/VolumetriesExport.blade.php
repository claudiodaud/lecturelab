<table>
    <thead>
    <tr>
        <th>CO</th>
        <th>Method</th>
        <th>Quantity</th>
        <th>Date</th>
        <th></th>
    </tr>
    </thead>
    <tbody>   
        <tr>
            <td>{{ $co }}</td>            
            <td>{{ $method }}</td>
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
        
        <th>Weigth</th>
        <th>Spent</th>
        <th>Title</th>
        <th>Grade</th>
        

    </tr>
    </thead>
    <tbody>
    @foreach($samples as $key => $sample)
        <tr>
            <td>{{ $key + 1 }}</td>
            {{--<td>{{ $sample->id }}</td>--}}
            <td>{{ number_format($sample->number ,3, ",", ".")}}</td>
            <td>{{ $sample->name }}</td>
            
            <td>{{ number_format($sample->weight ,3, ",", ".") }}</td>
            <td>{{ number_format($sample->spent ,3, ",", ".") }}</td>
            <td>{{ number_format($sample->title ,8, ",", ".") }}</td>
            
            <td>{{ number_format($sample->grade ,3, ",", ".") }}</td>
        </tr>
    @endforeach
    </tbody>
</table>