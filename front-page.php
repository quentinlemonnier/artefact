<?php
/**
 * /front-page.php
 * @package WordPress
 * @subpackage artefact
 * 
 */
    get_header();
?>
<div class="page-title">
    <h1>
    <!-- /front-page.php -->
    <?php
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<?php echo $description; ?>
					<?php endif;
	?>
    </h1>
  <div class="fixed-action-btn horizontal" style="top: 45px; right: 24px; height:56px; z-index:0;">
    <a class="btn-floating btn-large red">
      <i class="large material-icons">widgets</i>
    </a>
    <ul>
      <li><a class="btn-floating blue disabled"><i class="material-icons">bubble_chart</i></a></li>
      <li><a class="btn-floating yellow darken-1 modal-trigger" href="#modal1"><i class="material-icons">date_range</i></a></li>
      <li><a class="btn-floating green modal-trigger" href="#modal2"><i class="material-icons">art_track</i></a></li>
    </ul>
  </div>
    
</div>

<div class="col-md-12">
        <canvas id="viewport" width="400" height="600" style="background:url('<?php echo esc_url( get_template_directory_uri() ); ?>/img/subtle_dots.png');">
        </canvas>
        <script language="javascript" type="text/javascript">
/*
            $("#viewport").attr("height",$(window).height());
            $("#viewport").attr("width",$(".col-md-8").width());

            var sys = arbor.ParticleSystem(4, 2, 10, true, 55);
            sys.screen();
            sys.screenPadding(20, 40, 20, 40);
            sys.renderer = Renderer("#viewport");
            sys.screenSize($("col-md-8").width, $(window).height)
            
            // CLIQUE CANVAS
            var canvas = "#viewport";
*/

        </script>
</div>

    <div id="main"></div>

<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/chronologie.js"></script>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/chronologie-pop.js"></script>
<script>
var sys = arbor.ParticleSystem(6, 2, 10, true, 55);
jQuery(document).ready(function(){
    /*fProgressBar(1);
    var s = skrollr.init({
            forceHeight:true,
            render: function(data) {
            fProgressBar(data.curTop);
   	    }
    });
    skrollr.menu.init(s);*/
    
    getArtistes( '<?php echo esc_url( home_url( '/' ) ); ?>json_a/artist/' );
    getMouvements( '<?php echo esc_url( home_url( '/' ) ); ?>json_m/movement/' );
    
            jQuery("#viewport").attr("height",jQuery(window).height());
            jQuery("#viewport").attr("width",jQuery(".col-md-12").width());
            
            sys.screen();
            sys.screenPadding(20, 40, 20, 40);
            sys.renderer = Renderer("#viewport");
            sys.screenSize(jQuery("col-md-12").width, jQuery(window).height)
            
            // CLIQUE CANVAS
            var canvas = "#viewport";
    
    /*var c=document.getElementById("viewport");
    var ctx_style=c.getContext("2d");
    ctx_style.font="30px Arial";
    ctx_style.fillText("Hello World",10,50);*/
    
    /*$(function() {
      $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
      });
      
      
    });*/
    
    $('.modal-trigger').leanModal();
    
});
          
    
</script>

    <!-- MODAL WIP -->

  <!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h4>Classement chronologique</h4>
      <p>Work in progress...</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ok</a>
    </div>
  </div>
  <!-- Modal Structure -->
  <div id="modal2" class="modal">
    <div class="modal-content">
      <h4>Classement par mouvement artistique</h4>
      <p>Work in progress...</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ok</a>
    </div>
  </div>


<?PHP
    get_footer();
?>
