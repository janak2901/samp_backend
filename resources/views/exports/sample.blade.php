<table>
    <thead>
        <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Birth Date</th>
            <th>Email</th>
            <th>Join Date</th>
            <th>Phone No</th>
            <th>Bank Name</th>
            <th>Account Number</th>
            <th>Account Type</th>
            <th>Branch Address</th>
            <th>IFSC Code</th>
            <th>Pan Number</th>
            <th>Aadhar Number</th>
            <th>UAN Number</th>
            <th>Esic Number</th>
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
                <td style="@isset($rowNumbers) @if (in_array(4, $rowNumbers)) border:5px solid red;  @endif @endisset ">
                    @if ($details[4])
                        {{ date('Y-m-d', strtotime($details[4])) }}
                    @endif
                </td>
                <td style="@isset($rowNumbers) @if (in_array(5, $rowNumbers)) border:5px solid red;  @endif @endisset ">{{ $details[5] }}</td>
                <td style="@isset($rowNumbers) @if (in_array(6, $rowNumbers)) border:5px solid red; @endif @endisset ">
                    @if ($details[6])
                        {{ date('Y-m-d', strtotime($details[6])) }}
                    @endif
                </td>
                <td style="@isset($rowNumbers) @if (in_array(7, $rowNumbers)) border:5px solid red; @endif @endisset ">{{ $details[7] }}</td>

                <td>{{ $details[8] }}</td>
                <td>{{ $details[9] }}</td>
                <td>{{ $details[10] }}</td>
                <td>{{ $details[11] }}</td>
                <td>{{ $details[12] }}</td>
                <td>{{ $details[13] }}</td>
                <td>{{ $details[14] }}</td>
                <td>{{ $details[15] }}</td>
                <td>{{ $details[16] }}</td>
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
