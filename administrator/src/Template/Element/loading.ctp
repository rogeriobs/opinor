<div id="loading">
    <div class="overlay-loading"></div>
    <div class="box-img">
        <div class="cssload-wrap">
            <div class="cssload-thecube">
                <div class="cssload-cube cssload-c1"></div>
                <div class="cssload-cube cssload-c2"></div>
                <div class="cssload-cube cssload-c4"></div>
                <div class="cssload-cube cssload-c3"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function showLoading(){
        
        if($("#loading").css("display") == 'none'){
            $("#loading").fadeIn(200);
        }             
     
    }
    
    function hideLoading(){
        $("#loading").fadeOut(100);
    }
</script>
