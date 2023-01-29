<table>
    <thead>
    <tr>
        <th>CO</th>
        <th>Method</th>
        <th>Quantity</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>   
        <tr>
            <td>{{ $co }}</td>            
            <td>{{ $method }}</td>
            <td>{{ $quantity }}</td>
            <td>{{ $date }}</td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Number</th>
        <th>Name</th>
        <th>Absorbance</th>
        <th>Weigth</th>
        <th>Aliquot</th>
        <th>Colorimetric Factor</th>
        <th>Dilution Factor</th>
        <th>Phosphorous %</th>

    </tr>
    </thead>
    <tbody>
    @foreach($samples as $key => $sample)
        <tr>
            <td>{{ $key + 1 }}</td>
            {{--<td>{{ $sample->id }}</td>--}}
            <td>{{ $sample->number }}</td>
            <td>{{ $sample->name }}</td>
            <td>{{ $sample->absorbance }}</td>
            <td>{{ $sample->weight }}</td>
            <td>{{ $sample->aliquot }}</td>
            <td>{{ $sample->colorimetric_factor }}</td>
            <td>{{ $sample->dilution_factor }}</td>
            <td>{{ $sample->phosphorous }}</td>
        </tr>
    @endforeach
    </tbody>
</table>