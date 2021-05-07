<style>
    .art-img{
        height:250px !important;
      
    }
</style>
    <div>
        <h3> Hello! </h3>
    </div>
        
        
     
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <span class="fa-stack fa-2x">
                      <i class="fa fa-circle fa-stack-2x text-info"></i>
                      <i class="fa fa-building fa-stack-1x text-white"></i>
                    </span>
                    <span class="h6">Number of Visitors: <i class="currency"><?php echo 1,407;  ?></i></span>
                </div>
                 <div class="col-md-4">
                    <span class="fa-stack fa-2x">
                      <i class="fa fa-circle fa-stack-2x text-success"></i>
                      <i class="fa fa-money fa-stack-1x"></i>
                    </span>
                    <span class="h6">Revenue: NGN <i class="currency"><?php echo 325,123;?></i></span>
                </div>
                 <div class="col-md-4">
                    <span class="fa-stack fa-2x">
                      <i class="fa fa-circle fa-stack-2x text-warning"></i>
                      <i class="fa fa-usd fa-stack-1x"></i>
                    </span>
                    <span class="h6">Merchandise: NGN <i class="currency"><?php echo 102,300 ?></i></span>
                </div>
                
                
            </div>
           
        </div>
    </div>


     <div class="row el-element-overlay">
         <?php foreach($arts as $art): ?>
                
                    <div class="col-lg-4 col-md-4">
                        <a href="<?php echo base_url('art/view/'.$art['id']);?>">
                        <div class="card">
                            <div class="el-card-item">
                                <div class="el-card-avatar el-overlay-1">
                                
                                <img src="<?php  echo set_value('img', ($art['img']!="")? base_url("uploads/arts")."/".$art['img']: base_url("uploads/apps/none.jpg")); ?>" class="img-fluid art-img">
	  
                                 
                                </div>
                                <div class="el-card-content">
                                    <h4 class="m-b-0"><?php echo $art['name'];?></h4> <span class="text-muted"><?php echo $art['short_description'];?></span>
                                    <br>
                                   
                                   
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
        <?php endforeach; ?>
       
        
       
    </div><!--end row--->
