
<footer>
	<section class="footer-area">
		<section id="footer1">
			<div class="container">
        		<div class="row">
			<?php if (is_active_sidebar('footer1')) {
				dynamic_sidebar('footer1');
			}?>
				</div>
			</div>
		</section>
		<section id="footer2">
			<div class="container">
        		<div class="row">
			<?php if (is_active_sidebar('footer2')) {
				dynamic_sidebar('footer2');
			}?>
				</div>
			</div>
		</section>
	</section>
	<section id="copyright">
		<div class="container">
        	<div class="row">
				<div class="col-md-6 col-xs-12">
					<p><?php echo comicpress_copyright(); ?> <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a> Todos os Direitos Reservados.</p>

				</div>
				<div class="col-md-6 col-xs-12">

				</div>
			</div>
		</div>
	</section>
</footer>

<?php
	$toTop = ot_get_option( 'bot_o_para_voltar_ao_topo' );
	if ( function_exists( 'ot_get_option' ) && $toTop === "on" ) {
	  echo "<div id='toTop'>^ Voltar ao topo</div>";
	}
?>

<?php wp_footer(); ?>

</section><!-- /#wrapper -->

<!-- Scripts do tema -->
<?php get_template_part( 'template/footer/scripts', 'tema' ); ?>

</div><!-- /#ip-container -->
</body>
</html>