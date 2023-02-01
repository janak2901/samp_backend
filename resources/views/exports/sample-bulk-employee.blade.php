<table>
    <thead>
        <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Birth Date</th>
            <th>Phone No</th>
            <th>Join Date</th>
            <th>House Number</th>
            <th>Street Address</th>
            <th>Land Mark</th>
            <th>Country</th>
            <th>State</th>
            <th>City</th>
            <th>Zip Code</th>
            @isset($errorMessage)
                @if ($errorMessage)
                    <th>Error Message</th>
                @endif
            @endisset
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $details)
            @isset($errorKey[$key])
                @php
                    $error = explode(',', $errorKey[$key]);
                    $rowNumbers = array_slice($error, 0, count($error) - 1);
                @endphp
            @endisset
            <tr>
                <td style="@isset($rowNumbers) @if (in_array(0, $rowNumbers)) border:5px solid red;  @endif @endisset ">{{ $details[0] }}</td>
                <td style="@isset($rowNumbers) @if (in_array(1, $rowNumbers)) border:5px solid red;  @endif @endisset ">{{ $details[1] }}</td>
                <td style="@isset($rowNumbers) @if (in_array(2, $rowNumbers)) border:5px solid red;  @endif @endisset ">{{ $details[2] }}</td>
                <td style="@isset($rowNumbers) @if (in_array(3, $rowNumbers)) border:5px solid red;  @endif @endisset ">{{ $details[3] }}</td>
                <td style="@isset($rowNumbers) @if (in_array(4, $rowNumbers)) border:5px solid red;  @endif @endisset ">{{ $details[4] }}</td>
                <td style="@isset($rowNumbers) @if (in_array(5, $rowNumbers)) border:5px solid red;  @endif @endisset ">
                    @if ($details[5])
                        {{ date('Y-m-d', strtotime($details[5])) }}
                    @endif
                </td>
                <td style="@isset($rowNumbers) @if (in_array(6, $rowNumbers)) border:5px solid red; @endif @endisset ">{{ $details[6] }}</td>
                <td style="@isset($rowNumbers) @if (in_array(7, $rowNumbers)) border:5px solid red; @endif @endisset ">
                    @if ($details[7])
                        {{ date('Y-m-d', strtotime($details[7])) }}
                    @endif
                </td>
                <td style="@isset($rowNumbers) @if (in_array(8, $rowNumbers)) border:5px solid red; @endif @endisset ">{{ $details[8] }}</td>
                <td style="@isset($rowNumbers) @if (in_array(9, $rowNumbers)) border:5px solid red; @endif @endisset ">{{ $details[9] }}</td>
                <td style="@isset($rowNumbers) @if (in_array(10, $rowNumbers)) border:5px solid red; @endif @endisset ">{{ $details[10] }}</td>
                <td style="@isset($rowNumbers) @if (in_array(11, $rowNumbers)) border:5px solid red; @endif @endisset ">{{ $details[11] }}</td>
                <td style="@isset($rowNumbers) @if (in_array(12, $rowNumbers)) border:5px solid red; @endif @endisset ">{{ $details[12] }}</td>
                <td style="@isset($rowNumbers) @if (in_array(13, $rowNumbers)) border:5px solid red; @endif @endisset ">{{ $details[13] }}</td>
                <td style="@isset($rowNumbers) @if (in_array(14, $rowNumbers)) border:5px solid red; @endif @endisset ">{{ $details[14] }}</td>
                @isset($errorMessage)
                    @isset($errorMessage[$key])
                        @if ($errorMessage[$key])
                            <td style="color: red; width:300px;">{{ $errorMessage[$key] }}</td>
                        @endif
                    @endisset
                @endisset
            </tr>
        @endforeach
    </tbody>
</table>
