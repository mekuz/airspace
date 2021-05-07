 
    <style>
        .art-img{
            //max-height:200px;
        }
    </style>
    
	<div class="card col-md-8 offset-md-2" style="">
     <img src="<?php  echo  base_url("uploads/arts")."/".$art['img']; ?>" class="img-fluid">

      <div class="card-body"  style="text-align: center">
        <h3 class="card-title text-primary"> <?php echo $art['name'] ?></h3>
        
       
        
		<h4 class="card-text"><?php echo $art['description'] ?></h4>
		
        
	</div>
    </div>
    
    <div class="card col-md-8 offset-md-2" style="">
      <div class="card-body"  style="text-align: center">
        <h3 class="card-title text-primary"> Additional Media </h3>
		<?php if(isset($art['video'])): ?> 
             <video controls src="<?php  echo  base_url("uploads/arts")."/".$art['video']; ?>" class="img-fluid">
                 
            </video>
        <?php endif; ?>
        
        <br>
        
        <?php if(isset($art['audio'])): ?> 
             <audio controls src="<?php  echo  base_url("uploads/arts")."/".$art['audio']; ?>" class="">
                 
            </audio>
        <?php endif; ?>
        
        <br>
        </div>
    </div>
    
    
    <div class="card col-md-8 offset-md-2" style="">
            
            <img class="la-store" src="<?php  echo  base_url("uploads/arts/store.jpg"); ?>" class="img-fluid">
      
        <br>
     <a class="text-white btn btn-success" href="https://paystack.shop/air-space">Buy a replica from the Museum Store...</a>
        
	</div>
    
    <script>
        $('.la-store').click(function(){
            window.location.href = "https://paystack.shop/air-space";
        });//end on click
    </script>
