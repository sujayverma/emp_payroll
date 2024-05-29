{{-- {{ dd($users->attend) }} --}}
<style type="text/css">
    td.weekend{background-color:rgb(212, 199, 25);}
    /* tr.even{background-color:#fcf;}
    table tr td:first-of-type {background-color: purple !important;} */
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
                    @if($day['day']=='Sun' || $day['day']=='Sat')
                    <td class='weekend'>
                        {{ $day['date'] }} 
                    </td>
                    @else
                    <td >
                        @if($user->attend)
                            @foreach($user->attend as $att)
                                @if(date('j',strtotime($att->attend_date)) == $day['date'])
                                  {{ substr($att->in_time,0, strrpos($att->in_time, ":"))  }} - {{ substr($att->in_time,0, strrpos($att->out_time, ":"))  }}
                                @endif
                            @endforeach
                        @endif 
                    </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>