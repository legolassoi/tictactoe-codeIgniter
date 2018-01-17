<?= $header ?>
<div class="container-fluid">
	<div class="row players top-header"></div>
	<table id="results">
		<thead>
			<tr>
				<th>ID</th>
				<th>Player1 Name</th>
				<th>Player2 Name</th>
				<th>Winner</th>
				<th>Date Played</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>
<script>
$(document).ready(function() {
	$('#results').dataTable( {
        processing: true,
        serverSide: true,
        ajax: {
            "url": "/game/dataTable",
            "type": "POST"
        },
        columns: [
            {data: "c.id"},
            {data : "c.player1_name"},
			{data : "c.player2_name"},
			{data : "$.winner_str", "orderable": false, "searchable": false},
			{data : "$.played_formatted", "orderable": false, "searchable": false},
        ],
		"order": [[ 0, "desc" ]]
    });
	$('body').on('click', '#results tr', function() {
		if (typeof $(this).attr('id') !== 'undefined') {
			location.href='/game/view/'+$(this).attr('id');
		}
	});
});
</script>
</body>
</html>