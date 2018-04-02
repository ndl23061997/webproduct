<html>
    <head>
        <?php $this->load->view('site/head.php');?>
    </head>
    <body>
    <a href="#" id="back_to_top" style="display: block;">
        <img src="<?php echo public_url('site/') ?>images/top.png">
        <div class="wraper">
            <?php $this->load->view('site/header.php');?>

            <div id="container">
                <div class="left">  <!-- Left frame -->
                    <?php $this->load->view('site/left.php');?>
                </div>

                <div class="content">
                    <?php $this->load->view($temp);?>
                </div>

                <div class="right"> <!-- right frame -->
                    <?php $this->load->view('site/right.php');?>
                </div>

                <div class="clear"></div> <!--Clear fix -->
            </div>

            <center>
			    <img src="<?php echo public_url('site/') ?>images/bank.png"> 
            </center>
            
            <div class="footer">
                <?php $this->load->view('site/footer.php');?>
            </div>
        </div>
	  </a>
    </body>
</html>