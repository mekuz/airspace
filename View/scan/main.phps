<!doctype html>
<html>
    <head>
        <script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
        <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar-nft.js"></script>
        <script src="https://raw.githack.com/AR-js-org/studio-backend/master/src/modules/marker/tools/gesture-detector.js"></script>
        <script src="https://raw.githack.com/AR-js-org/studio-backend/master/src/modules/marker/tools/gesture-handler.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        
        <style>
          .arjs-loader {
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
          }
        
          .arjs-loader div {
            text-align: center;
            font-size: 1.25em;
            color: white;
          }
        </style>
        
        <script>
       
          
        
           let curr=-3;
           
            let arts = <?php echo json_encode($arts);?>; //get art works
            
              AFRAME.registerComponent('markerhandler', {
                   schema: {type: 'string'},
                  init: function () {
                      this.entities = document.querySelectorAll('a-nft');
                    // Don't call query selector in here, query beforehand.
                    //names of artifacts
                    
                    for (let i = 0; i < arts.length; i++) {
                      // Do something with entities.
                       this.entities[i].addEventListener('markerFound', () => {
                            if(arts[i].name != curr){
                                //new val
                                curr = arts[i].name;//set new curr
                                
                                //set new name
                                $("#name").html(curr);
                                //set href of more
                                $("#more").attr("href", "<?php echo base_url('art/view')."/"; ?>"+arts[i].id);
                                $("#more").show();
                                //play audio file
                                playAudio(i);
                                
                                //increase the number of hits on this
                                $.ajax({url: "<?php echo base_url('art/hit')."/"; ?>"+arts[i].id, success: function(result){
                                
                                  }});
                            }//end if
                      })
                    }//end for
                  }//end init
                });//end ref component
            
            $(document).ready(function(){
                //hide the more button
                   $("#more").hide();
                });//end ready
                
                 
                function playAudio(track)
                {
                     //set source
                    $("#aplayer").attr("src", "<?php echo base_url("uploads/arts")."/"; ?>" +arts[track].audio);
                    //get player
                    let aplayer = $("#aplayer");
                     aplayer[0].pause();
                     aplayer[0].load();//suspends and restores all audio element
                }//end track
           
            
        </script>
    </head>
    
    
    

    <body style="margin: 0; overflow: hidden; height:500px">
        
        <div class="arjs-loader">
            <div>Loading, please wait...</div>
         </div>
        
        <a-scene
            vr-mode-ui="enabled: true;"
            loading-screen="enabled: false;"
             renderer="logarithmicDepthBuffer: true;"
            arjs="trackingMethod: best; sourceType: webcam; debugUIEnabled: false;"
            id="scene"
            embedded
            gesture-detector
            
        >

         <?php foreach ($arts as $art):?>   
                
            <a-nft
                markerhandler
              type="nft"
              url="https://ar.wishygifty.com/uploads/nft/<?php echo $art['sign']?>"
              smooth="true"
              smoothCount="10"
              smoothTolerance=".01"
              smoothThreshold="5"
            >
               
              
               
            </a-nft>
        
        <?php endforeach; ?>
           

            <a-entity camera></a-entity>
        </a-scene>
        
        <style>
            .ova{
                border-radius: 5px;
               position: fixed;
               padding:10px;
                z-index: 10;
                font-size: 1.5em;
                color: black;
                left: 20px;
                bottom: 1em;
                background: rgba(255,255,255,0.9);
                width: calc(100% - 40px);
            }
            
            .name-box{
                text-align: center;
            }
            
            .a-enter-ar-button, .a-enter-vr-button{
                z-index : 20;
                
            }
            
        </style>
        <div class="ova">
            <div class="name-box">
                <span id="name">Focus on an Artifact</span>
            </div>
            
            <div>
                <audio id="aplayer" src="" controls autoplay >
              
                </audio>
            </div>
            
            <div>
                 <a id="more">Click Here for More Details</a>
            </div>
            
        </div>
    </body>
</html>
