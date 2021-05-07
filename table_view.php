<h1></h1>
<style>
	th,td{
		padding:5px;
		border-right:1px solid gray;
		text-align: center;
	}
	
	tr:nth-child(even){
		background-color:lightgray;
	}
	

	
	h3{
		text-align: center;
	}
</style>

<div class="card">
	<div class="card-body">
	<div classs="card-title">
		<h3>Artifacts</h3>
	</div>
	<div class="table-responsive">
	<table id="zero-table" style=""
	class="table table-striped table-bordered"
	>
	<thead>
		<th>Art Number</th><th>Name</th><th>Snipet</th>
		<th>Edit</th>
	</thead>
		<?php foreach ($arts as $art): ?>
			<tr>
				<td><?php echo $art['id'];?></td>
				<td><?php echo $art['name'];?></td>
				<td><?php echo $art['short_description'];?></td>
				<td>
					<a href="<?php echo site_url('art/edit/'.$art['id']); ?>" >
					Edit</a>
				</td>
				
			</tr>
		
		<?php endforeach; ?>
		
		
	
	
</table>
	</div>	
		
		<div style="width:200px;margin:auto;
		margin-top:20px" class="">
			<a href="
			<?php echo site_url('art/edit'); ?>
			"
			class="btn btn-primary"
			> Add New Artifact
			</a>
		</div>

</div>
</div>

