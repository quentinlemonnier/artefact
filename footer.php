<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
    </div><!-- #content -->
</div><!-- #page -->
    <footer>
        <p>[Work In Progress] &copy; 2016</p>
        
    </footer>

<!-- 
 /*
  * POP
  */
-->
    <div id="popMouvement">
     <div class="fixed-action-btn horizontal" style="top: 45px; right: 24px; height:56px; z-index:0;">
    <a class="btn-floating btn-large lime darken-2 popClose" onclick="jQuery('#popMouvement').fadeOut();return false;"><i class="material-icons">clear</i></a></div>
        <div class="header"><h1>Bauhaus</h1></div>
        <div class="content">École d'art appliqués fondée en 1919 à Weimar par l'architecte Walter Gropius. Pour lui la complexité du monde moderne doit répondre à une esthétique nouvelle, fonctionnelle et épurée.</div>
        <ul class="artistes"><li><a href="#Tschicold">Tschicold</a></li><li><a href="#Bill">Bill</a></li></ul>
    </div>
    
    <div id="popArtiste">
    <div class="fixed-action-btn horizontal" style="top: 45px; right: 24px; height:56px; z-index:0;">
    <a class="btn-floating btn-large red popClose" onclick="jQuery('#popArtiste').fadeOut();return false;"><i class="material-icons">clear</i></a></div>
        <table>
            <tr>
                <td><img src="images/artistes/josef-muller-brockmann_p.jpg" class="circle">
                    <h1>Josef Müller-Brockmann</h1>
                    <h2 class="hide">1914 - 1996</h2>
                    <h3 class="work hide">typographe, graphiste.</h3>
                    <h4 class="mouvement hide">style internationale suisse</h4>
                    <!--<a href="#" onclick="scrollArtiste($('#popArtiste h1').attr('dataNom'),0);return false" target="_blank" class="chronologie">Position chronologique</a>-->
                    <a href="#" class="source waves-effect waves-light btn red" >Lire la suite</a>
                </td>
                <td><!--<div class="circle colorBg2">Müller-Brockamnn</div>-->
                    <a href="images/artistes/muller_brockmann_beethoven.jpg" target="_blank"><img src="" class="oeuvre"></a>
                    <h5 class="condensed hide">2012 Oeuvre</h4>
                    <h6 class="condensed hide">Cartel</h5>
                </td>
            </tr>
        </table>
        <div style="position:absolute;top:0;left:0;right:0;bottom:0;overflow:hidden;opacity:0.2;z-index:-1">
            <img src="" class="oeuvre" width="100%" style="max-width:100%">
        </div>
    </div>

<?php wp_footer(); ?>

    <script>
        function toggleSidebar() {
            $(".sidebar").addClass("sidebar-min");
           $(".wrap").addClass("wrap-large");
        }

        /*$(document).ready(function(){
              //$('.fixed-action-btn').openFAB()
            $(".popClose.").click(function)({
                $(this).parent().fadeOut();
            });
        });*/
        
    </script>
</body>
</html>
