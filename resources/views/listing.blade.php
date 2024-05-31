
<style type="text/css">
    td.weekend{background-color:rgb(212, 199, 25);}
    td.late{background-color:rgb(13, 105, 235);}
    td.absent{background-color:rgb(212, 25, 25);}
 
    </style>
<table border="1">
    <thead>
        <tr>
            <th></th>
            @foreach($days as $day)
                <th>
                    {{ $day['date'] }} <br> ( {{ $day['day']}})
                </th>
            @endforeach
            <th>
                Full day
            </th>
            <th>
                Half day
            </th>
            <th>
                Paid Weekend
            </th>
            <th>
                Deduction
            </th>
            <th>
                Total
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>

                <td>{{ $user->name}}</td>
                @foreach($days as $day)
                    
                    <td class=" {{ $data[$user->name][$day['date']]['cell_color'] }} ">@if(isset($data[$user->name][$day['date']]['in_time'])) {{ substr($data[$user->name][$day['date']]['in_time'],0, strrpos($data[$user->name][$day['date']]['in_time'], ":"))  }} - {{ substr($data[$user->name][$day['date']]['out_time'],0, strrpos($data[$user->name][$day['date']]['out_time'], ":"))  }} @endif </td>
                   
                @endforeach
                <td> {{ $data[$user->name]['full_day']}} </td>
                <td> {{ $data[$user->name]['half_day']}} </td>
                <td> {{ $data[$user->name]['weekend']}} </td>
                <td> {{ $data[$user->name]['deduction']}} </td>  
                <td> {{ $data[$user->name]['total']}} </td> 
            </tr>
        @endforeach
    </tbody>
</table>