

<style>

</style>

<div class="card">
<div class="card-body">
<div class="card-title">

	<h3> Artifact Editor	</h3>
</div>

<div class="">

	<?php if(isset($error)): ?>
		<div class="alert alert-danger">

			<?php echo $error; ?>
		</div>
	
	<?php endif; ?>
	
	<div class="form-group m-t-20">
                                    
		<?php $art_string = isset($art_id)? '/'.$art_id.'?' : ''; ?>

		<?php echo form_open_multipart('art/edit'.$art_string,
		['id'=>'form-form']); ?>
	
	</div> 
	

	<div class="form-group m-t-20">
	
		<label for="name"> NAME</label>

		<input class="form-control" type="input" name="name" value="<?php echo set_value('name', isset($art)? $art['name']: ""); ?>" />
	</div> 


	<div class="form-group m-t-20">
	
		<label for="name"> SHORT DESCRIPTION</label>

		<input class="form-control" type="input" name="short_description" value="<?php echo set_value('short_description', isset($art)? $art['short_description']: ""); ?>" />
	</div> 


	<div class="form-group m-t-20">
	
		<label for="description">DESCRIPTION</label>

		<textarea type="input" class="form-control" name="description" ><?php echo set_value('description', isset($art)? $art['description']: ""); ?></textarea>
		
	
	</div> 
	
	<div class="row">
	    <div class="col-md-4">
	        <img src="<?php  echo set_value('img', ($art['img']!="")? base_url("uploads/arts")."/".$art['img']: base_url("uploads/apps/none.jpg")); ?>" class="img-fluid">
	   </div>
	</div>

	<div class="form-group m-t-20">
	
		<label for="img">DISPLAY PICTURE</label>

		<input type="file" class="form-control" name="img" />
	
	</div> 
	
	<div class="row">
	    <div class="col-md-4">
	        <audio controls src="<?php  echo set_value('audio', ($art['audio']!="")? base_url("uploads/arts")."/".$art['audio']: "" ); ?>" class="">
	        </audio>
	   </div>
	</div>

	<div class="form-group m-t-20">
	
		<label for="audio">AUDIO</label>

		<input type="file" class="form-control" name="audio" />
	
	</div> 

    <div class="row">
	    <div class="col-md-4">
	        <video controls width="400px" height="auto" src="<?php  echo set_value('video', ($art['video']!="")? base_url("uploads/arts")."/".$art['video']: "" ); ?>" class="">
	        </video>
	   </div>
	</div>

	<div class="form-group m-t-20">
	
		<label for="audio">VIDEO</label>

		<input type="file" class="form-control" name="video" />
	
	</div> 
    
    	

	<div class="form-group m-t-20">
	
		<label for="sign"> SIGN FOR IMAGE RECOGNITION</label>

		<input class="form-control" type="input" name="sign" value="<?php echo set_value('sign', isset($art)? $art['sign']: ""); ?>" />
	</div> 


	<input type="submit" value="Save" class="btn btn-success m-b-30"/>

</form>

	<div>

		<a href = "<?php echo site_url('art'); ?>" class="btn btn-warning" >

			Back to Artifacts

		</a>
	
	</div>

</div>

</div></div>
