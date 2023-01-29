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
            <td>{{ number_format($sample->number ,3, ",", ".")}}</td>
            <td>{{ $sample->name }}</td>
            <td>{{ number_format($sample->absorbance ,3, ",", ".") }}</td>
            <td>{{ number_format($sample->weight ,3, ",", ".") }}</td>
            <td>{{ number_format($sample->aliquot ,3, ",", ".") }}</td>
            <td>{{ number_format($sample->colorimetric_factor ,3, ",", ".") }}</td>
            <td>{{ number_format($sample->dilution_factor ,3, ",", ".") }}</td>
            <td>{{ number_format($sample->phosphorous ,3, ",", ".") }}</td>
        </tr>
    @endforeach
    </tbody>
</table>