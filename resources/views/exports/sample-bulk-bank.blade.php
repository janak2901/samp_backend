<table>
	<thead>
	<tr>
        <th>Email</th>
		<th>Bank Name</th>
		<th>Account Number</th>
		<th>Account Type</th>
		<th>Branch Address</th>
		<th>IFSC Code</th>
	</tr>
	</thead>
	<tbody>
	@foreach($data as $details)
		<tr>
			<td>{{$details[0]}}</td>
			<td>{{$details[1]}}</td>
			<td>{{$details[2]}}</td>
			<td>{{$details[3]}}</td>
			<td>{{$details[4]}}</td>
			<td>{{$details[5]}}</td>
		</tr>
	@endforeach
	</tbody>
</table>
